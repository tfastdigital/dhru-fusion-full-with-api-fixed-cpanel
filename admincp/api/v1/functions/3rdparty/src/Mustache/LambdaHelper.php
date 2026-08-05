<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

/**
 * Mustache Lambda Helper.
 *
 * Passed as the second argument to section lambdas (higher order sections),
 * giving them access to a `render` method for rendering a string with the
 * current context.
 */
class Mustache_LambdaHelper
{
    private $mustache = NULL;
    private $context = NULL;
    private $delims = NULL;
    public function __construct(Mustache_Engine $mustache, Mustache_Context $context, $delims = NULL)
    {
        $this->mustache = $mustache;
        $this->context = $context;
        $this->delims = $delims;
    }
    public function render($string)
    {
        return $this->mustache->loadLambda((string) $string, $this->delims)->renderInternal($this->context);
    }
    public function __invoke($string)
    {
        return $this->render($string);
    }
    public function withDelimiters($delims)
    {
        return new self($this->mustache, $this->context, $delims);
    }
}

?>