<?php

namespace Acl\View\Helper;

use Zend\View\Helper\AbstractHelper;
use Zend\View\Helper\FlashMessenger;

class ShowMessages extends AbstractHelper {
    public function __invoke(){
        $messenger = new FlashMessenger();
        $errorMessages = $messenger->getErrorMessages();
        $messages      = $messenger->getMessages();

        $result = '';
        # create error messages
        if(count($errorMessages)){
            $result .= '<div class="alert alert-danger"> ';
                $result .= '<ul>';
                    foreach($errorMessages as $message){
                        $result .= '<li>' .$message . '</li>';
                    }
                $result .= '</ul>';
            $result .= '</div>';
        }

        #create successful messages
        if(count($messages)){
            $result .= '<div class="alert alert-success">';
                $result .= '<ul>';
                    foreach($messages as $message){
                        $result .= '<li>' . $message . '</li>';
                    }
                $result .= '</ul>';
            $result .= '</div>';
        }

        return $result;
    }
} 