<?php

namespace WpImgurExtra\Image;

class Image
{

    public static $standardSizes = array(
        '90x90'     => 's',
        '160x160'   => 't',
        '320x320'   => 'm',
        '640x640'   => 'l',
        '1024x1024' => 'h',
    );

    public $container;
    public $attributes;
    public $kind;
    public $parent = null;
    public $meta   = null;

    public function needs()
    {
        return array();
    }

    public function setAttributes($attributes)
    {
        $this->attributes = $attributes;
    }

    public function getAttributes()
    {
        return $this->attributes;
    }

    public function getAttribute($key)
    {
        if (array_key_exists($key, $this->attributes)) {
            return $this->attributes[$key];
        } else {
            return null;
        }
    }

    public function setKind($kind)
    {
        $this->kind = $kind;
    }

    public function getKind()
    {
        return $this->kind;
    }

    public function getParent()
    {
        return $this->parent;
    }

    public function setParent($parent)
    {
        $this->parent = $parent;
    }

    public function getMeta()
    {
        if ($this->hasParent()) {
            return $this->getParent()->getMeta();
        } else {
            return $this->meta;
        }
    }

    public function setMeta($meta)
    {
        $this->meta = $meta;
    }

    public function getWidth()
    {
        return $this->getAttribute('width');
    }

    public function getHeight()
    {
        return $this->getAttribute('height');
    }

    public function getSize()
    {
        if ($this->isOriginal()) {
            return 'original';
        } else {
            return $this->getWidth() . 'x' . $this->getHeight();
        }
    }

    public function getMimeType()
    {
        return $this->getAttribute('mime-type');
    }

    public function getFilename()
    {
        return $this->getAttribute('file');
    }

    public function getFilepath()
    {
        return $this->toImagePath('basedir');
    }

    public function fileExists()
    {
        return file_exists($this->getFilepath());
    }

    public function getUrl()
    {
        return $this->toImagePath('baseurl');
    }

    public function toImagePath($key)
    {
        $uploads = wp_upload_dir();
        $basedir = $uploads[$key];

        if ($this->hasParent()) {
            $parentFilename = $this->getParent()->getFilename();
            $dir            = dirname($parentFilename);

            if ($dir === '.') {
                return $basedir . '/' . $this->getFilename();
            } else {
                return $basedir . '/' . $dir . '/' . $this->getFilename();
            }
        } else {
            return $basedir . '/' . $this->getFilename();
        }
    }

    public function isCustomSize()
    {
        return !array_key_exists($this->getSize(), self::$standardSizes);
    }

    public function isOriginal()
    {
        return $this->getKind() === 'original';
    }

    public function hasParent()
    {
        return !is_null($this->getParent());
    }

    public function isUploadable()
    {
        return ($this->isOriginal() || $this->isCustomSize()) && $this->fileExists();
    }
}
