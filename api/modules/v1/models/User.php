<?php


namespace api\modules\v1\models;


use yii\helpers\Url;
use yii\web\Linkable;

class User extends \common\models\User implements Linkable
{
    public function fields(){
        return parent::fields();
    }

    public function getLinks()
    {
        return[
          $this->id=>Url::to(['user/view','id'=>$this->id],true),
        ];
    }
}