<?php
namespace Dev\Controller;

use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;


class InitestControllerFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {

\Zend\Debug\Debug::dump( __METHOD__.' ['.__LINE__ . ']' );

        return new InitestController($container);
    }
}