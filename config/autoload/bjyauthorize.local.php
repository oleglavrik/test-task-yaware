<?php

    $dbParams = array(
        'database' => 'acl_',
        'username' => 'root',
        'password' => 'root',
        'hostname' => 'localhost',
    );

    return array(
        'service_manager' => array(
            'factories' => array(
                'Zend\Db\Adapter\Adapter' => function ($sm) use ($dbParams) {
                    $adapter = new BjyProfiler\Db\Adapter\ProfilingAdapter(array(
                        'driver'   => 'pdo',
                        'dsn'      => 'mysql:dbname='.$dbParams['database']
                            .';host='.$dbParams['hostname'],
                        'database' => $dbParams['database'],
                        'username' => $dbParams['username'],
                        'password' => $dbParams['password'],
                        'hostname' => $dbParams['hostname'],
                    ));
                    if (php_sapi_name() == 'cli') {
                        $logger = new Zend\Log\Logger();
                        // write queries profiling info to stdout in CLI mode
                        $writer = new Zend\Log\Writer\Stream('php://output');
                        $logger->addWriter($writer, Zend\Log\Logger::DEBUG);
                        $adapter->setProfiler(new BjyProfiler\Db\Profiler\LoggingProfiler($logger));
                    } else {
                        $adapter->setProfiler(new BjyProfiler\Db\Profiler\Profiler());
                    }
                    if (isset($dbParams['options']) && is_array($dbParams['options'])) {
                        $options = $dbParams['options'];
                        } else {
                        $options = array();
                    }
                    $adapter->injectProfilingStatementPrototype($options);
                    return $adapter;
                },
            ),
        ),
        'bjyauthorize' => array(
            'default_role'      => 'guest',
            //'identity_provider' => 'BjyAuthorize\Provider\Identity\ZfcUserZendDb',
            'identity_provider' => 'Acl\Provider\Identity\ZfcUserZendDb',
            'role_providers'    => array(
                'BjyAuthorize\Provider\Role\ZendDb' => array(
                    'table'             => 'user_role',
                    'role_id_field'     => 'roleId',
                    'parent_role_field' => 'parent_id',
                ),
            ),
            # basic resources
            'resource_providers' => array(
                'BjyAuthorize\Provider\Resource\Config' => array(
                    'dashboard'      => array('Acl\Controller\DashboardController'),
                    'reports'        => array('Acl\Controller\ReportsController'),
                    'configuration'  => array('Acl\Controller\ConfigurationController'),
                    'account'        => array('Acl\Controller\Account'),
                    'logout'         => array('Zfcuser\Logout'),
                ),
            ),
            # resources rules
            'rule_providers' => array(
                'BjyAuthorize\Provider\Rule\Config' => array(
                    'allow' => array(
                        # access to dashboard resource for all besides guest
                        array(array('owner', 'admin', 'employee'), 'dashboard'),
                        # access to reports resource for owner and employee
                        array(array('owner', 'employee'), 'reports'),
                        # access to configuration resource for owner and admin
                        array(array('owner', 'admin'), 'configuration'),
                        # access to account resource for only owner
                        array(array('owner'), 'account'),
                        # access to logout resource for all besides guest
                        array(array('owner', 'admin', 'employee'), 'logout'),
                    ),
                    'deny'  => array(
                        # admin hasn't access to reports resource
                        array(array('admin'), 'reports'),
                        # employee hasn't access to configuration
                        array(array('employee'), 'configuration'),
                        # admin and employee haven't access to account
                        array(array('admin','employee'), 'account')
                    ),
                ),
            ),
            'guards' => array(
                'BjyAuthorize\Guard\Controller' => array(
                    # default access for everyone
                    array(
                        'controller' => 'zfcuser',
                        'roles'      => array('owner', 'admin', 'employee', 'guest'),
                    ),
                    # access to DashboardController for all besides guest
                    array(
                        'controller' => 'Acl\Controller\Dashboard',
                        'roles'      => array('owner', 'admin', 'employee'),
                    ),
                    # access to ReportsController for owner and employee
                    array(
                        'controller' => 'Acl\Controller\Reports',
                        'roles'      => array('owner', 'employee'),
                    ),

                    # access to ConfigurationController for owner and admin
                    array(
                        'controller' => 'Acl\Controller\Configuration',
                        'roles'      => array('owner', 'admin'),
                    ),

                    # access to AccountController for only owner
                    array(
                        'controller' => 'Acl\Controller\Account',
                        'roles'      => array('owner'),
                    ),
                ),
                'BjyAuthorize\Guard\Route' => array(
                    # default access to routes for everyone
                    array(
                        'route' => 'zfcuser',
                        'roles' => array('owner', 'admin', 'employee', 'guest')
                    ),
                    array(
                        'route' => 'zfcuser/logout',
                        'roles' => array('owner', 'admin', 'employee')
                    ),
                    array(
                        'route' => 'zfcuser/login',
                        'roles' => array('owner', 'admin', 'employee', 'guest')
                    ),
                    # access to route dashboard for all besides guest
                    array(
                        'route' => 'dashboard',
                        'roles' => array('owner', 'admin', 'employee')
                    ),
                    # access to route reports for owner employee
                    array(
                        'route' => 'reports',
                        'roles' => array('owner', 'employee')
                    ),
                    # access to route configuration for owner admin
                    array(
                        'route' => 'configuration',
                        'roles' => array('owner', 'admin')
                    ),
                    # access to route account for only owner
                    array(
                        'route' => 'account',
                        'roles' => array('owner')
                    ),
                    # access to route account/add for only owner
                    array(
                        'route' => 'account/adduser',
                        'roles' => array('owner'),
                    )
                ),
            ),
        ),
    );