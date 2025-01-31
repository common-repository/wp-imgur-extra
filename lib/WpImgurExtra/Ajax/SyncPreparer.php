<?php

namespace WpImgurExtra\Ajax;

class SyncPreparer
{

    public $pluginMeta;
    public $imgurAlbumRepo;
    public $imgurImageRepo;
    public $optionsStore;

    public function needs()
    {
        return array(
            'pluginMeta',
            'imgurAlbumRepo',
            'imgurImageRepo',
            'optionsStore',
        );
    }

    public function prepare()
    {
        $this->createAlbum();
        $this->detectUploadMode();

        $this->optionsStore->save();
    }

    public function createAlbum()
    {
        if (!$this->albumExists()) {
            $params = array(
                'title' => site_url(),
            );

            $album = $this->imgurAlbumRepo->create($params);
            $this->optionsStore->setOption('album', $album['id']);
            return true;
        }

        return false;
    }

    public function albumExists()
    {
        $albumId = $this->optionsStore->getOption('album');

        if ($albumId !== '') {
            try {
                $this->imgurAlbumRepo->find($albumId);
                return true;
            } catch (\Imgur\Exception $err) {
                return false;
            }
        } else {
            return false;
        }
    }

    public function detectUploadMode()
    {
        try {
            $detectorUrl = plugins_url('images/detector.png', $this->pluginMeta->getFile());
            $params      = array(
                'type'  => 'url',
                'image' => $detectorUrl,
                'title' => 'upload_mode_detector',
            );

            $image = $this->imgurImageRepo->create($params);
            $this->imgurImageRepo->delete($image['deletehash']);

            $mode = 'pull';
        } catch (\Imgur\Exception $e) {
            $mode = 'push';
        }

        $this->optionsStore->setOption('uploadMode', $mode);
        return $mode;
    }

}
