<?php

Use FluentIgnition\src\VarDumperHelpers;


if (!function_exists('vdd')) {
    function vdd(...$vars)
    {
        foreach ($vars as $var) {
            VarDumperHelpers::dump($var);
        }
        die();
    }
}


if (!function_exists('vd')) {
    function vd(...$vars)
    {
        foreach ($vars as $var) {
            VarDumperHelpers::dumpWithCss($var);
        }
    }
}

if (!function_exists('dd')) {
    function dd(...$vars)
    {
        foreach ($vars as $var) {
            VarDumperHelpers::dump($var);
        }
        die();
    }
}

if (!function_exists('ddPlain')) {
    function ddPlain(...$vars)
    {
        foreach ($vars as $var) {
            VarDumperHelpers::dumpPlain($var);
        }
        die();
    }
}

if (!function_exists('tvd')) {
    function tvd($var)
    {
        trace();
        VarDumperHelpers::dump($var);
    }
}

if (!function_exists('tvdd')) {
    function tvdd($var)
    {
        trace();
        VarDumperHelpers::vdump_and_die($var);
    }
}


if (!function_exists('trace')) {
    function trace($stack_depth = 1)
    {
        $trace = debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS, $stack_depth + 1);
        array_shift($trace);
        VarDumperHelpers::dump($trace);
    }
}




