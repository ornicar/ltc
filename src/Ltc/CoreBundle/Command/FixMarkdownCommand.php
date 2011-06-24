<?php

namespace Ltc\CoreBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Ltc\CoreBundle\MarkdownFixer;

class FixMarkdownCommand extends ContainerAwareCommand
{
    /**
     * @see Command
     */
    protected function configure()
    {
        $this
            ->setName('ltc:fix-markdown')
            ->setDescription('Fixes the markdown texts');
    }

    /**
     * @see Command
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        print 'Fixing';
        $fixer = new Fixer();
        foreach ($this->getDocs() as $doc) {
            foreach (array('summary', 'body') as $field) {
                $old = $doc->{'get'.$field}();
                $new = $fixer->fix($old);
                $doc->{'set'.$field}($new);
                print '.';
            }
            print ',';
        }
        $output->writeLn('Flushing');
        $this->getContainer()->get('doctrine.odm.mongodb.document_manager')->flush();
        $output->writeLn('Done');
    }

    protected function getDocs()
    {
        return array_merge(
            $this->getContainer()->get('ltc_article.repository.article')->findAll()->toArray(),
            $this->getContainer()->get('ltc_blog.repository.blog_entry')->findAll()->toArray()
        );
    }
}
