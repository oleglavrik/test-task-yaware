<?php

namespace Acl\Model;

use Zend\Crypt\Password\Bcrypt;
use Zend\Db\TableGateway\TableGateway;
use Zend\Db\Sql\Select;


class AddUser {
    protected $tableGateway;
    protected $tableGateway2;
    protected $tableGateway3;

    public function __construct($dbadapter, $table, $table2, $table3){
        $this->tableGateway  = new TableGateway($table, $dbadapter);
        $this->tableGateway2 = new TableGateway($table2, $dbadapter);
        $this->tableGateway3 = new TableGateway($table3, $dbadapter);
    }

    public function addUser($data){
        # get data
        $email    = (isset($data['email'])    ? $data['email']    : null);
        $password = (isset($data['password']) ? $data['password'] : null);
        $role     = (isset($data['role'])     ? $data['role']     : null);

        # Bcrypt for password
        if(!is_null($password)){
            $bcrypt = new Bcrypt();
            $bcrypt->setCost(14);
            $password = $bcrypt->create($password);
        }
        # insert new personal data user
        $arr = array(
            'email'    => $email,
            'password' => $password
        );

        $this->tableGateway->insert($arr);

        # select current user id
        $userId = $this->tableGateway->select(
            function (Select $select) use ($email){
                $select
                    ->columns(
                        array(
                            'user_id'
                        )
                    )
                    ->where(
                        array(
                            'email' => $email
                        )
                    )
                    ->limit(1);
            }
        );
        $userId = $userId->toArray();

        # select id role
        $userRoleId = $this->tableGateway2->select(
            function (Select $select) use ($role){
                $select
                    ->columns(
                        array(
                            'id'
                        )
                    )
                    ->where(
                        array(
                            'roleId' => $role
                        )
                    )
                    ->limit(1);
            }
        );

        $userRoleId = $userRoleId->toArray();

        $arr = array(
            'user_id' => $userId['0']['user_id'],
            'role_id' => $userRoleId['0']['id']
        );

        # insert role for new user
        $this->tableGateway3->insert($arr);
    }
} 