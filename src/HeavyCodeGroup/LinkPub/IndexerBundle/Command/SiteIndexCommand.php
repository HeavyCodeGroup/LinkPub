<?php

namespace HeavyCodeGroup\LinkPub\IndexerBundle\Command;

use Doctrine\Common\Collections\ArrayCollection;
use HeavyCodeGroup\LinkPub\BaseBundle\Command\BaseCommand;
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
     * @return int|null|void
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->initIO($input, $output);

        $url = $input->getArgument('url');

        $output->writeln("<info>Started indexing site $url</info>");
        //TODO: Write code
        $output->writeln("<info>Indexing of $url successfully complete</info>");
    }

    /**
     * @param Site $site
     */
    private function scanSite(Site $site)
    {
        $urlRootPage = $site->getRootUrl();
        $linksRootPage = $this->getAllLinks($urlRootPage);
        $goDeeper = true;

        if (false !== $linksRootPage) {
            $pagesIndex = array();
            $existingSitePages = $site->getPages();

            while ($goDeeper) {
            //TODO: Write code
            }
        } else {
            $this->output->writeln("<error>Site is not available. Posibble, connections problems</error>");
        }
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
     * @return bool|Crawler
     */
    private function getAllLinks($url)
    {
        $crawlerPage = $this->loadUrl($url);

        if (false !== $crawlerPage) {
            return $crawlerPage->filter('a');
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
