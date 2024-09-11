<?php


class InitFluentIgnition
{
    
    public static function initFluentIgnition()
    {
    
        $theme = 'light';
        if (defined('FLUENT_IGNITION_THEME')) {
            $theme = FLUENT_IGNITION_THEME;
        }
        
        
        \Spatie\Ignition\Ignition::make()
            ->applicationPath(ABSPATH)
            ->setTheme($theme)
            ->setEditor('phpstorm') // or 'vscode'
            ->register();
    }
}
