<?php
namespace Dev;

use Zend\Router\Http\Literal;
use Zend\Router\Http\Segment;

//\Zend\Debug\Debug::dump( $a, __METHOD__.' ['.__LINE__ . ']' . ', a: ' );
//die(__METHOD__.' ['.__LINE__ . ']');

return [
    'router' => [
        'routes' => [
            'dev_index' => [
                'type'    => Segment::class,
                //'type'    => Literal::class,
                'options' => [
                    'route'    => '/dev[/:action]',
                    //'route' =>  '/dev',
                    'defaults' => [
                        'controller' => Controller\IndexController::class,
                        'action'     => 'index',
                    ],


                    /*
                     * to dziala w moim zf3.adx
                     */
                    /*
                    'may_terminate' => true,
                    'child_routes'  => [
                        'my__3' => [
                            'type' => Segment::class,
                            'options' => [
                                'route'    => '/my[/:action]',
                                'defaults' => [
                                    'controller' => Controller\MyController::class,
                                    'action' => 'index'
                                ],
                                //'constraints' => [
                                    //'action' => '(ip|create|add)'
                                //],
                            ],
                        ],
                    ],
                    */




                ],
            ],


            'dev_my' => [
                'type'    => Segment::class,
                'options' => [
                    'route'    => '/dev/my[/:action]',
                    //'route' =>  '/dev',
                    'defaults' => [
                        'controller' => Controller\MyController::class,
                        'action'     => 'index',
                    ],
                ],
            ],

            'dev_json' => [
                'type'    => Segment::class,
                'options' => [
                    'route'    => '/dev/json[/:action]',
                    //'route' =>  '/dev',
                    'defaults' => [
                        'controller' => Controller\JsonController::class,
                        'action'     => 'index',
                    ],
                ],
            ],

            'dev_config' => [
                'type'    => Segment::class,
                'options' => [
                    'route'    => '/dev/config[/:action][/key/:key]',
                    //'route' =>  '/dev',
                    'defaults' => [
                        'controller' => Controller\ConfigController::class,
                        'action'     => 'index',
                    ],
                ],
            ],

            'dev_initest' => [
                'type'    => Segment::class,
                'options' => [
                    'route'    => '/dev/initest',
                    //'route' =>  '/dev',
                    'defaults' => [
                        'controller' => Controller\InitestController::class,
                        'action'     => 'index',
                    ],
                ],
            ],


        ],
    ],

/*
    'navigation' => [
        'dev' => [
            [
                'label' => 'Dev',
                'route' => 'dev',
                'pages' => [
                    [
                        'label' => 'Config',
                        'route' => 'dev/config',
                    ],
                ],
            ],
        ],
    ],
*/

    'access_filter' => [
        'controllers' => [
            Controller\IndexController::class => [
                // Give access to "resetPassword", "message" and "setPassword" actions
                // to anyone.
                ['actions' => ['index', 'tmp'], 'allow' => '*'],
                // Give access to "index", "add", "edit", "view", "changePassword" actions to authorized users only.
                //['actions' => ['index', 'add', 'edit', 'view', 'changePassword'], 'allow' => '@']
            ],
            Controller\MyController::class => [
                ['actions' => ['index', 'ip'], 'allow' => '*'],
                // Give access to "index", "add", "edit", "view", "changePassword" actions to authorized users only.
                //['actions' => ['index', 'add', 'edit', 'view', 'changePassword'], 'allow' => '@']
            ],
            Controller\JsonController::class => [
                ['actions' => ['index', 'ip'], 'allow' => '*'],
                // Give access to "index", "add", "edit", "view", "changePassword" actions to authorized users only.
                //['actions' => ['index', 'add', 'edit', 'view', 'changePassword'], 'allow' => '@']
            ],
            Controller\ConfigController::class => [
                ['actions' => ['index', 'details'], 'allow' => '*'],
                // Give access to "index", "add", "edit", "view", "changePassword" actions to authorized users only.
                //['actions' => ['index', 'add', 'edit', 'view', 'changePassword'], 'allow' => '@']
            ],
            Controller\InitestController::class => [
                ['actions' => ['index'], 'allow' => '*'],
                // Give access to "index", "add", "edit", "view", "changePassword" actions to authorized users only.
                //['actions' => ['index', 'add', 'edit', 'view', 'changePassword'], 'allow' => '@']
            ],

        ]
    ],

    'controllers' => [
        'factories' => [
            //Controller\IndexController::class => InvokableFactory::class,
            Controller\IndexController::class => Controller\IndexControllerFactory::class,
            Controller\MyController::class => Controller\MyControllerFactory::class,
            Controller\JsonController::class => Controller\JsonControllerFactory::class,
            Controller\ConfigController::class => Controller\ConfigControllerFactory::class,
            Controller\InitestController::class => Controller\InitestControllerFactory::class,
        ],
    ],
    'controller_plugins' => array(
        'factories' => array(
            Controller\Plugin\GetConfig::class  => Controller\Plugin\GetConfigFactory::class,
            Controller\Plugin\Testy::class  => Controller\Plugin\TestyFactory::class,
        ),
        'aliases' => [
            'getDevConfig' => Controller\Plugin\GetConfig::class,
            'getTest' => Controller\Plugin\Testy::class,
        ]
    ),

    'service_manager' => [
        'factories' => [
            Service\Test::class => Service\TestFactory::class,
            //Navigation\DevNavigation::class => Navigation\DevNavigationFactory::class,
        ],
        'aliases' => [
            //'DevMenuLocalNavigation' => Navigation\DevNavigation::class,
        ]
    ],
    'view_helpers' => [
        'factories' => [
            //View\Helper\MenuLocal::class => InvokableFactory::class,
            View\Helper\MenuLocal::class => View\Helper\MenuLocalFactory::class,
        ],
       'aliases' => [
            'devMenuLocal' => View\Helper\MenuLocal::class
       ],
    ], 
    'view_manager' => [
        'template_path_stack' => [
            'dev' => __DIR__ . '/../view',
        ],
        'strategies' => [
            'ViewJsonStrategy',
        ],
    ],

];