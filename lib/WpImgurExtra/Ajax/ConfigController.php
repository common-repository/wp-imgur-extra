<?php

namespace WpImgurExtra\Ajax;

class ConfigController extends \Arrow\Ajax\Controller
{

    public $optionsStore;

    public function needs()
    {
        return array_merge(
            parent::needs(),
            array('optionsStore')
        );
    }

    public function patch()
    {
        $validator = $this->getValidator();
        $validator->rule('required', 'syncOnMediaUpload');
        $validator->rule('integer', 'syncOnMediaUpload');

        $validator->rule('required', 'syncOnMediaEdit');
        $validator->rule('integer', 'syncOnMediaEdit');

        $validator->rule('required', 'useHttps');
        $validator->rule('integer', 'useHttps');

        if ($validator->validate()) {
            $syncOnMediaUpload = $this->params['syncOnMediaUpload'];
            $syncOnMediaEdit   = $this->params['syncOnMediaEdit'];
            $useHttps          = $this->params['useHttps'];

            $this->optionsStore->setOption('syncOnMediaUpload', $syncOnMediaUpload);
            $this->optionsStore->setOption('syncOnMediaEdit', $syncOnMediaEdit);
            $this->optionsStore->setOption('useHttps', $useHttps);

            return $this->optionsStore->save();
        } else {
            return $this->error($validator->errors());
        }
    }

}
