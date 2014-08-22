<?php

namespace Andymarrell\Sociauth\Providers;

abstract class BaseProvider implements ProviderInterface {
    protected $clientId;
    protected $clientSecret;
    protected $redirectUrl;
    protected $scopes;
    protected $accessToken;

    abstract public function getAuthUrl();
    abstract public function authenticate($code);

    public function __construct(array $config){
        $this->setClientId($config['credentials']['client-id']);
        $this->setClientSecret($config['credentials']['client-secret']);
        $this->setRedirectUrl($config['credentials']['redirect-url']);
        $this->setScopes($config['scopes']);
    }

    public function setClientId($clientId){
        $this->clientId = $clientId;
    }

    public function getClientId(){
        return $this->clientId;
    }

    public function setClientSecret($clientSecret){
        $this->clientSecret = $clientSecret;
    }

    public function getClientSecret(){
        return $this->clientSecret;
    }
    public function setRedirectUrl($redirectUrl){
        $this->redirectUrl = $redirectUrl;
    }

    public function getRedirectUrl(){
        return $this->redirectUrl;
    }

    public function setScopes(array $scopes){
        $this->scopes = $scopes;
    }

    public function getScopes(){
        return $this->scopes;
    }

    public function setAccessToken($token){
        $this->accessToken = $token;
    }

    public function getAccessToken(){
        return $this->accessToken;
    }
} 