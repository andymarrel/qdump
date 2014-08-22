<?php

namespace Andymarrell\Sociauth\Providers;

interface UserProviderInterface {
    /**
     * @return string|false
     */
    public function getId();

    /**
     * @return string|false
     */
    public function getEmail();
} 