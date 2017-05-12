<?php
/**
 * Global Configuration Override
 *
 * You can use this file for overriding configuration values from modules, etc.
 * You would place values in here that are agnostic to the environment and not
 * sensitive to security.
 *
 * @NOTE: In practice, this file will typically be INCLUDED in your source
 * control, so do not include passwords or other sensitive information in this
 * file.
 */
use Zend\Db\Adapter\AdapterAbstractServiceFactory;
use Zend\Session\Storage\SessionArrayStorage;
use Zend\Session\Validator\RemoteAddr;
use Zend\Session\Validator\HttpUserAgent;
return [
    'session_config' => [
        // Session cookie will expire in 1 hour.
        'cookie_lifetime' => 60*60*1,
        // Session data will be stored on server maximum for 30 days.
        'gc_maxlifetime'     => 60*60*24*30,
    ],
    'session_manager' => [
        // Session validators (used for security).
        'validators' => [
           RemoteAddr::class,
            HttpUserAgent::class,
        ]
    ],
    'session_storage' => [
        'type' => SessionArrayStorage::class
    ],
  //  'driver' => 'Pdo',
    //'dsn' => 'mysql:dbname=repair;host=localhost',
    'service_manager' => [
        'abstract_factories' => [
            AdapterAbstractServiceFactory::class,
        ],
    ],
    'doctrine' => [
        'connection' => [
            'orm_default' => [
                'driverClass' => 'Doctrine\DBAL\Driver\PDOMySql\Driver',
                'params'      => [
                    'host'     => 'localhost',
                    'user'     => 'bbinvest_1',
                    'password' => 'Moje1234',
                    'dbname'   => 'bbinvest_insurance',
                    'serverVersion' => '5.5.2'                   // <---- ADD THIS
                ]
            ],
        ],
    ],
];

