<?php

namespace Andymarrell\Sociauth\Providers\Vk;

use Andymarrell\Sociauth\Providers\BaseProvider;

class VkProvider extends BaseProvider {
    protected $apiVersion;
    protected $userId;
    protected $secret;
    protected $email;

    public function __construct(array $config){
        parent::__construct($config);

        $this->setApiVersion($config['version']);
    }

    public function authenticate($code){
        $url = 'https://oauth.vk.com/access_token?client_id=' . $this->getClientId() .
            '&client_secret=' . $this->getClientSecret() .
            '&code=' . $code .
            '&redirect_uri=' . $this->getRedirectUrl();

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        $response = (array)json_decode(curl_exec($ch));

        if (array_key_exists('access_token', $response) && array_key_exists('email', $response)){
            $this->setAccessToken($response['access_token']);
            $this->setUserId($response['user_id']);
            $this->email = $response['email'];
            // $this->setSecret($response['secret']); // For https only
            return true;
        }

        return false;
    }

    public function getAuthUrl(){
        return 'https://oauth.vk.com/authorize?client_id=' . $this->getClientId() .
            '&scope=' . $this->getScopes()[0] .
            '&redirect_uri=' . $this->getRedirectUrl() .
            '&response_type=code&v=' . $this->getApiVersion();
    }

    public function getPrivateData(){
        $url = 'https://api.vk.com/method/users.get?uid='.$this->getUserId().'&access_token=' . $this->getAccessToken() . '&fields=photo_100';

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

        $response = (array)json_decode(curl_exec($ch));

        return $response['response'][0];
    }

    public function getUserProvider(){
        return new VkUserProvider([
            'id' => $this->getPrivateData()->uid,
            'email' => $this->email
        ]);
    }

    public function getApiVersion()
    {
        return $this->apiVersion;
    }

    public function setApiVersion($apiVersion)
    {
        $this->apiVersion = $apiVersion;
    }

    public function setSecret($secret)
    {
        $this->secret = $secret;
    }

    public function getSecret(){
        return $this->secret;
    }

    public function setUserId($userId){
        $this->userId = $userId;
    }

    public function getUserId(){
        return $this->userId;
    }
} 