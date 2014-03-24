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
        $urlRootPage = $site->getRootUrl();
        $linksRootPage = array_unique($this->getAllLinks($urlRootPage));
        $indexedPages = $this->filterHost($linksRootPage, $urlRootPage);
        $goDeeper = true;

        if (false !== $linksRootPage) {
            $existingSitePages = $site->getPages();

            while ($goDeeper) {
                //if ()
            }
        } else {
            $this->output->writeln("<error>Site is not available. Posibble, connections problems</error>");
        }
    }

    private function filterHost(array $links, $host)
    {
        $result = [];

        foreach ($links as $link) {
            $parsedUrl = parse_url($link);

            if ( $parsedUrl['scheme'] . '://' .$parsedUrl['host'] == $host) {
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
