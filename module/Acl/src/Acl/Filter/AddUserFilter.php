<?php

namespace Acl\Filter;

use Zend\InputFilter\Factory as InputFactory;
use Zend\InputFilter\InputFilter;
use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface;

class AddUserFilter implements InputFilterAwareInterface {
    protected $inputFilter;

    public function setInputFilter(InputFilterInterface $inputFilter){
        throw new \Exception('Don\'t use it!!!');
    }

    public function getInputFilter(){
        if(!$this->inputFilter){
            $inputFilter = new InputFilter();
            $factory     = new InputFactory();

            $inputFilter->add($factory->createInput(
                array(
                    'name'     => 'email',
                    'required' => true,
                    'filters'  => array(
                        array('name' => 'StripTags'),
                        array('name' => 'StringTrim')
                    ),
                    'validators' => array(
                        array(
                            'name'    => 'EmailAddress',
                            'options' => array(
                                'domain'   => 'true',
                                'hostname' => 'true',
                                'mx'       => 'true',
                                'deep'     => 'true',
                                'message'  => 'Invalid email address',
                            )
                        )

                    )
                )
            ));

            $inputFilter->add($factory->createInput(
                array(
                    'name'     => 'password',
                    'required' => true,
                    'filters'  => array(
                        array('name' => 'StripTags'),
                        array('name' => 'StringTrim')
                    ),
                    'validators' => array(
                        array(
                            'name'    => 'StringLength',
                            'options' => array(
                                'encoding' => 'UTF-8',
                                'min'      => 3,
                                'max'      => 32
                            )
                        )
                    )
                )
            ));

            $inputFilter->add($factory->createInput(
                array(
                    'name'     => 'passwordAgain',
                    'required' => true,
                    'filters'  => array(
                        array('name' => 'StripTags'),
                        array('name' => 'StringTrim')
                    ),
                    'validators' => array(
                        array(
                            'name'    => 'StringLength',
                            'options' => array(
                                'encoding' => 'UTF-8',
                                'min'      => 3,
                                'max'      => 32
                            )
                        ),
                        array(
                            'name' => 'Identical',
                            'options' => array(
                                'token' => 'password'
                            )
                        )
                    )
                )
            ));

            $inputFilter->add($factory->createInput(
                array(
                    'name'     => 'role',
                    'required' => true,
                    'filters'  => array(
                        array('name' => 'StripTags'),
                        array('name' => 'StringTrim')
                    ),
                    'validators' => array(
                        array(
                            'name' =>'NotEmpty',
                            'options' => array(
                                'messages' => array(
                                    \Zend\Validator\NotEmpty::IS_EMPTY => 'Role can not be empty.'
                                ),
                            ),
                        ),

                    )
                )
            ));

            $this->inputFilter = $inputFilter;
        }

        return $this->inputFilter;
    }
} 