<?php

namespace HeavyCodeGroup\LinkPub\IndexerBundle\Command;

use HeavyCodeGroup\LinkPub\BaseBundle\Command\BaseCommand;
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

    private function scanSite(Site $site)
    {
        $urlRootPage = $site->getRootUrl();
        $crawlerRootPage = $this->loadUrl($urlRootPage);

        if (false !== $crawlerRootPage) {
            $existingSitePages = $site->getPages();

        } else {
            $this->output->writeln("<error>Error site path URL</error>");
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

    private function getAllLinks($url)
    {
        $crawlerPage = $this->loadUrl($url);

        if (false !== $crawlerPage) {
            return $crawlerPage->filter('a');
        } else {
            return false;
        }
    }
}
 