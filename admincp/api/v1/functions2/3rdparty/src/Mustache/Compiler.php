<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

/**
 * Mustache Compiler class.
 *
 * This class is responsible for turning a Mustache token parse tree into normal PHP source code.
 */
class Mustache_Compiler
{
    private $pragmas = NULL;
    private $defaultPragmas = [];
    private $sections = NULL;
    private $blocks = NULL;
    private $source = NULL;
    private $indentNextLine = NULL;
    private $customEscape = NULL;
    private $entityFlags = NULL;
    private $charset = NULL;
    private $strictCallables = NULL;
    const KLASS = "<?php\n\n        class %s extends Mustache_Template\n        {\n            private \$lambdaHelper;%s\n\n            public function renderInternal(Mustache_Context \$context, \$indent = '')\n            {\n                \$this->lambdaHelper = new Mustache_LambdaHelper(\$this->mustache, \$context);\n                \$buffer = '';\n        %s\n\n                return \$buffer;\n            }\n        %s\n        %s\n        }";
    const KLASS_NO_LAMBDAS = "<?php\n\n        class %s extends Mustache_Template\n        {%s\n            public function renderInternal(Mustache_Context \$context, \$indent = '')\n            {\n                \$buffer = '';\n        %s\n\n                return \$buffer;\n            }\n        }";
    const STRICT_CALLABLE = "protected \$strictCallables = true;";
    const BLOCK_VAR = "\n        \$blockFunction = \$context->findInBlock(%s);\n        if (is_callable(\$blockFunction)) {\n            \$buffer .= call_user_func(\$blockFunction, \$context);\n        %s}\n    ";
    const BLOCK_VAR_ELSE = "} else {%s";
    const BLOCK_ARG = "%s => array(\$this, 'block%s'),";
    const BLOCK_FUNCTION = "\n        public function block%s(\$context)\n        {\n            \$indent = \$buffer = '';%s\n\n            return \$buffer;\n        }\n    ";
    const SECTION_CALL = "\n        // %s section\n        \$value = \$context->%s(%s);%s\n        \$buffer .= \$this->section%s(\$context, \$indent, \$value);\n    ";
    const SECTION = "\n        private function section%s(Mustache_Context \$context, \$indent, \$value)\n        {\n            \$buffer = '';\n\n            if (%s) {\n                \$source = %s;\n                \$result = call_user_func(\$value, \$source, %s);\n                if (strpos(\$result, '{{') === false) {\n                    \$buffer .= \$result;\n                } else {\n                    \$buffer .= \$this->mustache\n                        {$this->loadLambda}((string) \$result%s)\n                        {$this->renderInternal}(\$context);\n                }\n            } elseif (!empty(\$value)) {\n                \$values = \$this->isIterable(\$value) ? \$value : array(\$value);\n                foreach (\$values as \$value) {\n                    \$context->push(\$value);\n                    %s\n                    \$context->pop();\n                }\n            }\n\n            return \$buffer;\n        }\n    ";
    const INVERTED_SECTION = "\n        // %s inverted section\n        \$value = \$context->%s(%s);%s\n        if (empty(\$value)) {\n            %s\n        }\n    ";
    const PARTIAL_INDENT = ", \$indent . %s";
    const PARTIAL = "\n        if (\$partial = \$this->mustache->loadPartial(%s)) {\n            \$buffer .= \$partial->renderInternal(\$context%s);\n        }\n    ";
    const PARENT = "\n        if (\$parent = \$this->mustache->loadPartial(%s)) {\n            \$context->pushBlockContext(array(%s\n            ));\n            \$buffer .= \$parent->renderInternal(\$context, \$indent);\n            \$context->popBlockContext();\n        }\n    ";
    const PARENT_NO_CONTEXT = "\n        if (\$parent = \$this->mustache->loadPartial(%s)) {\n            \$buffer .= \$parent->renderInternal(\$context, \$indent);\n        }\n    ";
    const VARIABLE = "\n        \$value = \$this->resolveValue(\$context->%s(%s), \$context);%s\n        \$buffer .= %s%s;\n    ";
    const FILTER = "\n        \$filter = \$context->%s(%s);\n        if (!(%s)) {\n            throw new Mustache_Exception_UnknownFilterException(%s);\n        }\n        \$value = call_user_func(\$filter, \$value);%s\n    ";
    const LINE = "\$buffer .= \"\\n\";";
    const TEXT = "\$buffer .= %s%s;";
    const DEFAULT_ESCAPE = "htmlspecialchars(%s, %s, %s)";
    const CUSTOM_ESCAPE = "call_user_func(\$this->mustache->getEscape(), %s)";
    const IS_CALLABLE = "!is_string(%s) && is_callable(%s)";
    const STRICT_IS_CALLABLE = "is_object(%s) && is_callable(%s)";
    const LINE_INDENT = "\$indent . ";
    public function compile($source, $tree, $name, $customEscape = false, $charset = "UTF-8", $strictCallables = false, $entityFlags = ENT_COMPAT)
    {
        $this->pragmas = $this->defaultPragmas;
        $this->sections = [];
        $this->blocks = [];
        $this->source = $source;
        $this->indentNextLine = true;
        $this->customEscape = $customEscape;
        $this->entityFlags = $entityFlags;
        $this->charset = $charset;
        $this->strictCallables = $strictCallables;
        return $this->writeCode($tree, $name);
    }
    public function setPragmas($pragmas)
    {
        $this->pragmas = [];
        foreach ($pragmas as $pragma) {
            $this->pragmas[$pragma] = true;
        }
        $this->defaultPragmas = $this->pragmas;
    }
    private function walk($tree, $level = 0)
    {
        $code = "";
        $level++;
        foreach ($tree as $node) {
            switch ($node[Mustache_Tokenizer::TYPE]) {
                case Mustache_Tokenizer::T_PRAGMA:
                    $this->pragmas[$node[Mustache_Tokenizer::NAME]] = true;
                    break;
                case Mustache_Tokenizer::T_SECTION:
                    $code .= $this->section($node[Mustache_Tokenizer::NODES], $node[Mustache_Tokenizer::NAME], isset($node[Mustache_Tokenizer::FILTERS]) ? $node[Mustache_Tokenizer::FILTERS] : [], $node[Mustache_Tokenizer::INDEX], $node[Mustache_Tokenizer::END], $node[Mustache_Tokenizer::OTAG], $node[Mustache_Tokenizer::CTAG], $level);
                    break;
                case Mustache_Tokenizer::T_INVERTED:
                    $code .= $this->invertedSection($node[Mustache_Tokenizer::NODES], $node[Mustache_Tokenizer::NAME], isset($node[Mustache_Tokenizer::FILTERS]) ? $node[Mustache_Tokenizer::FILTERS] : [], $level);
                    break;
                case Mustache_Tokenizer::T_PARTIAL:
                    $code .= $this->partial($node[Mustache_Tokenizer::NAME], isset($node[Mustache_Tokenizer::INDENT]) ? $node[Mustache_Tokenizer::INDENT] : "", $level);
                    break;
                case Mustache_Tokenizer::T_PARENT:
                    $code .= $this->parent($node[Mustache_Tokenizer::NAME], isset($node[Mustache_Tokenizer::INDENT]) ? $node[Mustache_Tokenizer::INDENT] : "", $node[Mustache_Tokenizer::NODES], $level);
                    break;
                case Mustache_Tokenizer::T_BLOCK_ARG:
                    $code .= $this->blockArg($node[Mustache_Tokenizer::NODES], $node[Mustache_Tokenizer::NAME], $node[Mustache_Tokenizer::INDEX], $node[Mustache_Tokenizer::END], $node[Mustache_Tokenizer::OTAG], $node[Mustache_Tokenizer::CTAG], $level);
                    break;
                case Mustache_Tokenizer::T_BLOCK_VAR:
                    $code .= $this->blockVar($node[Mustache_Tokenizer::NODES], $node[Mustache_Tokenizer::NAME], $node[Mustache_Tokenizer::INDEX], $node[Mustache_Tokenizer::END], $node[Mustache_Tokenizer::OTAG], $node[Mustache_Tokenizer::CTAG], $level);
                    break;
                case Mustache_Tokenizer::T_COMMENT:
                case Mustache_Tokenizer::T_ESCAPED:
                case Mustache_Tokenizer::T_UNESCAPED:
                case Mustache_Tokenizer::T_UNESCAPED_2:
                    $code .= $this->variable($node[Mustache_Tokenizer::NAME], isset($node[Mustache_Tokenizer::FILTERS]) ? $node[Mustache_Tokenizer::FILTERS] : [], $node[Mustache_Tokenizer::TYPE] === Mustache_Tokenizer::T_ESCAPED, $level);
                    break;
                case Mustache_Tokenizer::T_TEXT:
                    $code .= $this->text($node[Mustache_Tokenizer::VALUE], $level);
                    break;
                default:
                    throw new Mustache_Exception_SyntaxException(sprintf("Unknown token type: %s", $node[Mustache_Tokenizer::TYPE]), $node);
            }
        }
        return $code;
    }
    private function writeCode($tree, $name)
    {
        $code = $this->walk($tree);
        $sections = implode("\n", $this->sections);
        $blocks = implode("\n", $this->blocks);
        $klass = empty($this->sections) && empty($this->blocks) ? "<?php\n\n        class %s extends Mustache_Template\n        {%s\n            public function renderInternal(Mustache_Context \$context, \$indent = '')\n            {\n                \$buffer = '';\n        %s\n\n                return \$buffer;\n            }\n        }" : "<?php\n\n        class %s extends Mustache_Template\n        {\n            private \$lambdaHelper;%s\n\n            public function renderInternal(Mustache_Context \$context, \$indent = '')\n            {\n                \$this->lambdaHelper = new Mustache_LambdaHelper(\$this->mustache, \$context);\n                \$buffer = '';\n        %s\n\n                return \$buffer;\n            }\n        %s\n        %s\n        }";
        $callable = $this->strictCallables ? $this->prepare("protected \$strictCallables = true;") : "";
        return sprintf($this->prepare($klass, 0, false, true), $name, $callable, $code, $sections, $blocks);
    }
    private function blockVar($nodes, $id, $start, $end, $otag, $ctag, $level)
    {
        $id = var_export($id, true);
        $else = $this->walk($nodes, $level);
        if ($else !== "") {
            $else = sprintf($this->prepare("} else {%s", $level + 1, false, true), $else);
        }
        return sprintf($this->prepare("\n        \$blockFunction = \$context->findInBlock(%s);\n        if (is_callable(\$blockFunction)) {\n            \$buffer .= call_user_func(\$blockFunction, \$context);\n        %s}\n    ", $level), $id, $else);
    }
    private function blockArg($nodes, $id, $start, $end, $otag, $ctag, $level)
    {
        $key = $this->block($nodes);
        $keystr = var_export($key, true);
        $id = var_export($id, true);
        return sprintf($this->prepare("%s => array(\$this, 'block%s'),", $level), $id, $key);
    }
    private function block($nodes)
    {
        $code = $this->walk($nodes, 0);
        $key = ucfirst(md5($code));
        if (!isset($this->blocks[$key])) {
            $this->blocks[$key] = sprintf($this->prepare("\n        public function block%s(\$context)\n        {\n            \$indent = \$buffer = '';%s\n\n            return \$buffer;\n        }\n    ", 0), $key, $code);
        }
        return $key;
    }
    private function section($nodes, $id, $filters, $start, $end, $otag, $ctag, $level)
    {
        $source = var_export(substr($this->source, $start, $end - $start), true);
        $callable = $this->getCallable();
        if ($otag !== "{{" || $ctag !== "}}") {
            $delimTag = var_export(sprintf("{{= %s %s =}}", $otag, $ctag), true);
            $helper = sprintf("\$this->lambdaHelper->withDelimiters(%s)", $delimTag);
            $delims = ", " . $delimTag;
        } else {
            $helper = "\$this->lambdaHelper";
            $delims = "";
        }
        $key = ucfirst(md5($delims . "\n" . $source));
        if (!isset($this->sections[$key])) {
            $this->sections[$key] = sprintf($this->prepare("\n        private function section%s(Mustache_Context \$context, \$indent, \$value)\n        {\n            \$buffer = '';\n\n            if (%s) {\n                \$source = %s;\n                \$result = call_user_func(\$value, \$source, %s);\n                if (strpos(\$result, '{{') === false) {\n                    \$buffer .= \$result;\n                } else {\n                    \$buffer .= \$this->mustache\n                        {$this->loadLambda}((string) \$result%s)\n                        {$this->renderInternal}(\$context);\n                }\n            } elseif (!empty(\$value)) {\n                \$values = \$this->isIterable(\$value) ? \$value : array(\$value);\n                foreach (\$values as \$value) {\n                    \$context->push(\$value);\n                    %s\n                    \$context->pop();\n                }\n            }\n\n            return \$buffer;\n        }\n    "), $key, $callable, $source, $helper, $delims, $this->walk($nodes, 2));
        }
        $method = $this->getFindMethod($id);
        $id = var_export($id, true);
        $filters = $this->getFilters($filters, $level);
        return sprintf($this->prepare("\n        // %s section\n        \$value = \$context->%s(%s);%s\n        \$buffer .= \$this->section%s(\$context, \$indent, \$value);\n    ", $level), $id, $method, $id, $filters, $key);
    }
    private function invertedSection($nodes, $id, $filters, $level)
    {
        $method = $this->getFindMethod($id);
        $id = var_export($id, true);
        $filters = $this->getFilters($filters, $level);
        return sprintf($this->prepare("\n        // %s inverted section\n        \$value = \$context->%s(%s);%s\n        if (empty(\$value)) {\n            %s\n        }\n    ", $level), $id, $method, $id, $filters, $this->walk($nodes, $level));
    }
    private function partial($id, $indent, $level)
    {
        if ($indent !== "") {
            $indentParam = sprintf(", \$indent . %s", var_export($indent, true));
        } else {
            $indentParam = "";
        }
        return sprintf($this->prepare("\n        if (\$partial = \$this->mustache->loadPartial(%s)) {\n            \$buffer .= \$partial->renderInternal(\$context%s);\n        }\n    ", $level), var_export($id, true), $indentParam);
    }
    private function parent($id, $indent, $children, $level)
    {
        $realChildren = array_filter($children, ["Mustache_Compiler", "onlyBlockArgs"]);
        if (empty($realChildren)) {
            return sprintf($this->prepare("\n        if (\$parent = \$this->mustache->loadPartial(%s)) {\n            \$buffer .= \$parent->renderInternal(\$context, \$indent);\n        }\n    ", $level), var_export($id, true));
        }
        return sprintf($this->prepare("\n        if (\$parent = \$this->mustache->loadPartial(%s)) {\n            \$context->pushBlockContext(array(%s\n            ));\n            \$buffer .= \$parent->renderInternal(\$context, \$indent);\n            \$context->popBlockContext();\n        }\n    ", $level), var_export($id, true), $this->walk($realChildren, $level + 1));
    }
    private static function onlyBlockArgs($node)
    {
        return $node[Mustache_Tokenizer::TYPE] === Mustache_Tokenizer::T_BLOCK_ARG;
    }
    private function variable($id, $filters, $escape, $level)
    {
        $method = $this->getFindMethod($id);
        $id = $method !== "last" ? var_export($id, true) : "";
        $filters = $this->getFilters($filters, $level);
        $value = $escape ? $this->getEscape() : "\$value";
        return sprintf($this->prepare("\n        \$value = \$this->resolveValue(\$context->%s(%s), \$context);%s\n        \$buffer .= %s%s;\n    ", $level), $method, $id, $filters, $this->flushIndent(), $value);
    }
    private function getFilters($filters, $level)
    {
        if (empty($filters)) {
            return "";
        }
        $name = array_shift($filters);
        $method = $this->getFindMethod($name);
        $filter = $method !== "last" ? var_export($name, true) : "";
        $callable = $this->getCallable("\$filter");
        $msg = var_export($name, true);
        return sprintf($this->prepare("\n        \$filter = \$context->%s(%s);\n        if (!(%s)) {\n            throw new Mustache_Exception_UnknownFilterException(%s);\n        }\n        \$value = call_user_func(\$filter, \$value);%s\n    ", $level), $method, $filter, $callable, $msg, $this->getFilters($filters, $level));
    }
    private function text($text, $level)
    {
        $indentNextLine = substr($text, -1) === "\n";
        $code = sprintf($this->prepare("\$buffer .= %s%s;", $level), $this->flushIndent(), var_export($text, true));
        $this->indentNextLine = $indentNextLine;
        return $code;
    }
    private function prepare($text, $bonus = 0, $prependNewline = true, $appendNewline = false)
    {
        $text = ($prependNewline ? "\n" : "") . trim($text);
        if ($prependNewline) {
            $bonus++;
        }
        if ($appendNewline) {
            $text .= "\n";
        }
        return preg_replace("/\n( {8})?/", "\n" . str_repeat(" ", $bonus * 4), $text);
    }
    private function getEscape($value = "\$value")
    {
        if ($this->customEscape) {
            return sprintf("call_user_func(\$this->mustache->getEscape(), %s)", $value);
        }
        return sprintf("htmlspecialchars(%s, %s, %s)", $value, var_export($this->entityFlags, true), var_export($this->charset, true));
    }
    private function getFindMethod($id)
    {
        if ($id === ".") {
            return "last";
        }
        if (isset($this->pragmas[Mustache_Engine::PRAGMA_ANCHORED_DOT]) && $this->pragmas[Mustache_Engine::PRAGMA_ANCHORED_DOT] && substr($id, 0, 1) === ".") {
            return "findAnchoredDot";
        }
        if (strpos($id, ".") === false) {
            return "find";
        }
        return "findDot";
    }
    private function getCallable($variable = "\$value")
    {
        $tpl = $this->strictCallables ? "is_object(%s) && is_callable(%s)" : "!is_string(%s) && is_callable(%s)";
        return sprintf($tpl, $variable, $variable);
    }
    private function flushIndent()
    {
        if (!$this->indentNextLine) {
            return "";
        }
        $this->indentNextLine = false;
        return "\$indent . ";
    }
}

?>