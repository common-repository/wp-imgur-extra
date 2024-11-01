<?php

namespace WpImgurExtra\Image;

class Collection
{

    public $container;
    public $imagePostType;
    public $optionsStore;
    public $didLoad = false;
    public $images;

    public function needs()
    {
        return array('imagePostType', 'optionsStore');
    }

    public function loaded()
    {
        return $this->didLoad;
    }

    public function load($postNames)
    {
        if ($this->loaded()) {
            return;
        }

        $this->images  = $this->fetch($postNames);
        $this->didLoad = true;
    }

    public function fetch($postNames)
    {
        $results = $this->imagePostType->findBy($postNames);
        $images  = array();

        foreach ($results as $result) {
            $postName    = $result[0];
            $postContent = $result[1];

            $securePostContent = [];

            if ($this->optionsStore->getOption('useHttps')) {
                foreach (json_decode($postContent) as $key => $value) {
                    $securePostContent[$key] = str_replace('http://', 'https://', $value);
                }

                $postContent = json_encode($securePostContent);
            }

            $images[$postName] = json_decode($postContent, true);
        }

        return $images;
    }

    public function count()
    {
        return count($this->images);
    }

    public function hasImage($postName, $size)
    {
        $slug = $this->toSlug($postName);

        /* for standard sizes, we only need to know if original
         * exists */
        if ($this->isStandardSize($size)) {
            $size = 'original';
        }

        return array_key_exists($slug, $this->images) &&
        array_key_exists($size, $this->images[$slug]);
    }

    public function getImageUrl($postName, $size)
    {
        $slug = $this->toSlug($postName);

        if (!$this->isStandardSize($size)) {
            return $this->images[$slug][$size];
        } else {
            return $this->getStandardUrl($slug, $size);
        }
    }

    public function getStandardUrl($slug, $size)
    {
        $original  = $this->images[$slug]['original'];
        $info      = pathinfo($original);
        $extension = $info['extension'];
        $suffix    = Image::$standardSizes[$size];

        return $info['dirname'] . '/' . $info['filename'] . $suffix . '.' . $extension;
    }

    public function toSlug($postName)
    {
        return $this->imagePostType->toSlug($postName);
    }

    public function isStandardSize($size)
    {
        return array_key_exists($size, Image::$standardSizes);
    }

}
