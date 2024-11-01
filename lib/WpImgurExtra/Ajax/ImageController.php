<?php

namespace WpImgurExtra\Ajax;

class ImageController extends \Arrow\Ajax\Controller
{

    public $imagePostType;
    public $imageDeleter;

    public function needs()
    {
        return array_merge(
            parent::needs(),
            array('imagePostType', 'imageDeleter')
        );
    }

    public function all()
    {
        return $this->imagePostType->findAll();
    }

    public function delete()
    {
        $validator = $this->getValidator();
        $validator->rule('required', 'id');
        $validator->rule('integer', 'id');

        if ($validator->validate()) {
            $id = $this->params['id'];
            $this->imageDeleter->delete($id);

            return $id;
        } else {
            return $this->error($validator->errors());
        }
    }

}
