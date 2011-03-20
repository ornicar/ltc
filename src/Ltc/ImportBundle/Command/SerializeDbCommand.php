<?php

namespace Ltc\ImportBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Output\Output;

use Ltc\ImportBundle\DbSerializer;
use Ltc\ImportBundle\MysqlDb;

class SerializeDbCommand extends Command
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
            ->setName('ltc:db:serialize')
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
        $path = $this->container->getParameter('kernel.root_dir').'/db';
        @mkdir($path);

        $serializer = new DbSerializer($mysql, $path);
        $serializer->serialize();
    }
}
