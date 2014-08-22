<?php

namespace Andymarrell\Sociauth\Providers\Google;

use Andymarrell\Sociauth\Providers\BaseProvider;
use Andymarrell\Sociauth\Providers\NotAuthenticatedException;
use \Google_Client;
use \Google_Service_Oauth2;

class GoogleProvider extends BaseProvider {
    protected $googleClient;
    protected $googleOauth2Service;

    public function __construct(array $config){
        parent::__construct($config);

        $this->googleClient = new Google_Client();
        $this->googleClient->setClientId($this->getClientId());
        $this->googleClient->setClientSecret($this->getClientSecret());
        $this->googleClient->setRedirectUri($this->getRedirectUrl());

        $this->googleOauth2Service = new Google_Service_Oauth2($this->getGoogleClient());

        $this->googleClient->setScopes($this->getScopes());
    }

    public function authenticate($code){
        $this->getGoogleClient()->authenticate($code);

        if ($this->getGoogleClient()->getAccessToken()){
            $this->setAccessToken($this->getGoogleClient()->getAccessToken());
            return true;
        }

        throw new NotAuthenticatedException;
    }

    public function getAuthUrl(){
        return $this->getGoogleClient()->createAuthUrl();
    }

    protected function getPrivateData(){
        if ($this->accessToken !== null) {
            return (array) $this->getGoogleOauth2Service()->userinfo->get()->toSimpleObject();
        }

        return false;
    }

    /**
     * @return GoogleUserProvider|bool
     */
    public function getUserProvider(){
        if ($this->accessToken !== null){
            $dataArray = (array) $this->getGoogleOauth2Service()->userinfo->get()->toSimpleObject();
            return new GoogleUserProvider($dataArray);
        }

        return false;
    }

    public function getGoogleClient(){
        return $this->googleClient;
    }

    public function getGoogleOauth2Service(){
        return $this->googleOauth2Service;
    }
} 