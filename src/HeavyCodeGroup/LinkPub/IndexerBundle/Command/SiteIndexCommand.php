<?php

namespace HeavyCodeGroup\LinkPub\IndexerBundle\Command;

use Doctrine\Common\Collections\ArrayCollection;
use HeavyCodeGroup\LinkPub\BaseBundle\Command\BaseCommand;
use HeavyCodeGroup\LinkPub\IndexerBundle\Exception\SiteNotFoundException;
use HeavyCodeGroup\LinkPub\StorageBundle\Entity\Page;
use HeavyCodeGroup\LinkPub\StorageBundle\Entity\Site;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\DomCrawler\Crawler;
use Goutte\Client;

class SiteIndexCommand extends BaseCommand
{
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
        //TODO: Write more code
        $output->writeln("<info>Indexing of $url successfully complete</info>");
    }

    /**
     * @param Site $site
     */
    private function scanSite(Site $site)
    {
        $indexedPagesCurrentSession = [ ['link' => $site->getRootUrl(), 'parent' => false] ];
        $queueLength = 1;

        for ($i = 0; $i < $queueLength; $i++) {
            $pageInIndex = $this->isInIndex($indexedPagesCurrentSession[$i]['link'], $site);

            if (!$pageInIndex) {
                $page = new Page();
                $page
                    ->setSite($site)
                    ->setUrl($indexedPagesCurrentSession[$i])
                    ->addParent($indexedPagesCurrentSession[$i]['parent'])
                ;
                $this->output->writeln("Added page {$indexedPagesCurrentSession[$i]['link']} to index");
                $this->getEntityManager()->persist($page);
            } else {
                if ($indexedPagesCurrentSession[$i]['parent']) {
                    $pageInIndex->addParent($indexedPagesCurrentSession[$i]['parent']);
                }
            }

            $linksOnPage = array_unique(
                $this->filterHost(
                    $this->getAllLinks($indexedPagesCurrentSession[$i]['link']),
                    $site->getRootUrl()
                )
            );

            foreach ($linksOnPage as $linkOnPage) {
                if (!$this->isInQueue($linkOnPage, $indexedPagesCurrentSession)) {
                    $indexedPagesCurrentSession[] = ['link' => $linkOnPage, 'parent' => $indexedPagesCurrentSession[$i]['link']];
                    $queueLength++;
                }
            }
        }

        $this->getEntityManager()->flush();
    }

    /**
     * @param array $links
     * @param $parentUrl
     * @return array
     */
    private function setParent(array $links, $parentUrl)
    {
        $linksWithParent = [];

        foreach ($links as $link) {
            $linksWithParent[] = ['link' => $link, 'parent' => $parentUrl];
        }

        return $linksWithParent;
    }

    /**
     * @param $url
     * @param Site $site
     * @return bool|Page
     */
    private function isInIndex($url, Site $site)
    {
        $parcedUrl = parse_url($url);

        if (isset($parcedUrl['path'])) {
            foreach ($site->getPages() as $page) {
                if ($page->getUrl() == $parcedUrl['path']) {
                    return $page;
                }
            }
        } else {
            return false;
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

    /**
     * @param array $links
     * @param $host
     * @return array
     */
    private function filterHost(array $links, $host)
    {
        $result = [];

        foreach ($links as $link) {
            $parsedUrl = parse_url($link);
            if ( isset($parsedUrl['scheme'])
                    &&
                 isset($parsedUrl['host'])
                    &&
                 $parsedUrl['scheme'] . '://' . $parsedUrl['host'] == $host
            ) {
                $result[] = $link;
            }
        }

        return $result;
    }

    /**
     * @param $url
     * @return Crawler|false
     */
    private function loadUrl($url)
    {
        try {
            $client = new Client();

            return $client->request('GET', $url);
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
        $crawlerPage = $this->loadUrl($url);

        if (false !== $crawlerPage) {
            return $crawlerPage->filter('a')->each(function(Crawler $node) {
                return $node->link()->getUri();
            });
        } else {
            return false;
        }
    }

    /**
     * @param string $url
     * @param Page[]|ArrayCollection $pages
     * @return bool
     */
    private function isNewInDBIndex($url, ArrayCollection $pages)
    {
        foreach ($pages as $page) {
            if ($page->getFullUrl() == $url) {
                return true;
            }
        }

        return false;
    }
}
