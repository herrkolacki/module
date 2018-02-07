<?php
namespace Dev\Service;


class Test
{

    private $dupa = 'DUPA';
        
    /**
     * Constructor.
     */
    /*
    public function __construct($entityManager)
    {
        $this->entityManager = $entityManager;
    }
    */
    
    public function getDupa()
    {
        return $this->dupa;
    }

    public function setDupa($val)
    {
        $this->dupa = $val;
        return $this;
    }

}


