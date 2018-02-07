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
class ProductForm extends Form
{
    /**
     * Scenario ('create' or 'update').
     * @var string
     */
    private $scenario;

    /**
     * Entity manager.
     * @var Doctrine\ORM\EntityManager
     */
    private $entityManager = null;

    /**
     * Current user.
     * @var User\Entity\User
     */
    private $product = null;

    /**
     * Constructor.
     */
    public function __construct($scenario = 'create', $entityManager = null, $product = null)
    {
        // Define form name
        parent::__construct('product-form');

        // Set POST method for this form
        $this->setAttribute('method', 'post');

        // Save parameters for internal use.
        $this->scenario = $scenario;
        $this->entityManager = $entityManager;
        $this->product = $product;

        $this->addElements();

    }

    /**
     * This method adds elements to form (input fields and submit button).
     */
    protected function addElements()
    {
        // Add "full_name" field
        $this->add([
            'type'  => 'text',
            'name' => 'name',
            'options' => [
                'label' => 'nazwa produktu',
            ],
        ]);

        // Add "email" field
        $this->add([
            'type'  => 'number',
            'name' => 'insurer_id',
            'options' => [
                'label' => 'ubezpieczyciel',
            ],
        ]);

        // Add "status" field
        $this->add([
            'type'  => 'select',
            'name' => 'active',
            'options' => [
                'label' => 'Status',
                'value_options' => [
                    1 => 'Active',
                    0 => 'Retired',
                ]
            ],
        ]);
        // Add "full_name" field
        $this->add([
            'type'  => 'text',
            'name' => 'description',
            'options' => [
                'label' => 'opis produktu',
            ],
        ]);

        // Add "full_name" field
        $this->add([
            'type'  => 'text',
            'name' => 'access_code',
            'options' => [
                'label' => 'kod dostepu',
            ],
        ]);

        // Add "full_name" field
        $this->add([
            'type'  => 'text',
            'name' => 'price',
            'options' => [
                'label' => 'cena',
            ],
        ]);

        // Add the Submit button
        $this->add([
            'type'  => 'submit',
            'name' => 'submit',
            'attributes' => [
                'value' => 'Create'
            ],
        ]);
    }
}