<?php

namespace JGLP;

use JGLP\Service\Factory\FactoryInterface;
use JGLP\Service\ServiceInterface;

class Services
{
    /**
     * @var ServiceInterface[]
     */
    protected $services = [];

    /**
     * @var null|array
     */
    protected $config;

    /**
     * Loads config from services.php config file.
     * 
     * @return $this
     */
    public function loadConfig()
    {
        $this->config = require CONFIG_PATH.'/services.php';
        
        return $this;
    }

    /**
     * Get a service by name.
     * 
     * @param string $service
     * 
     * @return ServiceInterface
     * 
     * @throws \Exception If service cannot be found or loaded properly.
     */
    public function get($service)
    {
        if (!array_key_exists($service, $this->services)) {
            $this->load($service);
        }

        return $this->services[$service];
    }

    /**
     * Load a service by name.
     *
     * @param string $service
     *
     * @return $this
     *
     * @throws \Exception If service cannot be found or loaded properly.
     */
    public function load($service)
    {
        if (!array_key_exists($service, $this->config)) {
            throw new \Exception("No service \"$service\" configured");
        }
        
        $config = $this->config[$service];
        if (!is_array($config)) {
            throw new \Exception("No service configuration provided for \"$service\"");
        }
        
        if (array_key_exists("factory", $config)) {
            
            if (!class_exists((string) $config["factory"])) {
                throw new \Exception("Factory class \"".$config["factory"]."\" does not exist");
            }
            
            $factory = new $config["factory"];
            if (! $factory instanceof FactoryInterface) {
                throw new \Exception(
                    "Class \"".$config["factory"]."\" does not implement JGLP\\Service\\Factory\\FactoryInterface");
            }

            if (array_key_exists("config", $config) && is_array($config["config"])) {
                $factory->setConfig($config["config"]);
            }
            
            $this->services[$service] = $factory->make();
            
        } elseif (array_key_exists("class", $config)) {

            if (!class_exists((string) $config["class"])) {
                throw new \Exception("Service class \"".$config["class"]."\" does not exist");
            }

            $this->services[$service] = new $config["class"];
            if (! $this->services[$service] instanceof ServiceInterface) {
                unset($this->services[$service]);
                throw new \Exception("\"".$config["class"]."\" does not implement JGLP\\Service\\ServiceInterface");
            }

            if (array_key_exists("config", $config) && is_array($config["config"])) {
                $this->services[$service]->setConfig($config["config"]);
            }
            
        } else {
            throw new \Exception("No class or factory provided in \"$service\" service configuration");
        }

        return $this;
    }
}