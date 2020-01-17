<?php
use Illuminate\Support\Facades\Route;
    Route::post('login',[
        'uses'=>'Auth\AccessController@login',
        'as'=>'auth.login',
        'module'=>NULL,
        'component'=>NULL
    ]);
    Route::post('/rescue',[
        'uses'=>'Auth\AccessController@sendRecoveryMail',
        'as'=>'auth.recovery',
        'module'=>NULL,
        'component'=>NULL
    ]);

      //Authenticated Auth Routes
    Route::group(['middleware'=> ['role.auth']], function () {
        Route::post('logout',[
            'uses'=>'Auth\AccessController@logout',
            'as'=>'auth.logout',
            'module'=>NULL,
            'component'=>NULL
        ]);
        Route::get('/refresh', [
            'uses'=>'Auth\AccessController@refresh',
            'as'=>'auth.refresh',
            'module'=>NULL,
            'component'=>NULL
        ]);

        Route::get('roles/{role}/components/hierarchy',[
            'uses'=>'Auth\PermissionController@showHierarchyByRole',
            'as'=>'role.components.hierarchy.view',
            'module'=>'users-mgt',
            'component'=>'role-modules'
        ]);
        Route::get('components/hierarchy',[
            'uses'=>'Auth\PermissionController@showHierarchy',
            'as'=>'components.hierarchy.view',
            'module'=>'users-mgt',
            'component'=>'components'
        ]);
        Route::get('roles/{role}/components',[
            'uses'=>'Auth\PermissionController@showByRole',
            'as'=>'role.components.view',
            'module'=>'users-mgt',
            'component'=>'role-modules'
        ]);

        //Authorization routes
        Route::put('roles/{role}/updatemodules',[
            'uses'=>'Auth\AuthorizationController@attachModulesToRole',
            'as'=>'role.module.create-update',
            'module'=>'users-mgt',
            'component'=>'role-modules'
        ]);
        Route::put('roles/{role}/detachmodules',[
            'uses'=>'Auth\AuthorizationController@detachModulesFromRole',
             'as'=>'role.modules.delete',
             'module'=>'users-mgt',
             'component'=>'role-modules'
        ]);

        Route::put('roles/{role}/detachmodules/cascade',[
            'uses'=>'Auth\AuthorizationController@detachModulesFromRoleCascade',
            'as'=>'role.modules.cascade.delete',
            'module'=>'users-mgt',
            'component'=>'role-modules'
        ]);

         //Authorization routes
         Route::put('roles/{role}/updatecomponents',[
             'uses'=>'Auth\AuthorizationController@attachComponentsToRole',
             'as'=>'role.components.create-update',
             'module'=>'users-mgt',
             'component'=>'role-components'
         ]);
         Route::put('roles/{role}/detachcomponents',[
             'uses'=>'Auth\AuthorizationController@detachComponentsFromRole',
             'as'=>'role.components.delete',
             'module'=>'users-mgt',
             'component'=>'role-components'
         ]);

         Route::put('roles/{role}/detachcomponents/cascade',[
             'uses'=>'Auth\AuthorizationController@detachComponentsFromRoleCascade',
             'as'=>'role.components.cascade.delete',
             'module'=>'users-mgt',
             'component'=>'role-components'
         ]);

        Route::apiResource('roles','Auth\RoleController',[
            //'only'=>['index','show','store','update','delete'],
            'module'=>'users-mgt',
            'component'=>'roles'
        ]);

        Route::apiResource('modules','Auth\ModuleController',[
            //'only'=>['index','show','update','delete'],
            'module'=>'users-mgt',
            'component'=>'modules'
        ]);

        Route::apiResource('components','Auth\ComponentController',[
            //'only'=>['index','show','update','delete'],
            'module'=>'users-mgt',
            'component'=>'components'
        ]);

        Route::get('modules/{module}/components',[
            'uses'=>'Auth\ComponentController@showByModule',
            'as'=>'module.components.view',
            'module'=>'users-mgt',
            'component'=>'components'
        ]);

        //Logged In User Routes
        Route::group(['prefix' => 'profile'], function () {
            Route::get('components/hierarchy',[
                'uses'=>'Profile\ProfileController@showPermissionHierarchy',
                'as'=>'profile.components.hierarchy.view',
                'module'=>NULL,
                'component'=>NULL
            ]);
            Route::get('components',[
                'uses'=>'Profile\ProfileController@showPermissions',
                'as'=>'profile.components.view',
                'module'=>NULL,
                'component'=>NULL
            ]);
            Route::get('components/paginated',[
                'uses'=>'Profile\ProfileController@showPermissionsPaginated',
                'as'=>'profile.components.paginated.view',
                'module'=>NULL,
                'component'=>NULL
            ]);
            Route::match(['PUT', 'PATCH'],'update',[
                'uses'=>'Profile\ProfileController@update',
                'as'=>'profile.update',
                'module'=>NULL,
                'component'=>NULL
            ]);
            Route::apiResource('remarks','Profile\UserRemarkController',[
                //'only'=>['index','show','store','update'],
                'module'=>'users-mgt',
                'component'=>'user-remarks'
            ]);
        });

         //Registrations Routes
       Route::apiResource('profiles', 'Profile\UserRegisterationController',[
            //'only'=>['index','show','store','update'],
            'module'=>'users-mgt',
            'component'=>'user-registry'
        ]);


        //User By Id
        Route::group(['prefix' => 'profiles'], function () {
            Route::get('{profile}/profiledocuments',[
                'uses'=>'Profile\ProfileDocumentController@showByProfile',
                'as'=>'profiles.documents.view',
                'module'=>'users-mgt',
                'component'=>'user-registry'
            ]);
            Route::get('{profile}/profilenextofkins',[
                'uses'=>'Profile\ProfileNextOfKinController@showByProfile',
                'as'=>'profiles.nextofkin.view',
                'module'=>'users-mgt',
                'component'=>'user-registry'
            ]);
            //Authorization routes
            Route::put('{profile}/updatemodules',[
                'uses'=>'Auth\AuthorizationController@attachModulesToUser',
                'as'=>'profiles.modules.create-update',
                'module'=>'users-mgt',
                'component'=>'user-modules'
            ]);
            Route::put('{profile}/detachmodules',[
                'uses'=>'Auth\AuthorizationController@detachModulesFromUser',
                'as'=>'profiles.modules.delete',
                'module'=>'users-mgt',
                'component'=>'user-modules'
            ]);

            Route::put('{profile}/updatecomponents',[
                'uses'=>'Auth\AuthorizationController@attachComponentsToUser',
                'as'=>'profiles.components.create-update',
                'module'=>'users-mgt',
                'component'=>'user-components'
            ]);

            Route::put('{profile}/detachcomponents',[
                'uses'=>'Auth\AuthorizationController@detachComponentsFromUser',
                'as'=>'profiles.components.delete',
                'module'=>'users-mgt',
                'component'=>'user-components'
            ]);

            //User Permissions
            Route::get('{profile}/components',[
                'uses'=>'Auth\PermissionController@showPermissions',
                'as'=>'profiles.components.view',
                'module'=>'users-mgt',
                'component'=>'user-components'
            ]);
            Route::get('{profile}/components/hierarchy',[
                'uses'=>'Auth\PermissionController@showPermissionHierarchy',
                'as'=>'profiles.components.hierarchy.view',
                'module'=>'users-mgt',
                'component'=>'user-components'
            ]);
            Route::get('{profile}/permissions/paginated',[
                'uses'=>'Auth\PermissionController@showPermissionsPaginated',
                'as'=>'profiles.components.paginated.view',
                'module'=>'users-mgt',
                'component'=>'user-components'
            ]);

        });
        Route::apiResource('profilenextofkins','Profile\ProfileNextOfKinController',[
            //'only'=>['index','show','store','update'],
            'module'=>'users-mgt',
            'component'=>'user-registry'
            ]);
        Route::apiResource('profiledocuments','Profile\ProfileDocumentController',[
              //'only'=>['index','show','store','update'],
              'module'=>'users-mgt',
              'component'=>'user-registry'
            ]);
    });