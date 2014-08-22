<?php

return array(
    'providers' => array(
        'google' => array(
            'class' => 'Andymarrell\Sociauth\Providers\Google\GoogleProvider',
            'credentials' => array(
                'client-id' => '',
                'client-secret' => '',
                'redirect-url' => 'http://qdump.ru/social/google'
            ),
            'scopes' => array(
                'profile',
                'email'
            )
        ),
        'facebook' => array(
            'class' => 'Andymarrell\Sociauth\Providers\Facebook\FacebookProvider',
            'credentials' => array(
                'client-id' => '',
                'client-secret' => '',
                'redirect-url' => 'http://qdump.ru/social/facebook'
            ),
            'scopes' => array(
                'email'
            )
        ),
        'github' => array(
            'class' => 'Andymarrell\Sociauth\Providers\Github\GithubProvider',
            'credentials' => array(
                'client-id' => '',
                'client-secret' => '',
                'redirect-url' => 'http://qdump.ru/social/github'
            ),
            'scopes' => array(
                'user',
                'user:email'
            )
        ),
        'vk' => array(
            'class' => 'Andymarrell\Sociauth\Providers\Vk\VkProvider',
            'credentials' => array(
                'client-id' => '',
                'client-secret' => '',
                'redirect-url' => 'http://qdump.ru/social/vk'
            ),
            'scopes' => array(
                'email'
            ),
            'version' => '5.24'
        )
    )
);