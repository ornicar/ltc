<?php

namespace Ltc\ImportBundle;

use FOS\UserBundle\Document\UserManager;
use Doctrine\ODM\MongoDB\DocumentManager;
use Closure;

class DbImport
{
    protected $documentManager;
    protected $userManager;
    protected $mysql;
    protected $loggerCallback;

    public function __construct(DocumentManager $documentManager, UserManager $userManager, MysqlDb $mysql, Closure $loggerCallback)
    {
        $this->documentManager = $documentManager;
        $this->userManager     = $userManager;
        $this->mysql           = $mysql;
        $this->loggerCallback  = $loggerCallback;
    }

    public function execute()
    {
        $this->log('Import users');
        $importer = new Db\UserImporter($this->documentManager, $this->mysql);
        $importer->setUserManager($this->userManager);
        $importer->import();

        $this->log('Import categories');
        $importer = new Db\CategoryImporter($this->documentManager, $this->mysql);
        $importer->import();

        $this->log('Import articles');
        $importer = new Db\ArticleImporter($this->documentManager, $this->mysql);
        $importer->setUserManager($this->userManager);
        $importer->import();
    }

    protected function log($message)
    {
        $logger = $this->loggerCallback;
        $logger($message);
    }
}
