<?php

namespace vova07\bank\commands;

use Yii;
use yii\console\Controller;

/**
 * Bank RBAC controller.
 */
class RbacController extends Controller
{
    /**
     * @inheritdoc
     */
    public $defaultAction = 'add';

    /**
     * @var array Main module permission array
     */
    public $mainPermission = [
        'name' => 'administrateBank',
        'description' => 'Can administrate all "Bank" module'
    ];

    /**
     * @var array Permission
     */
    public $permissions = [
        'BViewBank' => [
            'description' => 'Can view backend Bank list'
        ],
        'BCreateBank' => [
            'description' => 'Can create backend Bank'
        ],
        'BUpdateBank' => [
            'description' => 'Can update backend Bank'
        ],
        'BDeleteBank' => [
            'description' => 'Can delete backend Bank'
        ],
        'viewBank' => [
            'description' => 'Can view Bank'
        ],
        'createBank' => [
            'description' => 'Can create Bank'
        ],
        'updateBank' => [
            'description' => 'Can update Bank'
        ],
        'updateOwnBank' => [
            'description' => 'Can update own Bank',
            'rule' => 'author'
        ],
        'deleteBank' => [
            'description' => 'Can delete Bank'
        ],
        'deleteOwnBank' => [
            'description' => 'Can delete own Bank',
            'rule' => 'author'
        ]
    ];

    /**
     * Add comments RBAC.
     */
    public function actionAdd()
    {
        $auth = Yii::$app->authManager;
        $superadmin = $auth->getRole('superadmin');
        $mainPermission = $auth->createPermission($this->mainPermission['name']);
        if (isset($this->mainPermission['description'])) {
            $mainPermission->description = $this->mainPermission['description'];
        }
        if (isset($this->mainPermission['rule'])) {
            $mainPermission->ruleName = $this->mainPermission['rule'];
        }
        $auth->add($mainPermission);

        foreach ($this->permissions as $name => $option) {
            $permission = $auth->createPermission($name);
            if (isset($option['description'])) {
                $permission->description = $option['description'];
            }
            if (isset($option['rule'])) {
                $permission->ruleName = $option['rule'];
            }
            $auth->add($permission);
            $auth->addChild($mainPermission, $permission);
        }

        $auth->addChild($superadmin, $mainPermission);

        $updateBank = $auth->getPermission('updateBank');
        $updateOwnBank = $auth->getPermission('updateOwnBank');
        $deleteBank = $auth->getPermission('deleteBank');
        $deleteOwnBank = $auth->getPermission('deleteOwnBank');

        $auth->addChild($updateBank, $updateOwnBank);
        $auth->addChild($deleteBank, $deleteOwnBank);

        return static::EXIT_CODE_NORMAL;
    }

    /**
     * Remove comments RBAC.
     */
    public function actionRemove()
    {
        $auth = Yii::$app->authManager;
        $permissions = array_keys($this->permissions);

        foreach ($permissions as $name => $option) {
            $permission = $auth->getPermission($name);
            $auth->remove($permission);
        }

        $mainPermission = $auth->getPermission($this->mainPermission['name']);
        $auth->remove($mainPermission);

        return static::EXIT_CODE_NORMAL;
    }
}
