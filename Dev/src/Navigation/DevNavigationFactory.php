<?php

namespace Dev\Navigation;

use Zend\Navigation\Service\AbstractNavigationFactory;

class DevNavigationFactory extends AbstractNavigationFactory
{
    /**
     * @return string
     */
    protected function getName()
    {
        return 'dev';
    }
}
