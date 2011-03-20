<?php

namespace Ltc\ImportBundle\Db;

use Ltc\ArticleBundle\Document\Category;

class CategoryImporter extends AbstractImporter
{
    const TABLE = 'pap_dossier';
    const TYPE_IDOC = 1;

    public function import()
    {
        $arrays = $this->mysql->tableToArray(self::TABLE);

        foreach ($arrays as $a) {
            if ($a['type_id'] != self::TYPE_IDOC) {
                continue;
            }
            $o = new Category();
            $o->setTitle($a['nom']);
            $o->setSubtitle($a['titre']);
            $o->setSummary($a['description']);
            $o->setTitle($a['nom']);
            $o->setSlug($a['code']);
            $o->setPosition($a['rank']);
            $this->persist($o);
        }

        $this->flush();
    }
}
