<?php

namespace FluentIgnition\src;

use Symfony\Component\VarDumper\VarDumper;
use Symfony\Component\VarDumper\Cloner\VarCloner;
use Symfony\Component\VarDumper\Dumper\CliDumper;
use Symfony\Component\VarDumper\Dumper\HtmlDumper;

class VarDumperHelpers
{
    protected static $handler;
    
    public static function dumpWithCss($var)
    {
        static::set_styles();
        VarDumper::dump($var);
    }
    
    public static function dump($var)
    {
        VarDumper::dump($var);
    }
    
    public static function dumpPlain($var)
    {
        $cloner = new VarCloner();
        
        $dumper = new CliDumper(fopen('php://output', 'w'));
        
        $dumper->dump($cloner->cloneVar($var));
    }
    
    private static function set_styles()
    {
        if (in_array(PHP_SAPI, ['cli', 'phpdbg'], true)) {
            if (PHP_SAPI === 'cli') {
                static::$handler = new CliDumper();
            }
            return;
        }
        
        if (null !== static::$handler) {
            return;
        }
        
        $cloner = new VarCloner();
        $dumper = new HtmlDumper();
        
        $styles = [
            'default'   => 'background-color:#1c202c; color:#f2f2f2; font-size:18px;  word-wrap: break-word; white-space: pre-wrap; position:relative; z-index:99999; word-break: break-all;',
            'num'       => 'font-weight:bold; color:#a8def7',
            'note'      => 'color:#a8def7',
            'index'     => 'color:#a8def7',
            'str'       => 'font-weight:bold; color:#6FDD16',
            'key'       => 'color:#6FDD16',
            'meta'      => 'color:#E4EC42',
            'public'    => 'color:#E4EC42',
            'protected' => 'color:#E4EC42',
            'private'   => 'color:#E4EC42',
        ];
        $dumper->setStyles($styles);
        static::$handler = function ($var) use ($cloner, $dumper) {
            $dumper->dump($cloner->cloneVar($var));
        };
        VarDumper::setHandler(static::$handler);
    }
}
