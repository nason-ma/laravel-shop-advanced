<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Laravel-admin name
    |--------------------------------------------------------------------------
    |
    | This value is the name of laravel-admin, This setting is displayed on the
    | login page.
    | 站点标题
    */
    'name' => 'Laravel Shop',

    /*
    |--------------------------------------------------------------------------
    | Laravel-admin logo
    |--------------------------------------------------------------------------
    |
    | The logo of all admin pages. You can also set it as an image by using a
    | `img` tag, eg '<img src="http://logo-url" alt="Admin logo">'.
    | 页面顶部 Logo
    */
    'logo' => '<b>Laravel</b> Shop',

    /*
    |--------------------------------------------------------------------------
    | Laravel-admin mini logo
    |--------------------------------------------------------------------------
    |
    | The logo of all admin pages when the sidebar menu is collapsed. You can
    | also set it as an image by using a `img` tag, eg
    | '<img src="http://logo-url" alt="Admin logo">'.
    | 页面顶部小 Logo
    */
    'logo-mini' => '<b>LS</b>',

    /*
    |--------------------------------------------------------------------------
    | Laravel-admin bootstrap setting
    |--------------------------------------------------------------------------
    |
    | This value is the path of laravel-admin bootstrap file.
    |
    */
    'bootstrap' => app_path('Admin/bootstrap.php'),

    /*
    |--------------------------------------------------------------------------
    | Laravel-admin route settings
    |--------------------------------------------------------------------------
    |
    | The routing configuration of the admin page, including the path prefix,
    | the controller namespace, and the default middleware. If you want to
    | access through the root path, just set the prefix to empty string.
    | 路由配置
    */
    'route' => [
        // 路由前缀
        'prefix' => env('ADMIN_ROUTE_PREFIX', 'admin'),
        // 控制器命名空间前缀
        'namespace' => 'App\\Admin\\Controllers',
        // 默认中间件列表
        'middleware' => ['web', 'admin'],
    ],

    /*
    |--------------------------------------------------------------------------
    | Laravel-admin install directory
    |--------------------------------------------------------------------------
    |
    | The installation directory of the controller and routing configuration
    | files of the administration page. The default is `app/Admin`, which must
    | be set before running `artisan admin::install` to take effect.
    | Laravel-Admin 的安装目录
    */
    'directory' => app_path('Admin'),

    /*
    |--------------------------------------------------------------------------
    | Laravel-admin html title
    |--------------------------------------------------------------------------
    |
    | Html title for all pages.
    | Laravel-Admin 页面标题
    */
    'title' => 'Laravel Shop 管理后台',

    /*
    |--------------------------------------------------------------------------
    | Access via `https`
    |--------------------------------------------------------------------------
    |
    | If your page is going to be accessed via https, set it to `true`.
    | 是否使用 https
    */
    'https' => env('ADMIN_HTTPS', false),

    /*
    |--------------------------------------------------------------------------
    | Laravel-admin auth setting
    |--------------------------------------------------------------------------
    |
    | Authentication settings for all admin pages. Include an authentication
    | guard and a user provider setting of authentication driver.
    |
    | You can specify a controller for `login` `logout` and other auth routes.
    | Laravel-Admin 用户认证设置
    */
    'auth' => [

        'controller' => App\Admin\Controllers\AuthController::class,

        'guard' => 'admin',

        'guards' => [
            'admin' => [
                'driver'   => 'session',
                'provider' => 'admin',
            ],
        ],

        'providers' => [
            'admin' => [
                'driver' => 'eloquent',
                'model'  => Encore\Admin\Auth\Database\Administrator::class,
            ],
        ],

        // Add "remember me" to login form
        'remember' => true,

        // Redirect to the specified URI when user is not authorized.
        'redirect_to' => 'auth/login',

        // The URIs that should be excluded from authorization.
        'excepts' => [
            'auth/login',
            'auth/logout',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Laravel-admin upload setting
    |--------------------------------------------------------------------------
    |
    | File system configuration for form upload files and images, including
    | disk and upload path.
    | Laravel-Admin 文件上传设置
    */
    'upload' => [
        // 对应 filesystem.php 中的 disks
        // Disk in `config/filesystem.php`.
        'disk' => 'public',

        // Image and file upload path under the disk above.
        'directory' => [
            'image' => 'images',
            'file'  => 'files',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Laravel-admin database settings
    |--------------------------------------------------------------------------
    |
    | Here are database settings for laravel-admin builtin model & tables.
    | Laravel-Admin 数据库设置
    */
    'database' => [
        // 数据库连接名称，留空即可
        // Database connection for following tables.
        'connection' => '',

        // 管理员用户表及模型
        // User tables and model.
        'users_table' => 'admin_users',
        'users_model' => Encore\Admin\Auth\Database\Administrator::class,

        // 角色表及模型
        // Role table and model.
        'roles_table' => 'admin_roles',
        'roles_model' => Encore\Admin\Auth\Database\Role::class,

        // 权限表及模型
        // Permission table and model.
        'permissions_table' => 'admin_permissions',
        'permissions_model' => Encore\Admin\Auth\Database\Permission::class,

        // 菜单表及模型
        // Menu table and model.
        'menu_table' => 'admin_menu',
        'menu_model' => Encore\Admin\Auth\Database\Menu::class,

        // 多对多关联中间表
        // Pivot table for table above.
        'operation_log_table'    => 'admin_operation_log',
        'user_permissions_table' => 'admin_user_permissions',
        'role_users_table'       => 'admin_role_users',
        'role_permissions_table' => 'admin_role_permissions',
        'role_menu_table'        => 'admin_role_menu',
    ],

    /*
    |--------------------------------------------------------------------------
    | User operation log setting
    |--------------------------------------------------------------------------
    |
    | By setting this option to open or close operation log in laravel-admin.
    | Laravel-Admin 操作日志设置
    */
    'operation_log' => [

        'enable' => true,

        /*
         * Only logging allowed methods in the list
         */
        'allowed_methods' => ['GET', 'HEAD', 'POST', 'PUT', 'DELETE', 'CONNECT', 'OPTIONS', 'TRACE', 'PATCH'],

        /*
         * Routes that will not log to database.
         *
         * All method to path like: admin/auth/logs
         * or specific method to path like: get:admin/auth/logs.
         * 不记录操作日志的路由
         */
        'except' => [
            'admin/auth/logs*',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Indicates whether to check route permission.
    |--------------------------------------------------------------------------
    */
    'check_route_permission' => true,

    /*
    |--------------------------------------------------------------------------
    | Indicates whether to check menu roles.
    |--------------------------------------------------------------------------
    */
    'check_menu_roles'       => true,

    /*
    |--------------------------------------------------------------------------
    | User default avatar
    |--------------------------------------------------------------------------
    |
    | Set a default avatar for newly created users.
    |
    */
    'default_avatar' => '/vendor/laravel-admin/AdminLTE/dist/img/user2-160x160.jpg',

    /*
    |--------------------------------------------------------------------------
    | Admin map field provider
    |--------------------------------------------------------------------------
    |
    | Supported: "tencent", "google", "yandex".
    |
    */
    'map_provider' => 'google',

    /*
    |--------------------------------------------------------------------------
    | Application Skin
    |--------------------------------------------------------------------------
    |
    | This value is the skin of admin pages.
    | @see https://adminlte.io/docs/2.4/layout
    |
    | Supported:
    |    "skin-blue", "skin-blue-light", "skin-yellow", "skin-yellow-light",
    |    "skin-green", "skin-green-light", "skin-purple", "skin-purple-light",
    |    "skin-red", "skin-red-light", "skin-black", "skin-black-light".
    |   页面风格
    */
    'skin' => 'skin-blue-light',

    /*
    |--------------------------------------------------------------------------
    | Application layout
    |--------------------------------------------------------------------------
    |
    | This value is the layout of admin pages.
    | @see https://adminlte.io/docs/2.4/layout
    |
    | Supported: "fixed", "layout-boxed", "layout-top-nav", "sidebar-collapse",
    | "sidebar-mini".
    |
    */
    'layout' => ['sidebar-mini', 'sidebar-collapse'],

    /*
    |--------------------------------------------------------------------------
    | Login page background image
    |--------------------------------------------------------------------------
    |
    | This value is used to set the background image of login page.
    |
    */
    'login_background_image' => '',

    /*
    |--------------------------------------------------------------------------
    | Show version at footer
    |--------------------------------------------------------------------------
    |
    | Whether to display the version number of laravel-admin at the footer of
    | each page
    |
    */
    'show_version' => true,

    /*
    |--------------------------------------------------------------------------
    | Show environment at footer
    |--------------------------------------------------------------------------
    |
    | Whether to display the environment at the footer of each page
    |
    */
    'show_environment' => true,

    /*
    |--------------------------------------------------------------------------
    | Menu bind to permission
    |--------------------------------------------------------------------------
    |
    | whether enable menu bind to a permission
    */
    'menu_bind_permission' => true,

    /*
    |--------------------------------------------------------------------------
    | Enable default breadcrumb
    |--------------------------------------------------------------------------
    |
    | Whether enable default breadcrumb for every page content.
    */
    'enable_default_breadcrumb' => true,

    /*
    |--------------------------------------------------------------------------
    | Enable/Disable assets minify
    |--------------------------------------------------------------------------
    */
    'minify_assets' => [

        // Assets will not be minified.
        'excepts' => [

        ],

    ],

    /*
    |--------------------------------------------------------------------------
    | Enable/Disable sidebar menu search
    |--------------------------------------------------------------------------
    */
    'enable_menu_search' => true,

    /*
    |--------------------------------------------------------------------------
    | Alert message that will displayed on top of the page.
    |--------------------------------------------------------------------------
    */
    'top_alert' => '',

    /*
    |--------------------------------------------------------------------------
    | The global Grid action display class.
    |--------------------------------------------------------------------------
    */
    'grid_action_class' => \Encore\Admin\Grid\Displayers\DropdownActions::class,

    /*
    |--------------------------------------------------------------------------
    | Extension Directory
    |--------------------------------------------------------------------------
    |
    | When you use command `php artisan admin:extend` to generate extensions,
    | the extension files will be generated in this directory.
    */
    'extension_dir' => app_path('Admin/Extensions'),

    /*
    |--------------------------------------------------------------------------
    | Settings for extensions.
    |--------------------------------------------------------------------------
    |
    | You can find all available extensions here
    | https://github.com/laravel-admin-extensions.
    | 扩展设置.
    */
    'extensions' => [
        'ueditor' => [

            // 如果要关掉这个扩展，设置为false
            'enable' => true,

            // 编辑器的前端配置 参考：http://fex.baidu.com/ueditor/#start-config
            'config' => [
                'initialFrameHeight' => 400, // 例如初始化高度
            ],
            'field_type' => 'ueditor'
        ],

        'grid-lightbox' => [

            // Set to `false` if you want to disable this extension
            'enable' => true,
        ]
    ],
];
