<?php

namespace HeavyCodeGroup\LinkPub\IndexerBundle\Command;

use Guzzle\Common\Exception\GuzzleException;
use GuzzleHttp\Message\Response;
use HeavyCodeGroup\LinkPub\BaseBundle\Command\BaseCommand;
use HeavyCodeGroup\LinkPub\IndexerBundle\Exception\SiteNotFoundException;
use HeavyCodeGroup\LinkPub\StorageBundle\Doctrine\DBAL\PageStatusType;
use HeavyCodeGroup\LinkPub\StorageBundle\Entity\Page;
use HeavyCodeGroup\LinkPub\StorageBundle\Entity\Site;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\DomCrawler\Crawler;
use GuzzleHttp\Client;

class SiteIndexCommand extends BaseCommand
{
    /** @var Client */
    protected $client;

    /**
     * {@inheritDoc}
     */
    protected function configure()
    {
        $this
            ->setName('linkpub:site:index')
            ->addArgument('url', InputArgument::REQUIRED)
        ;
    }

    protected function initialize(InputInterface $input, OutputInterface $output)
    {
        $this->client = new Client();
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @throws SiteNotFoundException
     * @return int|null|void
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->initIO($input, $output);

        $url = $input->getArgument('url');
        $siteToScan = $this
            ->getContainer()
            ->get('doctrine.orm.entity_manager')
            ->getRepository('LinkPubStorageBundle:Site')
            ->findOneBy(['rootUrl' => $url])
        ;

        if (!$siteToScan) {
            $output->writeln("<error>Site $url not registered in DB</error>");
            throw(new SiteNotFoundException);
        }

        $output->writeln("<info>Started indexing site $url</info>");
        $this->scanSite($siteToScan);
        $output->writeln("<info>Indexing of $url successfully complete</info>");
    }

    /**
     * @param Site $site
     */
    private function scanSite(Site $site)
    {
        $this->setRootPage($site);

        $indexedPagesCurrentSession = [ ['link' => $site->getRootUrl(), 'parent' => false] ];
        $queueLength = 1;

        for ($i = 0; $i < $queueLength; $i++) {
            $linksOnPage = $this->getAllLinks($indexedPagesCurrentSession[$i]['link']);

            if (false !== $linksOnPage) {
                $linksOnPage = array_unique(
                    $this->filterHost(
                        $linksOnPage,
                        $site->getRootUrl()
                    )
                );

                foreach ($linksOnPage as $linkOnPage) {
                    if (!$this->isInQueue($linkOnPage, $indexedPagesCurrentSession)) {
                        $indexedPagesCurrentSession[] = ['link' => $linkOnPage, 'parent' => $indexedPagesCurrentSession[$i]['link']];
                        $queueLength++;
                    }
                }

                $pageInIndex = $this->getFromIndex($indexedPagesCurrentSession[$i]['link'], $site);

                if (!$pageInIndex) {
                    $path = $this->getPath($indexedPagesCurrentSession[$i]['link']);
                    if ($path) {
                        $parent = $this->findPageByUrl($indexedPagesCurrentSession[$i]['parent'], $site);
                        $page = new Page();
                        $page
                            ->setSite($site)
                            ->setUrl($path)
                            ->setState(PageStatusType::STATUS_DISABLED)
                        //TODO: set real parameters, calculate in dependency of system work
                            ->setCapacity(3)
                            ->setPrice(5)
                        ;

                        if ($parent) {
                            $page->addParent($parent);
                        }

                        $this->getEntityManager()->persist($page);
                        $this->getEntityManager()->flush();
                        $this->output->writeln("Added page {$indexedPagesCurrentSession[$i]['link']} to index");

                    }
                } else {
                    $this->addParent($pageInIndex, $site, $indexedPagesCurrentSession[$i]['parent']);
                }
            }
        }
    }

    private function addParent(Page $page, $site, $parentUrl)
    {
        if ($parentUrl && !$this->isParent($page, $this->findPageByUrl($parentUrl, $site))) {
            $page->addParent(
                $this->findPageByUrl($parentUrl, $site)
            );
        }
    }

    private function setRootPage(Site $site)
    {
       if (!$site->getRootPage()) {
            $loadedPage = $this->sendGetRequest($site->getRootUrl());
            $page = new Page();
            $page
                ->setSite($site)
                ->setUrl($this->getPath($loadedPage->getEffectiveUrl()))
                ->setState(PageStatusType ::STATUS_DISABLED)
                //TODO: set real parameters, calculate in dependency of system work
                ->setCapacity(3)
                ->setPrice(5)
            ;
            $site->setRootPage($page);
            $this->getEntityManager()->persist($page);
            $this->getEntityManager()->flush();
        }
    }

    private function getPath($url)
    {
        $parsedUrl = parse_url($url);

        if (isset($parsedUrl['path'])) {

            return ($parsedUrl['path'] . ((isset($parsedUrl['query'])) ? $parsedUrl['query'] : ''));
        } else {

            return '/';
        }
    }

    private function getHostName($url)
    {
        $parcedUrl = parse_url($url);

        if (isset($parcedUrl['scheme']) && isset($parcedUrl['host'])) {

            return ($parcedUrl['scheme'] . '://' . $parcedUrl['host']);
        } else {

            return false;
        }
    }

    /**
     * @param $url
     * @param Site $site
     * @return bool|Page
     */
    private function findPageByUrl($url, Site $site)
    {
        foreach ($site->getPages() as $page) {
            if ($page->getUrl() == $this->getPath($url)) {
                return $page;
            }
        }

        return false;
    }

    /**
     * @param $url
     * @param Site $site
     * @return bool|Page
     */
    private function getFromIndex($url, Site $site)
    {
        foreach ($site->getPages() as $page) {
            if ($page->getUrl() == $this->getPath($url)) {

                return $page;
            }
        }

        return false;
    }

    /**
     * @param $link
     * @param array $queue
     * @return bool
     */
    private function isInQueue($link, array $queue)
    {
        foreach ($queue as $queueLink) {
            if ($link == $queueLink['link']) {
                return true;
            }
        }

        return false;
    }

    private function isParent(Page $page, Page $parentPage)
    {
        if (false == $parentPage) {
            return false;
        }

        foreach ($page->getParents() as $parent) {
            if ($parent == $parentPage) {
                return true;
            }
        }

        return false;
    }
    /**
     * @param array $links
     * @param $host
     * @return array
     */
    private function filterHost(array $links, $host)
    {
        $result = [];

        foreach ($links as $link) {
            if ($this->getHostName($link) == $host) {
                $result[] = $link;
            }
        }

        return $result;
    }

    /**
     * @param $url
     * @return Response|false
     */
    private function sendGetRequest($url)
    {
        try {

            return $this->client->get($url);
        } catch (\Exception $e) {
            $this->output->writeln("<error>Error while loading $url</error>");

            return false;
        }
    }

    /**
     * @param $url
     * @return bool|array
     */
    private function getAllLinks($url)
    {
        $response = $this->sendGetRequest($url);
        $body = $response->getBody()->__toString();
        $crawlerPage = new Crawler($body);

        if (false !== $crawlerPage) {
            return $crawlerPage->filter('a')->each(function(Crawler $node) {
                return rtrim($node->link()->getUri(), '/');
            });
        } else {
            return false;
        }
    }
}
