<?php

namespace Ltc\ConfigBundle;

class ConfigManager
{
    protected $configs;

    public function __construct(array $configs)
    {
        $this->configs = $configs;
    }

    public function getConfigs()
    {
        return $this->configs;
    }

    /**
     * Gets one config by its key
     *
     * @return Config
     **/
    public function getConfig($key)
    {
        if (!isset($this->configs[$key])) {
            throw new InvalidArgumentException();
        }

        return $this->configs[$key];
    }

    public function getConfigKeys()
    {
        return array_keys($this->configs);
    }
}
