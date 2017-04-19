<?php

namespace App\Annotations;

/**
 * @Annotation
 */
class ToolsAnnotation {

    /**
     * @var string
     */
    public $description;

    /**
     * @var string
     */
    public $name;

    /**
     * Do we serve this method to the API or not.
     * If method is not served, then it is used for processing on submit
     *
     * @var boolean
     */
    public $serve;
}