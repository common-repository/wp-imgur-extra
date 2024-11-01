<?php

namespace WpImgurExtra\Image;

class Packager
{

    public function onInject($container)
    {
        $container
            ->factory('image', 'WpImgurExtra\Image\Image')
            ->factory('imageStore', 'WpImgurExtra\Image\Store')
            ->factory('imageCollection', 'WpImgurExtra\Image\Collection')
            ->factory('imageSrcReplacer', 'WpImgurExtra\Image\SrcReplacer')
            ->singleton('imageDeleter', 'WpImgurExtra\Image\Deleter')
            ->singleton('imagePostType', 'WpImgurExtra\Image\PostType')
            ->singleton('imageUploader', 'WpImgurExtra\Image\Uploader')
            ->singleton('imageSynchronizer', 'WpImgurExtra\Image\Synchronizer')
            ->initializer('imagePostType', array($this, 'initializePostType'));
    }

    public function initializePostType($postType, $container)
    {
        $postType->register();
    }

}
