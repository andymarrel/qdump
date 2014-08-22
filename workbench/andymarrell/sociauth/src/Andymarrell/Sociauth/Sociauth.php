<?php

namespace Andymarrell\Sociauth;

use Andymarrell\Sociauth\Providers\ProviderNotFoundException;
use \Config;

class Sociauth {
    protected $providers = [];

    public function __construct(){
        $this->providers = Config::get('sociauth::sociauth.providers');
    }

    public function getProvider($providerAlias){
        $providersConfig = $this->providers;

        if ($providersConfig === null || !array_key_exists($providerAlias, $providersConfig)) {
            throw new ProviderNotFoundException;
        }

        $class = $providersConfig[$providerAlias]['class'];

        return new $class($providersConfig[$providerAlias]);
    }

    public function getActiveProviders(){
        return $this->providers;
    }
}