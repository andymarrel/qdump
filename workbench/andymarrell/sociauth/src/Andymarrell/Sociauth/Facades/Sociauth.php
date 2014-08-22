<?php

namespace Andymarrell\Sociauth\Facades;

use Illuminate\Support\Facades\Facade;

class Sociauth extends Facade {
    protected static function getFacadeAccessor() {
        return 'sociauth';
    }
} 