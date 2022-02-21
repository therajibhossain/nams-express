<?php
namespace App\Test\Facades;

use illuminate\support\Facades\Facade;

class Test extends Facade {
    protected static function getFacadeAccessor() {
        return 'test';
    }
}