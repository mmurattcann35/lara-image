<?php

namespace Mmurattcann\LaraImage;

use Illuminate\Support\ServiceProvider;

class LaraImageServiceProvider extends ServiceProvider
{
    public function boot(){

        $this->loadRoutesFrom(__DIR__. "/routes/web.php");
    }

    public function register()
    {
        parent::register(); // TODO: Change the autogenerated stub
    }
}