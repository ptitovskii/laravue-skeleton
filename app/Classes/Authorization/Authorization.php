<?php

namespace App\Classes\Authorization;

use App\Enumeration\GoalState;
use App\Models\Goal;
use Dlnsk\HierarchicalRBAC\Authorization as AuthorizationRbac;


/**
 *  This is example of hierarchical RBAC authorization configiration.
 */

class Authorization extends AuthorizationRbac
{
	public function getPermissions()
    {
		return [
		];
	}

	public function getRoles()
    {
		return [
			'manager' => [
            ],
			'user' => [
            ],
		];
	}

    /**
     * Checking permission for choosed user
     *
     * @return boolean
     */
    public function checkPermission($user, $ability, $arguments)
    {
        if ($user->role === 'admin') {
            return true;
        }

        // У пользователя роль, которой нет в списке
        $roles = $this->getRoles();
        if (!isset($roles[$user->role])) {
            return null;
        }

        // Ищем разрешение для данной роли среди наследников текущего разрешения
        $role = $roles[$user->role];
        $permissions = $this->getPermissions();
        $current = $ability;
        // Если для разрешения указана замена - элемент 'equal', то проверяется замена
        // (только при наличии оригинального разрешения в роли).
        // Callback оригинального не вызывается.
        if (in_array($current, $role) and isset($permissions[$current]['equal'])) {
            $current = $permissions[$current]['equal'];
        }

        $i = 0;
        $suitable = false;
        while (true) {
            if ($i++ > 100) {
                throw new \Exception("Seems like permission '{$ability}' is in infinite loop");
            }

            if (in_array($current, $role)) {
                $suitable = $suitable || $this->testUsingUserMethod($user, $ability, $current, $arguments);
            }
            if (isset($permissions[$current]['next']) and !$suitable) {
                $current = $permissions[$current]['next'];
            } else {
                return $suitable ? true : null;
            }
        }
        return null;
    }

    protected function testUsingUserMethod($user, $initial_ability, $current_ability, $arguments) {
        $methods = get_class_methods($this);
        $method = camel_case($current_ability);
        if (in_array($method, $methods)) {
            // Преобразуем массив в единичный элемент если он содержит один элемент
            // или это ассоциативный массив с любым кол-вом элементов
            if (!empty($arguments)) {
                $arg = (count($arguments) > 1 or array_keys($arguments)[0] !== 0) ? $arguments : last($arguments);
            } else {
                $arg = null;
            }
            return $this->$method($user, $arg, $initial_ability) ? true : false;
        }
        return true;
    }
}
