<?php

namespace Ltc\ImportBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Output\Output;

use Doctrine\Common\DataFixtures\Purger\MongoDBPurger;

use Ltc\ImportBundle\DbImport;
use Ltc\ImportBundle\MysqlDb;

class ImportDbCommand extends Command
{
    /**
     * @see Command
     */
    protected function configure()
    {
        $this
            ->setDefinition(array(
                new InputArgument('username', InputArgument::REQUIRED, 'mysql username'),
                new InputArgument('password', InputArgument::REQUIRED, 'mysql password'),
            ))
            ->setName('ltc:import:db')
        ;
    }

    /**
     * @see Command
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $dsn = "mysql:host=localhost;dbname=lestroiscouronnes";
        $mysql = new MysqlDb(
            $dsn,
            $input->getArgument('username'),
            $input->getArgument('password')
        );

        $documentManager = $this->container->get('doctrine.odm.mongodb.document_manager');
        $userManager = $this->container->get('fos_user.user_manager');

        $import = new DbImport($documentManager, $userManager, $mysql, function($message) use ($output) {
            $output->writeLn($message);
        });

        $output->writeLn('Purge database');
        $purger = new MongoDBPurger($documentManager);
        $purger->purge();

        $import->execute();
    }
}
