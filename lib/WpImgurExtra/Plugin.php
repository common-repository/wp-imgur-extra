<?php

namespace WpImgurExtra;

class Plugin extends \Arrow\Plugin
{

    public function __construct($file)
    {
        parent::__construct($file);

        $this->container
            ->object('pluginMeta', new PluginMeta($file))

            ->packager('optionsPackager', 'Arrow\Options\Packager')
            ->packager('imgurApiPackager', 'WpImgurExtra\Api\Packager')
            ->packager('imagePackager', 'WpImgurExtra\Image\Packager')
            ->packager('attachmentPackager', 'WpImgurExtra\Attachment\Packager')
            ->packager('ajaxPackager', 'WpImgurExtra\Ajax\Packager');
    }

    public function enable()
    {
        add_action('admin_init', array($this, 'initAdmin'));
        add_action('init', array($this, 'initFrontEnd'));
    }

    public function initAdmin()
    {
        $this->lookup('imageSynchronizer')->enable();
    }

    public function initFrontEnd()
    {
        $this->lookup('imageSrcReplacer')->enable();
    }

}
