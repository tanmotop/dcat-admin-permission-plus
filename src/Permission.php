<?php

namespace Tanmo\Dcat\Permission;

use Dcat\Admin\Extension;

class Permission extends Extension
{
    const NAME = 'permission-plus';

    protected $serviceProvider = PermissionServiceProvider::class;

    protected $composer = __DIR__.'/../composer.json';

//    protected $assets = __DIR__.'/../resources/assets';

    protected $views = __DIR__.'/../resources/views';

//    protected $lang = __DIR__.'/../resources/lang';

    protected $menu = [
        'title' => '权限导入',
        'path'  => 'permission-plus',
        'icon'  => 'feather icon-lock',
    ];
}
