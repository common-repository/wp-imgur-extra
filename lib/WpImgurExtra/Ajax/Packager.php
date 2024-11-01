<?php

namespace WpImgurExtra\Ajax;

class Packager
{

    public function onInject($container)
    {
        $container
            ->singleton('configController', 'WpImgurExtra\Ajax\ConfigController')
            ->singleton('syncPreparer', 'WpImgurExtra\Ajax\SyncPreparer')
            ->singleton('imageController', 'WpImgurExtra\Ajax\ImageController')
            ->singleton('authController', 'WpImgurExtra\Ajax\AuthController')
            ->singleton('syncController', 'WpImgurExtra\Ajax\SyncController');
    }

}
