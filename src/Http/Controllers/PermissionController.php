<?php

namespace Tanmo\Dcat\Permission\Http\Controllers;

use App\Admin\Controllers\HomeController;
use Dcat\Admin\Admin;
use Dcat\Admin\Layout\Content;
use Doctrine\Common\Annotations\AnnotationReader;
use Illuminate\Routing\Controller;
use Illuminate\Routing\Route;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use ReflectionClass;
use Tanmo\Dcat\Permission\Annotations\Module;
use Tanmo\Dcat\Permission\Annotations\Permission;
use Tanmo\Dcat\Permission\Support\Output;

class PermissionController extends Controller
{
    /**
     * @var Output
     */
    protected $output;

    /**
     * PermissionController constructor.
     * @param Output $output
     */
    public function __construct(Output $output)
    {
        $this->output = $output;
    }

    /**
     * @param Content $content
     * @return Content
     */
    public function index(Content $content)
    {
        return $content
            ->title('权限管理')
            ->description('增强版')
            ->body(view('permission-plus::index'));
    }

    public function import()
    {
        $this->output->header();
        $this->output->output("开始导入权限......");
        $this->output->output("--------------------------------------------------------------------------------");

        ///
        $prefix = config('admin.route.prefix');
        $namespace = config('admin.route.namespace');

        ///
        collect(app('router')->getRoutes())->filter(function (Route $route) use ($namespace, $prefix) {
            return Str::startsWith($route->getActionName(), $namespace) &&
                Str::startsWith($route->uri(), $prefix) &&
                Str::replaceFirst($prefix, '', $route->uri().'*') !== '*';
        })->mapToGroups(function (Route $route) use ($prefix) {
            [$controller, $action] = explode('@', $route->getActionName());

            ///
            $uri = $route->uri();
            if (! Str::contains($uri, '{')) {
                $httpPath = Str::replaceFirst($prefix, '', $uri.'*');
            } else {
                $httpPath = Str::replaceFirst($prefix, '', preg_replace('/{.*}+/', '*', $uri));
            }

            ///
            return [$controller => [
                $action => [
                    'http_method' => $route->methods(),
                    'http_path' => $httpPath
                ],
            ]];
        })->map(function (Collection $item) {
            return $item->collapse();
        })->each(function (Collection $actions, $controller) {
            $reader = new AnnotationReader();
            $refClass = new ReflectionClass($controller);
            $classAnnotations = $reader->getClassAnnotations($refClass);
            $module = $reader->getClassAnnotation($refClass, Module::class);

            if (empty($module)) return;

            ///
            $annotations = collect($classAnnotations)->filter(function ($item) {
                return $item instanceof Permission;
            })->mapWithKeys(function ($item) {
                return [$item->action => $item];
            });

            ///
            $parent = \Dcat\Admin\Models\Permission::firstOrCreate(['slug' => $module->slug], ['name' => $module->name]);
            $this->output->output("[{$parent->name}]");

            ///
            foreach ($actions as $key => $action) {
                $annotation = $annotations->get($key);
                if (!empty($annotation)) {
                    $permission = \Dcat\Admin\Models\Permission::firstOrCreate(['slug' => $annotation->slug], [
                        'name' => $annotation->name,
                        'http_method' => $action['http_method'],
                        'http_path' => $action['http_path']
                        ]);
                    $permission->parent_id = $parent->id;
                    $permission->save();
                    $this->output->output("       |- [{$permission->name}]");
                }
            }
        });

        ///
        $this->output->output("--------------------------------------------------------------------------------");
        $this->output->output("导入完成!");
        $this->output->end();
    }
}
