<?php


namespace Tanmo\Dcat\Permission\Annotations;

use Doctrine\Common\Annotations\Annotation\Required;

/**
 * @Annotation
 * Class Module
 * @package Tanmo\Dcat\Permission\Annotations
 */
final class Module
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
}
