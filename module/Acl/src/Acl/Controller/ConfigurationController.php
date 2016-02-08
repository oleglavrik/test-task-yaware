<?php

namespace Acl\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class ConfigurationController extends AbstractActionController
{

    public function indexAction()
    {
        return new ViewModel();
    }


}

