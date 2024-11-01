<?php

namespace WpImgurExtra\Ajax;

class SyncController extends \Arrow\Ajax\Controller
{

    public $attachmentPostType;
    public $imageSynchronizer;

    public function needs()
    {
        return array_merge(
            parent::needs(),
            array('attachmentPostType', 'imageSynchronizer')
        );
    }

    public function all()
    {
        return $this->attachmentPostType->findAll();
    }

    public function post()
    {
        $validator = $this->getValidator();
        $validator->rule('required', 'id');
        $validator->rule('integer', 'id');

        if ($validator->validate()) {
            return $this->imageSynchronizer->sync($this->params['id']);
        } else {
            return $this->error($validator->errors());
        }
    }

}
