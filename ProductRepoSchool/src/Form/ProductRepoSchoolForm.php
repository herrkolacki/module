<?php
namespace ProductRepoSchool\Form;

use Zend\Form\Form;

/**
 * This form is used to collect user's email, full name, password and status. The form
 * can work in two scenarios - 'create' and 'update'. In 'create' scenario, user
 * enters password, in 'update' scenario he/she doesn't enter password.
 */
class ProductRepoSchoolForm extends Form
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
    private $productRepoSchool = null;

    /**
     * Constructor.
     */
    public function __construct($scenario = 'create', $entityManager = null, $productRepoSchool = null)
    {
        // Define form name
        parent::__construct('productRepo-form');

        // Set POST method for this form
        $this->setAttribute('method', 'post');

        // Save parameters for internal use.
        $this->scenario = $scenario;
        $this->entityManager = $entityManager;
        $this->productRepoSchool = $productRepoSchool;

        $this->addElements();

    }

    /**
     * This method adds elements to form (input fields and submit button).
     */
    protected function addElements()
    {
        // Add "full_name" field
        $this->add([
            'type'  => 'number',
            'name' => 'product_repo_id',
            'options' => [
                'label' => 'repoID',
            ],
        ]);

        // Add "email" field
        $this->add([
            'type'  => 'text',
            'name' => 'comment',
            'options' => [
                'label' => 'komentarz',
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