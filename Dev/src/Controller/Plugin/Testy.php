<?php

//http://www.masterzendframework.com/servicemanager/accessing-servicemanager-services-controller-plugins/

namespace Dev\Controller\Plugin;

use Zend\Mvc\Controller\Plugin\AbstractPlugin;
use Interop\Container\ContainerInterface;

use Dev\Service\Test;

class Testy extends AbstractPlugin
{

    protected $sm;

    public function __construct(ContainerInterface $sm)
    {
        $this->sm = $sm;
    }

    public function __invoke(array $param = null)
    {

        return $this->sm->get(Test::class);
        
    }



}