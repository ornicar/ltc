<?php

namespace Ltc\CoreBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Ltc\CoreBundle\MarkdownFixer;

class RemoveReferenceUrlCommand extends ContainerAwareCommand
{
    /**
     * @see Command
     */
    protected function configure()
    {
        $this
            ->setName('ltc:remove-ref-url')
            ->setDescription('Removes esmereee urls from doc references');
    }

    /**
     * @see Command
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeLn('Removing');
        $this->getContainer()->get('ltc_blog.repository.blog_entry')->removeUrlsFromReferences();
        $this->getContainer()->get('ltc_article.repository.article')->removeUrlsFromReferences();
        $output->writeLn('Flushing');
        $this->getContainer()->get('doctrine.odm.mongodb.document_manager')->flush();
        $output->writeLn('Done');
    }
}
