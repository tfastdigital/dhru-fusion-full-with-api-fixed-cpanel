<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

/**
 * Abstract Mustache Template class.
 *
 * @abstract
 */
abstract class Mustache_Template
{
    /**
     * @var Mustache_Engine
     */
    protected $mustache = NULL;
    /**
     * @var bool
     */
    protected $strictCallables = false;
    public function __construct(Mustache_Engine $mustache)
    {
        $this->mustache = $mustache;
    }
    public function __invoke($context = [])
    {
        return $this->render($context);
    }
    public function render($context = [])
    {
        return $this->renderInternal($this->prepareContextStack($context));
    }
    public abstract function renderInternal(Mustache_Context $context, $indent);
    protected function isIterable($value)
    {
        gettype($value);
        switch (gettype($value)) {
            case "object":
                return $value instanceof Traversable;
                break;
            case "array":
                $i = 0;
                foreach ($value as $k => $v) {
                    if ($k !== $i++) {
                        return false;
                    }
                }
                return true;
                break;
            default:
                return false;
        }
    }
    protected function prepareContextStack($context = NULL)
    {
        $stack = new Mustache_Context();
        $helpers = $this->mustache->getHelpers();
        if (!$helpers->isEmpty()) {
            $stack->push($helpers);
        }
        if (!empty($context)) {
            $stack->push($context);
        }
        return $stack;
    }
    protected function resolveValue($value, Mustache_Context $context)
    {
        if (($this->strictCallables ? is_object($value) : !is_string($value)) && is_callable($value)) {
            return $this->mustache->loadLambda((string) call_user_func($value))->renderInternal($context);
        }
        return $value;
    }
}

?>