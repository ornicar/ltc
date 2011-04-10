<?php

namespace Ltc\CoreBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Ltc\MarkdownBundle\Fixer;

class FixMarkdownCommand extends Command
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
        $this->container->get('doctrine.odm.mongodb.document_manager')->flush();
        $output->writeLn('Done');
    }

    protected function getDocs()
    {
        return array_merge(
            $this->container->get('ltc_article.repository.article')->findAll()->toArray(),
            $this->container->get('ltc_blog.repository.blog_entry')->findAll()->toArray()
        );
    }
}
