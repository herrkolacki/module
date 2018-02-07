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

        return $this;

    }


    public function __toString() 
    {
        //return '<h1>Cokolwiek Test MenuLocal</h1>';
        return '
<ul class="nav nav-tabs">

    <li>
        <a href="/dev">Dev</a>
    </li>
    <li>
        <a href="/dev/config">Config</a>
    </li>
    <li>
        <a href="/dev/json">JSON (return JsonModel)</a>
    </li>
    <li>
        <a href="/dev/my/ip">My IP</a>
    </li>
    <li>
        <a href="/dev/initest">Init test</a>
    </li>

</ul>
        ';
    }



}