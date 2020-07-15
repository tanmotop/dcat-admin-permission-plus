Dcat-admin permission-plus
======


#### 安装
```php
composer require tanmo/permission-plus
```
#### 导入插件
```php
php artisan admin:import Tanmo\Dcat\Permission\Permission
```

#### 使用

一、内置了两种注解 `@Module` 和 `@Permission`

`@Module` 用于注解Controller，如：`@Module(name="文章管理", slug="posts")` ，每个Controller只能有一个 `@Module` 注解，必填

`@Permission` 用于注解Action，如：`@Permission(name="文章列表", slug="posts-list", action="index")` ，每个Controller可以有多个 `@Permission` 注解

二、完整例子：
```php
/**
 * @Module(name="文章管理", slug="posts")
 * @Permission(name="文章列表", slug="posts-list", action="index")
 * @Permission(name="新建文章", slug="posts-create", action="create")
 * @Permission(name="保存文章", slug="posts-store", action="store")
 * @Permission(name="编辑文章", slug="posts-edit", action="edit")
 * @Permission(name="保存编辑", slug="posts-update", action="update")
 * @Permission(name="删除文章", slug="posts-destroy", action="destroy")
 */
```
三、添加路由

```php
$router->resource('posts', 'PostController'); // 没有添加路由无法被扫描出来
```

四、导入权限

登录后台->权限导入->点击"导入权限"按钮
