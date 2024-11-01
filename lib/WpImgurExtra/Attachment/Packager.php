<?php

namespace WpImgurExtra\Attachment;

class Packager
{

    public function onInject($container)
    {
        $container
            ->singleton('attachmentPostType', 'WpImgurExtra\Attachment\PostType');
    }

}
