<?php

namespace Acl\Controller;

use Acl\Filter\AddUserFilter;
use Acl\Form\AddUserForm;
use Acl\Model\GetUsers;
use Acl\Model\AddUser;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class AccountController extends AbstractActionController
{
    protected function getAdapter(){
        $sm = $this->getServiceLocator();
        $adapter = $sm->get('Zend\Db\Adapter\Adapter');

        return $adapter;
    }

    public function indexAction()
    {
        $allUsers = new GetUsers($this->getAdapter(), 'user');
        $allUsers = $allUsers->getUsers();
        return new ViewModel(
            array(
                'allUsers' => $allUsers
            )
        );
    }

    public function addAction(){
        $form = new AddUserForm();

        $request = $this->getRequest();
        if($request->isPost()){
            $filter = new AddUserFilter();
            $form->setInputFilter($filter->getInputFilter());
            $form->setData($request->getPost());

            if($form->isValid()){
                $addUser = new AddUser($this->getAdapter(), 'user', 'user_role', 'user_role_linker');
                $addUser->addUser($form->getData());
                $this->flashMessenger()->addMessage('User added successfully');

                return $this->redirect()->toRoute('account');
            }
        }

        return new ViewModel(
            array(
                'form' => $form,
            )
        );
    }


}

