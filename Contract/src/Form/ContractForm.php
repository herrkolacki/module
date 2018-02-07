<?php
namespace Contract\Form;

use Zend\Form\Form;

/**
 * This form is used to collect. The form
 * can work in two scenarios - 'create' and 'update'. In 'create' scenario, user
 * enters password, in 'update' scenario he/she doesn't enter password.
 */
class ContractForm extends Form
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
     * Current Contracr.
     * @var Company\Entity\Company
     */
    private $contract = null;

    /**
     * Constructor.
     */
    public function __construct($scenario = 'create', $entityManager = null, $contract = null)
    {
        // Define form name
        parent::__construct('contract-form');

        // Set POST method for this form
        $this->setAttribute('method', 'post');

        // Save parameters for internal use.
        $this->scenario = $scenario;
        $this->entityManager = $entityManager;
        $this->contract = $contract;
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
                'label' => 'nazwa firmy',
            ],
        ]);

        $this->add([
            'type'  => 'text',
            'name' => 'nip',
            'options' => [
                'label' => 'nip firmy',
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