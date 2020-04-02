<?php

return [
    //Главная страница
	'' => [
		'controllers' => 'index',
		'action' => 'index',
	],
    'index' => [
        'controllers' => 'index',
        'action' => 'index',
    ],

	//Регистрация\авторизация
	'account/register' => [
		'controllers' => 'account',
		'action' => 'register',
	],
    'account/auth' => [
        'controllers' => 'account',
        'action' => 'auth',
    ],
    'account/profile' => [
        'controllers' => 'account',
        'action' => 'profile',
    ],
    'account/profiles' => [
        'controllers' => 'account',
        'action' => 'profiles',
    ],
    'account/confirm/{token:\w+}' => [
        'controllers' => 'account',
        'action' => 'confirm',
    ],
    'account/logout' => [
        'controllers' => 'account',
        'action' => 'logout',
    ],
    'account/reset' => [
        'controllers' => 'account',
        'action' => 'reset',
    ],
    'account/resetPwd/{token:\w+}' => [
        'controllers' => 'account',
        'action' => 'resetPwd',
    ],
    'register' => [
        'controllers' => 'account',
        'action' => 'register',
    ],
    'auth' => [
        'controllers' => 'account',
        'action' => 'auth',
    ],
    'account/test' => [
        'controllers' => 'account',
        'action' => 'test',
    ],

    //Что-то новое.

    //тест
    'test/home' => [
        'controllers' => 'test',
        'action' => 'home',
    ],
    'test/vk' => [
        'controllers' => 'test',
        'action' => 'vk',
    ],
    //Админ-панель
    'admin' => [
        'controllers' => 'admin',
        'action' => 'index',
    ],
    'admin/online' => [
        'controllers' => 'admin',
        'action' => 'online',
    ],
    'admin/ban' => [
        'controllers' => 'admin',
        'action' => 'ban',
    ],
    'admin/ban/{id:\d+}' => [
        'controllers' => 'admin',
        'action' => 'ban',
    ],
    'admin/users' => [
        'controllers' => 'admin',
        'action' => 'users',
    ],
    'admin/deleteBan/{id:\d+}' => [
        'controllers' => 'admin',
        'action' => 'deleteBan',
    ],
    'admin/banUsers/{id:\d+}/type/{type:\d+}' => [
        'controllers' => 'admin',
        'action' => 'banUsers',
    ],
    'admin/deleteComment/{id:\d+}' => [
        'controllers' => 'admin',
        'action' => 'deleteComment',
    ],
    'admin/allowComments/{value:\d+}/id/{id:\d+}' => [
        'controllers' => 'admin',
        'action' => 'allowComments',
    ],
    // Логика
    'main/delete/{id:\d+}' => [
        'controllers' => 'main',
        'action' => 'delete',
    ],
];
