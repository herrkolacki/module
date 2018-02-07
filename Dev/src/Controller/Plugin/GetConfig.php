<?php

//http://www.masterzendframework.com/servicemanager/accessing-servicemanager-services-controller-plugins/

namespace Dev\Controller\Plugin;

use Zend\Mvc\Controller\Plugin\AbstractPlugin;


class GetConfig extends AbstractPlugin
{

    protected $config;


    public function __construct(array $config)
    {
        $this->config = $config;
    }

    public function __invoke(array $param = null)
    {

        $localKey = ( isset($param["key"]) && array_key_exists($param["key"], $this->config) ? $param["key"] : NULL);
        $type = (isset($param["type"]) ? $param["type"] : 'object');

/*
\Zend\Debug\Debug::dump( $param, __METHOD__ . ', $param: ' );
\Zend\Debug\Debug::dump( $localKey, __METHOD__ . ', $localKey: ' );
\Zend\Debug\Debug::dump( $type, __METHOD__ . ', $type: ' );
//\Zend\Debug\Debug::dump( $this->config, __METHOD__ . ' :: ' );
\Zend\Debug\Debug::dump( array_key_exists($localKey, $this->config), __METHOD__ . ', array_key_exists(): ' );
*/

        $out = [
            'mainKeys' => $this->getMainKeys(),
            'localKeys' => $this->getLocalKeys($localKey),
        ];

        if ($type === 'object') {
            return $this->objectOut($out);
        }

        return $out;
        
    }

    public function objectOut($obj)
    {
        return new \Zend\Config\Config($obj);
    }

    public function getMainKeys()
    {

        /*
        $array = array();
        foreach ( $this->config as $id => $item ) {
            //$array[$id] = key($item);
            $array[] = $id;
            //array_push($array, $id);
        }
        */

        $array = array_keys($this->config);

        return $array;
    }

    public function getLocalKeys($localKey = NULL)
    {
        if (!$localKey) return NULL;
        $array = array();
        foreach ( $this->config[$localKey] as $id => $item ) {
            $array[$id] = $item;
        }

        /*
        if (isset($array["connection"]["orm_default"])) {
            $array["connection"]["orm_default"]["params"]["password"] = ':)';
        }
        */
        
        isset($array["connection"]["orm_default"]["params"]) && $array["connection"]["orm_default"]["params"] = ':)';
        isset($array["password"]) && $array["password"] = ':)';
        isset($array["username"]) && $array["username"] = ':)';


        return $array;
    }


}