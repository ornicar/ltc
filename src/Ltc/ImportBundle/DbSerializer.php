<?php

namespace Ltc\ImportBundle;

class DbSerializer
{
    protected $mysql;
    protected $path;

    protected $tables = array(
        'pap_dossier',
        'pap_article',
        'pap_actu',
        'pap_article_tag',
        'pap_comment',
        'pap_evenement',
        'pap_fichier',
        'pap_publication',
        'pap_tag',
        'lien'
    );

    public function __construct(MysqlDb $mysql, $path)
    {
        $this->mysql = $mysql;
        $this->path  = $path;
    }

    public function serialize()
    {
        foreach ($this->tables as $table) {
            $file = $this->path.'/'.$table;
            $data = $this->mysql->tableToArray($table);
            $serialized = serialize($data);
            file_put_contents($file, $serialized);
        }
    }
}
