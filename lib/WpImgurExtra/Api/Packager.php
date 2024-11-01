<?php

namespace WpImgurExtra\Api;

class Packager extends \Imgur\Packager
{

    public function onInject($container)
    {
        parent::onInject($container);

        $container
            ->singleton('imgurCredentials', 'WpImgurExtra\Api\Credentials');
    }

}
