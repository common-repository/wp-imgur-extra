<?php

namespace WpImgurExtra\Api;

class Credentials extends \Imgur\Credentials
{

    public $optionsStore;

    protected $clientId     = '1c354b6654a4a6d';
    protected $clientSecret = '48535b387a4b995b370d3cbbacaffca94b125da2';

    protected $didLoad = false;

    public function needs()
    {
        return array('optionsStore');
    }

    public function loaded()
    {
        return $this->didLoad;
    }

    public function load()
    {
        if ($this->loaded()) {
            return;
        }

        $this->optionsStore->load();
        $this->didLoad = true;
    }

    public function save()
    {
        $this->optionsStore->save();
    }

    /* overridden to use credentials stored in options */
    public function getAccessToken()
    {
        return $this->getOption('accessToken');
    }

    public function setAccessToken($accessToken)
    {
        $this->setOption('accessToken', $accessToken);
    }

    public function getAccessTokenExpiry()
    {
        return $this->getOption('accessTokenExpiry');
    }

    public function setAccessTokenExpiry($expireIn)
    {
        $expiry = strtotime("+{$expireIn} seconds");
        $this->setOption('accessTokenExpiry', $expiry);
    }

    public function getRefreshToken()
    {
        return $this->getOption('refreshToken');
    }

    public function setRefreshToken($refreshToken)
    {
        $this->setOption('refreshToken', $refreshToken);
    }

    /* helpers */
    public function getOption($name)
    {
        return $this->optionsStore->getOption($name);
    }

    public function setOption($name, $value)
    {
        $this->optionsStore->setOption($name, $value);
    }

}
