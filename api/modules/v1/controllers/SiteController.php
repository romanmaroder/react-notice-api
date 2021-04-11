<?php


namespace api\modules\v1\controllers;

use api\modules\v1\models\SignupForm;
use Yii;
use yii\filters\ContentNegotiator;
use yii\rest\Controller;
use yii\rest\Serializer;
use yii\web\Response;

class SiteController extends Controller
{
    public function behaviors()
    {
        $behaviors = parent::behaviors();
// remove authentication filter
        $auth = $behaviors['authenticator'];
        unset($behaviors['authenticator']);

        // add CORS filter
        $behaviors['corsFilter'] = [
            'class' => \yii\filters\Cors::class,
        ];

        // re-add authentication filter
        $behaviors['authenticator'] = $auth;
        // avoid authentication on CORS-pre-flight requests (HTTP OPTIONS method)
        $behaviors['authenticator']['except'] = ['options'];
        $behaviors['contentNegotiator'] =[
            'class' => ContentNegotiator::class,
            'formatParam' => '_format',
            'formats' => [
                'json' => Response::FORMAT_JSON,
                'xml' => Response::FORMAT_XML,
            ],
        ];
        return $behaviors;

    }

    public $serializer = [
        'class'              => Serializer::class,
        'collectionEnvelope' => 'items'
    ];

    public function actionIndex()
    {
        return 'api';
    }

    public function actionSignup()
    {
        $model = new SignupForm();
        if ($model->load(Yii::$app->request->bodyParams, '') && $model->signup()) {
//            \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            return $data = [
                'code'    => 200,
                'message' => 'Registration completed successfully'
            ];
        } else {
            return $data = [
                'code'    => 422,
                'message' => $model->getErrors()
            ];
        }
    }
}