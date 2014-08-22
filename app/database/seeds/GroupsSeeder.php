<?php

class GroupsSeeder extends Seeder {
    public function run(){
        Sentry::createGroup([
            'name' => 'Member',
            'permissions' => [
                'user' => 1,
                'moderator' => 0,
                'admin' => 0
            ]
        ]);

        Sentry::createGroup([
            'name' => 'Moderator',
            'permissions' => [
                'user' => 1,
                'moderator' => 1,
                'admin' => 0
            ]
        ]);

        Sentry::createGroup([
            'name' => 'Administrator',
            'permissions' => [
                'user' => 1,
                'moderator' => 1,
                'admin' => 1
            ]
        ]);
    }
} 