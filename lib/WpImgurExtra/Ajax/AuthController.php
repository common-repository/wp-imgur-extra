<?php

namespace WpImgurExtra\Ajax;

class AuthController extends \Arrow\Ajax\Controller
{

    public $imgurAdapter;
    public $syncPreparer;
    public $optionsStore;

    public function needs()
    {
        return array_merge(
            parent::needs(),
            array('imgurAdapter', 'syncPreparer', 'optionsStore')
        );
    }

    public function adminActions()
    {
        return array('verifyPin');
    }

    public function actionMethods()
    {
        return array(
            'verifyPin' => array('POST'),
        );
    }

    public function verifyPin()
    {
        $validator = $this->getValidator();
        $validator->rule('required', 'pin');
        $validator->rule('safeText', 'pin');

        if ($validator->validate()) {
            $pin    = $this->params['pin'];
            $result = $this->imgurAdapter->verifyPin($pin);
            $this->syncPreparer->prepare();

            return array(
                'authorized' => $result,
                'uploadMode' => $this->optionsStore->getOption('uploadMode'),
                'album'      => $this->optionsStore->getOption('album'),
            );
        } else {
            return $this->error($validator->errors());
        }
    }

}
