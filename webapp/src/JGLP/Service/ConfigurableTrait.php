<?php

namespace JGLP\Service;

trait ConfigurableTrait
{
    protected $config = [];

    /**
     * Return configuration value if key given, else return array of config.
     *
     * @param null|string $key
     * @param null|mixed  $default If key is given but not present, return this default value instead.
     *
     * @return array|mixed
     */
    public function getConfig($key = null, $default = null)
    {
        if (null === $key) {
            return $this->config;
        }
        
        return array_key_exists((string) $key, $this->config) ? $this->config[(string) $key] : $default;
    }

    /**
     * Sets config value for the given key if string key given, or sets entire config if array given.
     *
     * @param array|string $config Provide an array of config or a single config key.
     * @param null|mixed   $value  Ignored if the first parameter is an array.
     *
     * @return $this
     */
    public function setConfig($config, $value = null)
    {
        if (is_array($config)) {
            $this->config = $config;
        } else {
            $this->config[(string) $key] = $value;
        }

        return $this;
    }
}