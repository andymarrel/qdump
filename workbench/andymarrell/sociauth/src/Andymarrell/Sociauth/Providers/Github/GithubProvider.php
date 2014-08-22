<?php

namespace Andymarrell\Sociauth\Providers\Github;

use Andymarrell\Sociauth\Providers\BaseProvider;
use Andymarrell\Sociauth\Providers\NotAuthenticatedException;

class GithubProvider extends BaseProvider {
    public function __construct(array $config){
        parent::__construct($config);
    }

    public function getAuthUrl(){
        $randomState = substr(str_shuffle("0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, 16);

        $this->setState($randomState);

        $url = 'https://github.com/login/oauth/authorize?client_id=' . $this->getClientId() .
            '&redirect_uri=' . $this->getRedirectUrl() .
            '&scope=user' .
            '&state=' . $randomState;

        return $url;
    }

    public function authenticate($code){
        $data = array(
            'client_id' => $this->getClientId(),
            'client_secret' => $this->getClientSecret(),
            'code' => $code,
            'redirect_uri' => $this->getRedirectUrl()
        );

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'https://github.com/login/oauth/access_token');
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Accept: application/json'
        ));

        $response = (array) json_decode(curl_exec($ch));

        if (array_key_exists('access_token', $response)){
            $this->setAccessToken($response['access_token']);
            return true;
        }

        throw new NotAuthenticatedException;
    }

    protected function getPrivateData(){
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'https://api.github.com/user?access_token=' . $this->getAccessToken());
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'User-Agent: ' . $_SERVER['HTTP_USER_AGENT']
        ));
        $response = curl_exec($ch);

        $arrayResponse = (array) $response;
        if (array_key_exists(0, $arrayResponse)) {
            return (array) json_decode($arrayResponse[0]);
        }

        return false;
    }

    public function getUserProvider(){
        return new GithubUserProvider($this->getPrivateData());
    }

    public function getState(){
        return \Session::get('github_state');
    }

    public function setState($state) {
        \Session::put('github_state', $state);
    }
} 