# Beautiful WordPress Error Page (PHP) for Devs

![Banner](https://wpmanageninja.com/wp-content/uploads/2023/08/ignite-banner.png)


### Whats New Here
- Added Whoops Package for PHP Version <= 8 , need to run modify & update Composer 
- Ignition Can be used by updating composer json file and updating composer, min PHP version >= 8
- Added `vdd`,`dd`,`tvdd`,`ddPlain` helpder function for debuging

### Requirements

- PHP 7.4 or higher

### Installation

- Clone or download this plugin and place it in your `wp-content/plugins` directory.
- Activate the plugin from the WordPress admin panel.
- Make sure `WP_DEBUG` is set to `true` in your `wp-config.php` file.
- Or add `define('WP_DEVELOPMENT_MODE', true);` in your `wp-config.php` file.
- That's it. You are ready to go.

### Customization

- To enable dark mode, add `define('FLUENT_IGNITION_THEME', 'dark');` in your `wp-config.php` file.

### ATTENTION
DO NOT USE THIS PLUGIN IN THE PRODUCTION SITE. THIS PLUGIN IS ONLY FOR DEVELOPMENT PURPOSE.

### Packages Used

- [Ignition](https://github.com/spatie/ignition)

