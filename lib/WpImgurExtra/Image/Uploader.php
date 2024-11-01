<?php

namespace WpImgurExtra\Image;

class Uploader
{

    public $container;
    public $optionsStore;
    public $imgurImageRepo;

    public function needs()
    {
        return array(
            'optionsStore', 'imgurImageRepo',
        );
    }

    public function getAlbum()
    {
        return $this->optionsStore->getOption('album');
    }

    public function hasAlbum()
    {
        return $this->getAlbum() !== '';
    }

    public function getMode()
    {
        return $this->optionsStore->getOption('uploadMode');
    }

    public function upload($image)
    {
        if ($this->getMode() === 'push') {
            return $this->uploadByPush($image);
        } else {
            return $this->uploadByPull($image);
        }
    }

    public function uploadByPush($image)
    {
        $params          = $this->getUploadParams($image, 'file');
        $params['image'] = file_get_contents($image->getFilepath());
        $uploadedImage   = $this->imgurImageRepo->create($params);

        return $uploadedImage;
    }

    public function uploadByPull($image)
    {
        $params          = $this->getUploadParams($image, 'url');
        $params['image'] = $image->getUrl();
        $uploadedImage   = $this->imgurImageRepo->create($params);

        return $uploadedImage;
    }

    public function getUploadParams($image, $type)
    {
        $params = array(
            'title' => basename($image->getFilename()),
            'type'  => $type,
        );

        if ($this->hasAlbum()) {
            $params['album'] = $this->getAlbum();
        }

        return $params;
    }

}
