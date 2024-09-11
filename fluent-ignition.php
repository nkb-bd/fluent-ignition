<?php
/*
Plugin Name:  Fluent Ignition - Error Handling for Devs
Plugin URI:   https://wpmanageninja.com
Description:  [Require PHP 8.1] - A beautiful error page for WordPress Errors. Only for local development. DO NOT USE IN PRODUCTION.
Version:      1.0.0
Author:       techjewel
Author URI:   https://wpmanageninja.com
License:      GPLv2 or later
License URI:  https://www.gnu.org/licenses/gpl-2.0.html
*/


use Whoops\Run;
use Whoops\Handler\PrettyPageHandler;
use Whoops\Handler\JsonResponseHandler;
use Symfony\Component\VarDumper\VarDumper;
use Symfony\Component\VarDumper\Cloner\VarCloner;
use Symfony\Component\VarDumper\Dumper\CliDumper;
use Symfony\Component\VarDumper\Dumper\HtmlDumper;

class FluentIgnitionErrorHandler
{
    public function __construct()
    {
        require_once __DIR__ . '/src/_FluentIgnitionHelperAliases.php';
        require_once __DIR__ . '/src/VarDumperHelpers.php';
    }
    
    public static function init()
    {
        require_once __DIR__ . '/vendor/autoload.php';
    
        $useSpaite = defined('SPAITE_HANDLER') && (defined('WP_DEBUG') && WP_DEBUG) || (defined('WP_DEVELOPMENT_MODE') && WP_DEVELOPMENT_MODE);
        // Check PHP version
        if (version_compare(PHP_VERSION, '8.1.0', '>=') && $useSpaite) {
            self::initIgnition();
        } else {
            self::initWhoops();
        }
        throw new Exception("Test exception for Whoops");
    
    
        // Modify plugin order on activation
        add_filter('pre_update_option_active_plugins', [self::class, 'modifyPluginOrder']);
        register_activation_hook(__FILE__, [self::class, 'modifyPluginOrder']);
    }
    
    private static function initIgnition()
    {
        require_once __DIR__ . '/InitFluentIgnition.php';
    
        InitFluentIgnition::initFluentIgnition();
    }
    
    private static function initWhoops()
    {
        $whoops = new Run();
        
        $acceptHeader = isset($_SERVER['HTTP_ACCEPT']) ? $_SERVER['HTTP_ACCEPT'] : '';
        
        if (strpos($acceptHeader, 'application/json') !== false) {
            $handler = new \Whoops\Handler\JsonResponseHandler;
           
            $whoops->pushHandler(new JsonResponseHandler());
        } else {
            $handler = new \Whoops\Handler\PrettyPageHandler;
            $handler->setEditor(function ($file, $line) {
                return "vscode://file/$file:$line";
            });
    
            $whoops->pushHandler(new PrettyPageHandler());
            
        }
        $whoops->register();
    }
    
    public static function modifyPluginOrder($plugins)
    {
        $index = array_search('fluent-ignition/fluent-ignition.php', $plugins);
        if ($index !== false) {
            if ($index === 0) {
                return $plugins;
            }
            unset($plugins[$index]);
            array_unshift($plugins, 'fluent-ignition/fluent-ignition.php');
        }
        return $plugins;
    }
    
    public static function dumpWithCss($var)
    {
        self::setStyles();
        VarDumper::dump($var);
    }
    
    public static function dump($var)
    {
        VarDumper::dump($var);
    }
    
    private static function setStyles()
    {
        if (in_array(PHP_SAPI, ['cli', 'phpdbg'], true)) {
            if (PHP_SAPI === 'cli') {
                VarDumper::setHandler(new CliDumper());
            }
            return;
        }
        
        if (null !== VarDumper::getHandler()) {
            return;
        }
        
        $cloner = new VarCloner();
        $dumper = new HtmlDumper();
        
        $styles = [
            'default'   => 'background-color:#1c202c; color:#f2f2f2; font-size:18px; word-wrap: break-word; white-space: pre-wrap; position:relative; z-index:99999; word-break: break-all;',
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
        VarDumper::setHandler(function ($var) use ($cloner, $dumper) {
            $dumper->dump($cloner->cloneVar($var));
        });
    }
}

// Initialize the plugin
FluentIgnitionErrorHandler::init();


