<?php

namespace Ltc\ImportBundle\Db;

use Ltc\ImportBundle\MysqlDb;
use Doctrine\ODM\MongoDB\DocumentManager;

abstract class AbstractImporter
{
    protected $manager;
    protected $mysql;

    public function __construct(DocumentManager $manager, MysqlDb $mysql)
    {
        $this->manager = $manager;
        $this->mysql           = $mysql;
    }

    protected function persist($object)
    {
        $this->manager->persist($object);
    }

    protected function flush()
    {
        $this->manager->flush();
    }
}
