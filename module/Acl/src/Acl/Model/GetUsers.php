<?php

namespace Acl\Model;

use Zend\Db\TableGateway\TableGateway;
use Zend\Db\Sql\Select;

class GetUsers {
    protected $tableGateway;

    public function __construct($adapter, $table){
        $this->tableGateway = new TableGateway($table, $adapter);
    }

    public function getUsers(){
        $select = $this->tableGateway->select(
            function(Select $select){
                $select->columns(array('email'))
                    ->join('user_role_linker', 'user.user_id = user_role_linker.user_id', null)
                    ->join('user_role', 'user_role.id = user_role_linker.role_id', 'roleId');
            }
        );

        # clear array
        foreach($select->toArray() as $item){
            $arr[] = array_diff($item, array(''));
        }
        return $arr;
    }
} 