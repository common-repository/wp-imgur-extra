<?php

namespace WpImgurExtra\Image;

class Store
{

    public $container;
    public $imagePostType;

    public $images    = array();
    public $slug      = null;
    public $didLoad   = false;
    public $didChange = false;
    public $id        = 0;

    public function needs()
    {
        return array('imagePostType');
    }

    public function hasImage($size)
    {
        return array_key_exists($size, $this->images);
    }

    public function addImage($size, $url)
    {
        $this->images[$size] = $url;
        $this->didChange     = true;
    }

    public function removeImage($size)
    {
        unset($this->images[$size]);
        $this->didChange = true;
    }

    public function count()
    {
        return count($this->images);
    }

    public function getImageUrl($size)
    {
        return $this->images[$size];
    }

    public function getSlug()
    {
        return $this->slug;
    }

    public function setSlug($slug)
    {
        $this->slug = $slug;
    }

    public function loaded()
    {
        return $this->didLoad;
    }

    public function changed()
    {
        return $this->didChange;
    }

    public function load()
    {
        if ($this->loaded()) {
            return;
        }

        $this->images    = $this->fetch();
        $this->didLoad   = true;
        $this->didChange = false;
    }

    public function exists()
    {
        return $this->id !== 0;
    }

    public function fetch()
    {
        $result = $this->imagePostType->find($this->getSlug());
        if ($result === false) {
            $images = array();
        } else {
            $images   = $result['images'];
            $this->id = $result['post']->ID;
        }

        return $images;
    }

    public function save()
    {
        if (!$this->changed()) {
            return false;
        }

        if ($this->exists()) {
            $result = $this->imagePostType->update(
                $this->id, $this->images
            );
        } else {

            $result = $this->imagePostType->create(
                $this->getSlug(), $this->images
            );

            if (!is_wp_error($result)) {
                $this->id = $result;
            }
        }

        if (is_wp_error($result)) {
            throw new \Exception($result->get_error_message());
        } else {
            $this->didChange = false;
            return true;
        }
    }

}
