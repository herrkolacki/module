<?php
namespace ProductRepoSchool\Controller;

use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;
use ProductRepoSchool\Controller\ListController;
use ProductRepoSchool\Service\ProductRepoSchoolManager;

/**
 * This is the factory for UserController. Its purpose is to instantiate the
 * controller and inject dependencies into it.
 */
class ListControllerFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $entityManager = $container->get('doctrine.entitymanager.orm_default');
        $productRepoSchoolManager = $container->get(ProductRepoSchoolManager::class);
        $authService = $container->get(\Zend\Authentication\AuthenticationService::class);
        // Instantiate the controller and inject dependencies
        return new ListController($entityManager, $productRepoSchoolManager, $authService);
    }
}