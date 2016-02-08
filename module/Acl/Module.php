<?php

namespace Acl;

use Zend\Mvc\MvcEvent;
use Zend\Mvc\Router\RouteMatch;
use Zend\View\Helper\Navigation;

class Module
{
    protected $whitelist = array('zfcuser/login');

    public function onBootstrap($e){
        $app = $e->getApplication();
        $em  = $app->getEventManager();
        $sm  = $app->getServiceManager();
        $list = $this->whitelist;
        $auth = $sm->get('zfcuser_auth_service');

        # global check access
        $em->attach(MvcEvent::EVENT_ROUTE, function($e) use ($list, $auth) {
            $match = $e->getRouteMatch();
            # No route match, this is a 404
            if (!$match instanceof RouteMatch) {
                return;
            }
            # Route is whitelisted
            $name = $match->getMatchedRouteName();
            if (in_array($name, $list)) {
                return;
            }
            # User is authenticated
            if ($auth->hasIdentity()) {
                return;
            }
            # Redirect to the user login page
            $router   = $e->getRouter();
            $url      = $router->assemble(array(), array(
                'name' => 'zfcuser/login'
            ));
            $response = $e->getResponse();
            $response->getHeaders()->addHeaderLine('Location', $url);
            $response->setStatusCode(302);
            return $response;
        }, -100);

        # if not auth change Template
        if (!$auth->hasIdentity()) {
            $em->attach(MvcEvent::EVENT_ROUTE, function($e) {
                $vm = $e->getViewModel();
                $vm->setTemplate('layout/blank');
            });
        }

        # Add ACL information to the Navigation view helper
        $authorize = $sm->get('BjyAuthorizeServiceAuthorize');
        $acl       = $authorize->getAcl();
        $role      = $authorize->getIdentity();
        Navigation::setDefaultAcl($acl);
        Navigation::setDefaultRole($role);

    }

    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }

    public function getAutoloaderConfig()
    {
        return array(
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                ),
            ),
        );
    }

}
