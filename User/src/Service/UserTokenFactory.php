<?php
namespace User\Service;

use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;

/**
 * This is the factory class for AuthAdapter service. The purpose of the factory
 * is to instantiate the service and pass it dependencies (inject dependencies).
 */
class UserTokenFactory implements FactoryInterface
{
    /**
     * This method creates the AuthAdapter service and returns its instance. 
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $tokenManager = $container->get('doctrine.entitymanager.orm_default');
        return new UserToken($tokenManager);
    }
}
