<?php
/**
 * Created by PhpStorm.
 * User: BF-Andrei
 * Date: 7/17/2014
 * Time: 2:44 PM
 */

namespace Andymarrell\Sociauth\Providers\Facebook;

use Facebook\FacebookRedirectLoginHelper;
use \Session;
use \Input;

class LaravelFacebookRedirectLoginHelper extends FacebookRedirectLoginHelper {
    protected function storeState($state)
    {
        Session::put('state', $state);
    }

    protected function loadState()
    {
        $this->state = Session::get('state');
        return $this->state;
    }

    protected function isValidRedirect()
    {
        return true; // CSRF protection turned off
        //return $this->getCode() && Input::has('state') && Input::get('state') == $this->loadState();
    }

    protected function getCode()
    {
        return Input::has('code') ? Input::get('code') : null;
    }

    //Fix for state value from Auth redirect not equal to session stored state value
    //Get FacebookSession via User access token from code
    public function getAccessTokenDetails($appId,$appSecret,$redirectUrl,$code)
    {

        $tokenUrl = "https://graph.facebook.com/oauth/access_token?"
            . "client_id=" . $appId . "&redirect_uri=" . $redirectUrl
            . "&client_secret=" . $appSecret . "&code=" . $code;

        $response = file_get_contents($tokenUrl);
        $params = null;
        parse_str($response, $params);

        return $params;
    }
} 