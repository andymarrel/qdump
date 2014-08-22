<?php

class SocialLink extends Eloquent {
    protected $table = 'social_links';

    public static function findByProviderAndSocialId($provider, $socialId){
        return SocialLink::whereRaw('provider = ? AND social_id = ?', [$provider, $socialId])->first();
    }
} 