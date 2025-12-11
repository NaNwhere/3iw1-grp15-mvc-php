<?php

return [
    // Routes publiques
    '/' => 'MainController@home',
    '/login' => 'SecurityController@login',
    '/logout' => 'SecurityController@logout',
    '/register' => 'SecurityController@register',
    '/verify' => 'SecurityController@verify',
    '/forgot-password' => 'SecurityController@forgotPassword',
    '/reset-password' => 'SecurityController@resetPassword',

    // Profil
    '/profile' => 'ProfileController@index',
    '/profile/update' => 'ProfileController@update',
    '/profile/delete' => 'ProfileController@delete',

    // Routes Admin
    '/admin' => 'Admin\DashboardController@index',

    // Users CRUD
    '/admin/users' => 'Admin\UserController@index',
    '/admin/users/create' => 'Admin\UserController@create',
    '/admin/users/store' => 'Admin\UserController@store',
    '/admin/users/edit/{id}' => 'Admin\UserController@edit',
    '/admin/users/update/{id}' => 'Admin\UserController@update',
    '/admin/users/delete/{id}' => 'Admin\UserController@delete',
    '/admin/users/verify/{id}' => 'Admin\UserController@verify',
    '/admin/users/send-reset/{id}' => 'Admin\UserController@sendResetLink',

    // Pages CRUD
    '/admin/pages' => 'Admin\PageController@index',
    '/admin/pages/create' => 'Admin\PageController@create',
    '/admin/pages/store' => 'Admin\PageController@store',
    '/admin/pages/edit/{id}' => 'Admin\PageController@edit',
    '/admin/pages/update/{id}' => 'Admin\PageController@update',
    '/admin/pages/delete/{id}' => 'Admin\PageController@delete',

    // Route dynamique pour les pages
    '/pages/{slug}' => 'MainController@page',
];
