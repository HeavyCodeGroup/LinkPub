<?php

namespace HeavyCodeGroup\LinkPub\ConsumerBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Filesystem\Exception\IOException;

class InstallCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this->setName('consumer:install')
            ->setDescription('Install new consumer prototype')
            ->addArgument('tarball', InputArgument::REQUIRED, 'Filename of tarball with consumer code');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        /**
         * @var \Symfony\Component\Filesystem\Filesystem $filesystem
         */
        $filesystem = $this->getContainer()->get('filesystem');
        $tarball = $input->getArgument('tarball');

        if (!is_file($tarball)) {
            throw new \InvalidArgumentException('Tarball must be a file.');
        }

        if (!preg_match('/\.tar\.(?:bz2|gz)$/i', $tarball)) {
            throw new \InvalidArgumentException('Tarball must have .tar.gz or .tar.bz2 extension.');
        }

        $tempDirectory = $this->getContainer()->getParameter('link_pub_consumer.installer.tmp');
        do {
            $tempDirectorySuffix = uniqid('consumer_install_');
        } while (is_dir($tempDirectory . '/' . $tempDirectorySuffix));
        $tempDirectory .= '/' . $tempDirectorySuffix;

        $filename = basename($tarball);
        $filesystem->copy($tarball, $tempDirectory . '/' . $filename, true);

        $pharData = new \PharData($tempDirectory . '/' . $filename);
        $pharData = $pharData->decompress();
        $filesystem->mkdir($tempDirectory . '/work', 0700);
        if (!$pharData->extractTo($tempDirectory . '/work')) {
            throw new IOException('Failed to extract tarball');
        }

        /**
         * @var \HeavyCodeGroup\LinkPub\ConsumerBundle\Tool\InstallerTool $installer
         */
        $installer = $this->getContainer()->get('link_pub_consumer.installer');
        $installer->installFromDirectory($tempDirectory . '/work');

        $filesystem->remove($tempDirectory);
    }
}
