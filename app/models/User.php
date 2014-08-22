<?php

use Cartalyst\Sentry\Users\Eloquent\User as CartalystUser;

class User extends CartalystUser {
    use SoftDeletingTrait;

    public function isSocialAccount(){
        if ($this->social_provider !== null){
            return true;
        }

        return false;
    }

    public function hasLinkedAccount($provider){
        $link = SocialLink::whereRaw('user_id = ? AND provider = ?', [
            $this->id,
            $provider
        ])->first();

        if ($link === null){
            return false;
        }

        return true;
    }

    public function unlinkAccount($provider){
        return SocialLink::whereRaw('user_id = ? AND provider = ?', [
            $this->id,
            $provider
        ])->delete();
    }
}