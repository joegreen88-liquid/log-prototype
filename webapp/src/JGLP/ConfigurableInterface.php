<?php

namespace JGLP;

interface ConfigurableInterface
{
    /**
     * Return configuration value if key given, else return array of config.
     *
     * @param null|string $key
     * @param null|mixed  $default If key is given but not present, return this default value instead.
     *
     * @return array|mixed
     */
    public function getConfig($key = null, $default = null);

    /**
     * Sets config value for the given key if string key given, or sets entire config if array given.
     *
     * @param array|string $config Provide an array of config or a single config key.
     * @param null|mixed   $value  Ignored if the first parameter is an array.
     *
     * @return $this
     */
    public function setConfig($config, $value = null);
}