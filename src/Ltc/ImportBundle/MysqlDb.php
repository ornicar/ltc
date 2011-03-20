<?php

namespace Ltc\ImportBundle;

use PDO;
use PDOException;

class MysqlDb
{
    protected $db;

    public function __construct($dsn, $user, $password)
    {
        $options = array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES \'latin1\'');
        $this->db = new PDO($dsn, $user, $password, $options);
    }

    public function tableToArray($tableName)
    {
        $sth = $this->db->prepare("SELECT * FROM ".$tableName);
        $sth->execute();

        $array = $sth->fetchAll(PDO::FETCH_ASSOC);
        //foreach ($array as $key => $row) {
            //$array[$key] = array_map('utf8_decode', $row);
        //}

        return $array;
    }
}
