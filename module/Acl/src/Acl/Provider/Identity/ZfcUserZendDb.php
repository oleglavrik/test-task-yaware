<?php
/**
 * BjyAuthorize Module (https://github.com/bjyoungblood/BjyAuthorize)
 *
 * @link https://github.com/bjyoungblood/BjyAuthorize for the canonical source repository
 * @license http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Acl\Provider\Identity;

use BjyAuthorize\Exception\InvalidRoleException;
use Zend\Db\Adapter\Adapter;
use Zend\Db\Sql\Where;
use Zend\Db\Sql\Sql;
use Zend\Permissions\Acl\Role\RoleInterface;
use ZfcUser\Service\User;
use BjyAuthorize\Provider\Identity\ProviderInterface;

/**
 * Identity provider based on {@see \Zend\Db\Adapter\Adapter}
 *
 * @author Ben Youngblood <bx.youngblood@gmail.com>
 */
class ZfcUserZendDb implements ProviderInterface
{
    /**
     * @var User
     */
    protected $userService;

    /**
     * @var string|\Zend\Permissions\Acl\Role\RoleInterface
     */
    protected $defaultRole;

    /**
     * @var string
     */
    protected $tableName = 'user_role_linker';

    /**
     * @param \Zend\Db\Adapter\Adapter $adapter
     * @param \ZfcUser\Service\User    $userService
     */
    public function __construct(Adapter $adapter, User $userService)
    {
        $this->adapter     = $adapter;
        $this->userService = $userService;
    }

    /**
     * {@inheritDoc}
     */
    public function getIdentityRoles()
    {
        $authService = $this->userService->getAuthService();
        if (! $authService->hasIdentity()) {
            return array($this->getDefaultRole());
        }
        // get roles associated with the logged in user
        $sql
            = new Sql($this->adapter);
        $select = $sql->select()
            ->columns(array('role_id' => 'roleId'))
            ->from(array('roles' => 'user_role'))
            ->join(array('linker' => $this->tableName), 'roles.id = linker.role_id', array())
            ->where(array('linker.user_id = ?' => $authService->getIdentity()->getId()));
        $results = $sql->prepareStatementForSqlObject($select)->execute();
        $roles
            = array();
        foreach ($results as $i) {
            $roles[] = $i['role_id'];
        }
        return $roles;
    }

    /**
     * @return string|\Zend\Permissions\Acl\Role\RoleInterface
     */
    public function getDefaultRole()
    {
        return $this->defaultRole;
    }

    /**
     * @param string|\Zend\Permissions\Acl\Role\RoleInterface $defaultRole
     *
     * @throws \BjyAuthorize\Exception\InvalidRoleException
     */
    public function setDefaultRole($defaultRole)
    {
        if (! ($defaultRole instanceof RoleInterface || is_string($defaultRole))) {
            throw InvalidRoleException::invalidRoleInstance($defaultRole);
        }

        $this->defaultRole = $defaultRole;
    }
}
