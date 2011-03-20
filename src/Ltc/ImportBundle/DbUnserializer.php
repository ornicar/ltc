<?php

namespace Ltc\ImportBundle;

class DbUnSerializer
{
    protected $path;

    public function __construct($path)
    {
        $this->path = $path;
    }

    public function unserialize($table)
    {
        $file = $this->path.'/'.$table;

        return unserialize(file_get_contents($file));
    }
}
