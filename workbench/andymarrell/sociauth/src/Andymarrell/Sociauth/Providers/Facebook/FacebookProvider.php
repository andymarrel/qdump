<?php

namespace Andymarrell\Sociauth\Providers\Facebook;

use Andymarrell\Sociauth\Providers\BaseProvider;
use Andymarrell\Sociauth\Providers\NotAuthenticatedException;
use Facebook\FacebookRequest;
use Facebook\FacebookRequestException;
use Facebook\FacebookSession;

class FacebookProvider extends BaseProvider {
    protected $credentials = array();

    public function __construct(array $config){
        parent::__construct($config);

        $this->credentials = $config['credentials'];

        FacebookSession::setDefaultApplication($this->getClientId(), $this->getClientSecret());
    }

    public function getAuthUrl(){
        $helper = new LaravelFacebookRedirectLoginHelper($this->getRedirectUrl());
        $scopes = $this->getScopes();
        $faceBookScope = array('scope' => $scopes[0]);

        return $helper->getLoginUrl($faceBookScope);
    }

    public function authenticate($code){
        $helper = new LaravelFacebookRedirectLoginHelper($this->getRedirectUrl());

        try {
            $session = $helper->getSessionFromRedirect();
        } catch(FacebookRequestException $ex) {
            // When Facebook returns an error
            var_dump($ex);
        } catch(\Exception $ex) {
            // When validation fails or other local issues
            var_dump($ex);
        }

        if ($session) {
            $this->setAccessToken($session);
            return true;
        }

        throw new NotAuthenticatedException;
    }

    public function getUserProvider(){
        return new FacebookUserProvider($this->getPrivateData());
    }

    protected function getPrivateData(){
        try {
            $request = new FacebookRequest(
                $this->getAccessToken(),
                'GET',
                '/me'
            );
            $response = $request->execute();
            $userProfile = $response->getGraphObject();

            return $userProfile->asArray();
        } catch(FacebookRequestException $e) {
            return false;
        }
    }
} 