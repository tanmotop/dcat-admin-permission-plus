<?php


namespace Tanmo\Dcat\Permission\Annotations;


use Doctrine\Common\Annotations\Annotation\Required;

/**
 * @Annotation
 * Class Permission
 * @package Tanmo\Dcat\Permission\Annotations
 */
final class Permission
{
    /**
     * @var string
     * @Required()
     */
    public $name;

    /**
     * @var string
     * @Required()
     */
    public $slug;

    /**
     * @var string
     * @Required()
     */
    public $action;
}
