<?php
namespace Product\Form;

use Zend\Form\Form;
use Zend\Form\Fieldset;
use Zend\InputFilter\InputFilter;



/**
 * This form is used to collect user's email, full name, password and status. The form 
 * can work in two scenarios - 'create' and 'update'. In 'create' scenario, user
 * enters password, in 'update' scenario he/she doesn't enter password.
 */
class ProductForm extends Form{
    public function init(){
        $this->setHydrator(new ReflectionHydrator());
        $this->setObject(new Car('', '', '', '', '', ''));

        $this->add([
            'type' => 'hidden',
            'name' => 'id',
        ]);
        $this->add([
            'type' => 'hidden',
            'name' => 'userId',
        ]);
        $this->add([
            'type' => 'text',
            'name' => 'brand',
            'options' => [
                'label' => 'Car brand'
            ],
        ]);
        $this->add([
            'type' => 'text',
            'name' => 'model',
            'options' => [
                'label' => 'Car Model'
            ],
        ]);
        $this->add([
            'type' => 'text',
            'name' => 'capacity',
            'options' => [
                'label' => 'Car capacity'
            ],
        ]);
        $this->add([
            'type' => 'text',
            'name' => 'productDate',
            'options' => [
                'label' => 'Car product date'
            ],
        ]);
        $this->add([
            'type' => 'text',
            'name' => 'buyingDate',
            'options' => [
                'label' => 'Car buying Data'
            ],
        ]);
    }
}