<?php

    return array(
        'router' => array(
            'routes' => array(
                # dashboard
                'dashboard' => array(
                    'type'    => 'Zend\Mvc\Router\Http\Literal',
                    'options' => array(
                        'route'    => '/',
                        'defaults' => array(
                            'controller' => 'Acl\Controller\Dashboard',
                            'action'     => 'index'
                        ),
                    ),
                ),
                # reports
                'reports' => array(
                    'type'    => 'Zend\Mvc\Router\Http\Literal',
                    'options' => array(
                        'route'    => '/reports',
                        'defaults' => array(
                            'controller' => 'Acl\Controller\Reports',
                            'action'     => 'index'
                        ),
                    ),
                ),
                # configuration
                'configuration' => array(
                    'type'    => 'Zend\Mvc\Router\Http\Literal',
                    'options' => array(
                        'route'    => '/configuration',
                        'defaults' => array(
                            'controller' => 'Acl\Controller\Configuration',
                            'action'     => 'index'
                        ),
                    ),
                ),
                # account
                'account' => array(
                    'type'    => 'Zend\Mvc\Router\Http\Literal',
                    'options' => array(
                        'route'    => '/account',
                        'defaults' => array(
                            'controller' => 'Acl\Controller\Account',
                            'action'     => 'index'
                        ),
                    ),
                    'may_terminate' => true,
                    'child_routes' => array(
                        # account/addUser
                        'adduser' => array(
                            'type' => 'Zend\Mvc\Router\Http\Literal',
                            'options' => array(
                                'route' => '/add',
                                'defaults' => array(
                                    'controller' => 'Acl\Controller\Account',
                                    'action'     => 'add'
                                )
                            ),
                        ),
                    ),
                ),
            ),
        ),
        'controllers' => array(
            'invokables' => array(
                'Acl\Controller\Dashboard'     => 'Acl\Controller\DashboardController',
                'Acl\Controller\Reports'       => 'Acl\Controller\ReportsController',
                'Acl\Controller\Configuration' => 'Acl\Controller\ConfigurationController',
                'Acl\Controller\Account'       => 'Acl\Controller\AccountController',
            ),
        ),
        'navigation' => array(
            'default' => array(
                array(
                    'label'    => 'Dashboard',
                    'route'    => 'home',
                    'resource' => 'Acl\Controller\DashboardController',
                ),
                array(
                    'label'    => 'Reports',
                    'route'    => 'reports',
                    'resource' => 'Acl\Controller\ReportsController',
                ),
                array(
                    'label'    => 'Configuration',
                    'route'    => 'configuration',
                    'resource' => 'Acl\Controller\ConfigurationController',
                ),
                array(
                    'label'    => 'Account',
                    'route'    => 'account',
                    'resource' => 'Acl\Controller\Account',
                ),
                array(
                    'label'    => 'Logout',
                    'route'    => 'zfcuser/logout',
                    'resource' => 'Zfcuser\Logout',
                ),
            )
        ),
        'view_manager' => array(
            'display_not_found_reason' => true,
            'display_exceptions'       => true,
            'doctype'                  => 'HTML5',
            'not_found_template'       => 'error/404',
            'exception_template'       => 'error/index',
            'template_map'             => array(
                'layout/layout'   => __DIR__ . '/../view/layout/layout.phtml',
                'acl/index/index' => __DIR__ . '/../view/acl/dashboard/index.phtml',
                'error/404'       => __DIR__ . '/../view/error/404.phtml',
                'error/403'       => __DIR__ . '/../view/error/403.phtml',
                'error/index'     => __DIR__ . '/../view/error/index.phtml',
            ),
            'template_path_stack' => array(
                __DIR__ . '/../view',
            ),
        ),
        'service_manager' => array(
            'factories' => array(
                'navigation'                          => 'Zend\Navigation\Service\DefaultNavigationFactory',
                'Acl\Provider\Identity\ZfcUserZendDb' => 'Acl\Service\ZfcUserZendDbIdentityProviderServiceFactory'
            ),
        ),
        'view_helpers' => array(
            'invokables' => array(
                'showMessages' => 'Acl\View\Helper\ShowMessages',
            ),
        ),


    );