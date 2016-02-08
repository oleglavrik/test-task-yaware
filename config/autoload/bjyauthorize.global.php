<?php
    return array(
        'bjyauthorize' => array(
            'default_role'       => 'guest',
            'authenticated_role' => 'user',
            'identity_provider'  => 'BjyAuthorize\Provider\Identity\AuthenticationIdentityProvider',
        ),
    );