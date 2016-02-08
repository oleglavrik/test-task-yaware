<?php

namespace Acl\Form;

use Zend\Form\ElementInterface;
use Zend\Form\Form;

class AddUserForm extends Form {
    public function __construct($name = null){
        parent::__construct('AddUserForm');
        $this->setAttribute('method', 'POST');

        # basic inputs
        $this->add(
            array(
                'name'    => 'email',
                'type'    => 'text',
                'options' => array(
                    'label' => 'Email:'
                ),
                'attributes' => array(
                    'class' => 'form-control'
                ),
            )
        );

        $this->add(
            array(
                'name'    => 'password',
                'type'    => 'password',
                'options' => array(
                    'label' => 'Password:'
                ),
                'attributes' => array(
                    'class' => 'form-control'
                ),
            )
        );

        $this->add(
            array(
                'name'    => 'passwordAgain',
                'type'    => 'password',
                'options' => array(
                    'label' => 'Repeat password:'
                ),
                'attributes' => array(
                    'class' => 'form-control'
                ),
            )
        );

        $this->add(
            array(
                'name'    => 'role',
                'type'    => 'Zend\Form\Element\Select',
                'options' => array(
                    'label'         => 'Role:',
                    'value_options' => array(
                        'owner'    => 'Owner',
                        'admin'    => 'Admin',
                        'employee' => 'Employee',
                    ),
                ),
                'attributes' => array(
                    'class' => 'form-control'
                ),
            )
        );

        $this->add(
            array(
                'name'       => 'submit',
                'type'       => 'submit',
                'attributes' => array(
                    'value' => 'Add user',
                    'class' => 'btn-primary btn-sm no-border margin-10'
                ),
            )
        );
    }

    public function setOption($key, $value){
        # TODO Implement this method
    }
} 