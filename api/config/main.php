<?php

use yii\rest\UrlRule;

$params = array_merge(
    require(__DIR__.'/../../common/config/params.php'),
    require(__DIR__.'/../../common/config/params-local.php'),
    require(__DIR__.'/params.php'),
    require(__DIR__.'/params-local.php')
);

return [
    'id'         => 'app-api',
    'basePath'   => dirname(__DIR__),
    'bootstrap'  => ['log'],
    'modules'    => [
        'v1' => [
            'basePath' => '@app/modules/v1',
            'class'    => 'api\modules\v1\Module'
        ]
    ],
    'aliases'    => [
        '@api' => dirname(dirname(__DIR__)).'/api',
    ],
    'components' => [
        'request'    => [
            'baseUrl' => '/api',
//            'csrfParam' => '_csrf-api',
            'parsers' => [
                'application/json' => 'yii\web\JsonParser',
//                'text/xml'         => 'yii\web\XmlParser',
            ],
        ],
        'response'   => [
            'formatters' => [
                \yii\web\Response::FORMAT_JSON => [
                    'class'         => 'yii\web\JsonResponseFormatter',
                    'prettyPrint'   => YII_DEBUG, // используем "pretty" в режиме отладки
                    'encodeOptions' => JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE,
                ]
            ]
        ],
        'user'       => [
            'identityClass'   => 'api\modules\v1\models\User',
            'enableAutoLogin' => false,
            'enableSession'   => false
        ],
        'session'=>[
            'name'=>'api'
        ],
        'log'        => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets'    => [
                [
                    'class'  => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'urlManager' => [
            'enablePrettyUrl'     => true,
            'enableStrictParsing' => false,
            'showScriptName'      => false,
            //http://yii-api.loc/api/v1/countries
            //http://host1827487.hostland.pro/api/v1/user
            //http://host1827487.hostland.pro/api/v1/country
            'rules'               => [
                [
                    'class'      => UrlRule::class,
                    'controller' => ['v1/user', 'v1/country'],
                    'pluralize'  => false,
                    'tokens'     => [
                        '{id}' => '<id:\\w+>'
                    ],
                ],
                'v1/signup'=>'v1/site/signup'
            ],
        ],
    ],

    'params' => $params,
];



