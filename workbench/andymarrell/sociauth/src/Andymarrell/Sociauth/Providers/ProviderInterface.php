<?php

namespace Andymarrell\Sociauth\Providers;

interface ProviderInterface {

    /**
     * Return provider auth string
     *
     * @return string
     */
    public function getAuthUrl();

    /**
     * Authenticate user
     *
     * @param String
     * @return bool
     */
    public function authenticate($code);

    /**
     * Get API access token
     *
     * @return String
     */
    public function getAccessToken();
}