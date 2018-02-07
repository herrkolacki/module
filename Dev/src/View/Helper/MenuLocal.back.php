<?php

//inne podejście
//https://olegkrivtsov.github.io/using-zend-framework-3-book/html/en/Page_Appearance_and_Layout/Writing_Own_View_Helpers.html

namespace Dev\View\Helper;

use Zend\View\Helper\AbstractHelper;

class MenuLocal extends AbstractHelper
{

    //protected $param;
    protected $navigation;

    //public function __construct() {}

    public function __invoke($param = null)
    {

//\Zend\Debug\Debug::dump( Ser::stest() , __METHOD__ . ' [' . __LINE__ . ']: ' );
//\Zend\Debug\Debug::dump( 'fooBar' , __METHOD__ . ' [' . __LINE__ . ']: ' );

        //$this->param = $param;

//\Zend\Debug\Debug::dump($param, __METHOD__ . ': param: ' ); 


        $this->navigation = $this->getView()->navigation('DevMenuLocalNavigation');


        $this->navigation->menu()
            ->setOnlyActiveBranch(true)
            //->setUlClass('nav menu-local list-group')
            //->setUlClass('col-md-12 nav nav-tabs menu-local-tabs list-group menu-test')
            ->setUlClass('nav menu-local-tabs list-group menu-test')
            ->setMinDepth(1)
            ->setMaxDepth(1)
            //->setPartial('/partial/menu/local')
            //->setPartial('/partial/menu/test2')
            ;

//\Zend\Debug\Debug::dump($this->navigation->menu()->render() , __METHOD__ . ': menu: ' ); 
//die(__METHOD__);

        return $this;

    }


    /*
    public function __call($method, $args = null)
    {

        IF (method_exists($this->getFirma(), $method)) {
            return call_user_func_array(array($this->getFirma(), $method), $args);
        }
        return FALSE;

    }
    */

    public function __toString() 
    {

        return $this->navigation->menu()->render();
        //return '<h1>Cokolwiek Test MenuLocal</h1>';
    }


    public function getException($message = null)
    {
        throw new \Exception('Route Match does not exist in Helper!' . ($message ? ' ' . $message . '' : ''));
    }

}