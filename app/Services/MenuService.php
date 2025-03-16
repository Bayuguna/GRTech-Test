<?php

namespace App\Services;

use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Request;

class MenuService
{
	/*
	 * text => Nama menu yang tampil pada web
	 * id => memberikan id pada masing-masing nav
	 * url => url menu
	 * icon => icon menu
	 * active => patern agar menu aktif. Sesuaikan dengan url pada route.
	 */
	public static function getSideBarMenu()
	{
		return [
			[
				'text' => 'Dashboard',
				'id' => 'dashboard',
				'url' => route('dashboard'),
				'icon' => 'chart-simple',
				'active' => ['dashboard'],
				// 'can' => ['dashboard'],
			],
			[
				'text' => 'User',
				'id' => 'users',
				'url' => route('user.index'),
				'icon' => 'user-secret',
				'active' => ['user.*'],
				'can' => ['user:view'],
			],
			[
				'text' => 'Employee',
				'id' => 'employees',
				'url' => route('employee.index'),
				'icon' => 'user-secret',
				'active' => ['employee.*'],
				'can' => ['employee:view'],
			],
			[
				'text' => 'Company',
				'id' => 'dashboard',
				'url' => route('company.index'),
				'icon' => 'ticket',
				'active' => ['company.*'],
				'can' => ['company:view'],
			],
			[
				'text' => 'Settings',
				'id' => 'settings',
				'icon' => 'cogs',
				'active' => ['setting.*'],
				'can' => ['role:view', 'access:view'],
				'submenus' => [
					[
						'text' => 'Role',
						'id' => 'role',
						'url' => route('setting.role.index'),
						'icon' => 'box',
						'active' => ['setting.role.*'],
						'can' => ['role:view'],
					],
					[
						'text' => 'Access',
						'id' => 'access',
						'url' => route('setting.access.index'),
						'icon' => 'box',
						'active' => ['setting.access.*'],
						'can' => ['access:view'],
					],
				]
			],
			// [
			// 	'text' => 'Notifications',
			// 	'id' => 'dashboard',
			// 	'url' => '',
			// 	'icon' => 'bell',
			// 	'active' => ['backend/dashboard'],
			// ],
		];
	}


	public static function isActive($segments)
	{
		foreach ($segments as $segment) {
			if (Request::is($segment)) {
				return true;
			}
		}

		return false;
	}
}
