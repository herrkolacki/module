<?php

namespace Dev\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Interop\Container\ContainerInterface;
use Zend\EventManager\EventManagerInterface;
use Zend\View\Model\ViewModel;

use Dev\Service\Test;

/**
 * This controller is responsible for letting the user to log in and log out.
 */
class InitestController extends AbstractActionController
{

    public $sm;

    public $test;

    /**
     * Constructor.
     */
    public function __construct(ContainerInterface $sm)
    {

        $this->sm = $sm;

        $this->test = $sm->get(Test::class);

\Zend\Debug\Debug::dump( __METHOD__.' ['.__LINE__ . ']' );
\Zend\Debug\Debug::dump($this->test->getDupa(), __METHOD__.' ['.__LINE__ . ']' . ' test->getDupa(): ');


//die( __METHOD__ . ' ' . __LINE__ );

    }

    public function setEventManager(EventManagerInterface $events)
    {

\Zend\Debug\Debug::dump( __METHOD__.' ['.__LINE__ . ']' );

        parent::setEventManager($events);

        //$events->attach('onZdarzenie', array($this, 'metoda'), priorytet); 
        $events->attach('dispatch', array($this, 'test'), 50); 
        $events->attach('dispatch', array($this, 'init'), 100); 
    }

    public function init() {

\Zend\Debug\Debug::dump( __METHOD__.' ['.__LINE__ . ']' );

    }

    public function test() {

\Zend\Debug\Debug::dump( __METHOD__.' ['.__LINE__ . ']' );

    }


    public function indexAction()
    {

\Zend\Debug\Debug::dump( __METHOD__.' ['.__LINE__ . ']' );
\Zend\Debug\Debug::dump($this->test->getDupa(), __METHOD__.' ['.__LINE__ . ']' . ' test->getDupa(): ');
\Zend\Debug\Debug::dump($this->getTest()->getDupa(), __METHOD__.' ['.__LINE__ . ']' . ' getTest()->getDupa(): ');

        return new ViewModel();

    }



}