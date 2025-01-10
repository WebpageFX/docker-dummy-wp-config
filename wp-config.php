<?php
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the
 * installation. You don't have to use the web site, you can
 * copy this file to "wp-config.php" and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * MySQL settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://wordpress.org/support/article/editing-wp-config-php/
 *
 * @package WordPress
 */

 // IMPORTANT: this file needs to stay in-sync with https://github.com/WordPress/WordPress/blob/master/wp-config-sample.php
// (it gets parsed by the upstream wizard in https://github.com/WordPress/WordPress/blob/f27cb65e1ef25d11b535695a660e7282b98eb742/wp-admin/setup-config.php#L356-L392)

// a helper function to lookup "env_FILE", "env", then fallback
if (!function_exists('getenv_docker')) {
	// https://github.com/docker-library/wordpress/issues/588 (WP-CLI will load this file 2x)
	function getenv_docker($env, $default) {
		if ($fileEnv = getenv($env . '_FILE')) {
			return rtrim(file_get_contents($fileEnv), "\r\n");
		}
		else if (($val = getenv($env)) !== false) {
			return $val;
		}
		else {
			return $default;
		}
	}
}

/**
 * DATABASE CREDENTIALS
 */
define( 'DB_NAME', getenv_docker('DB_NAME', 'project') );
define( 'DB_USER', getenv_docker('DB_USER', 'project') );
define( 'DB_PASSWORD', getenv_docker('DB_PASSWORD', 'project') );
define( 'DB_HOST', getenv_docker('DB_HOST', 'localhost') );

// Set to false to use minified JS & CSS
define( 'SCRIPT_DEBUG', getenv_docker('SCRIPT_DEBUG', 'true') );

/**
 * DEBUGGING SETTINGS
 * READ MORE: https://t.ly/3FRN
 */
define( 'WP_DEBUG', !!getenv_docker('WORDPRESS_DEBUG', 'true') );
define( 'WP_DEBUG_DISPLAY', false );
define( 'WP_DEBUG_LOG', true );
define( 'SAVEQUERIES', false );

/** Database Charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8' );

/** The Database Collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );

/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define('AUTH_KEY',         ':MC8o6:2-M]= t#?;~E8-vk4TJw`K$~APCsG<{/8u~SW2jn@$v!anweEnxvj#J[_');
define('SECURE_AUTH_KEY',  '?SS:*npa#{F/:JsTYscY+Q-q+.<,$=JtlZ{IikHCuzPXa:6e6)dWee,NoKzagH=z');
define('LOGGED_IN_KEY',    '$GcdS/6b63GLHBX{TG{SX1%hf:.AEi%[~Ed+e+]{2G+a-k$d`ZwJ4L,;OC|b;#v}');
define('NONCE_KEY',        '/Sr-vefmV8XO:DH|4)5yXYf(]z{vzk[xF6 Ef>sg7|H%+3?GjjDTbn8A`E3|xC3W');
define('AUTH_SALT',        'Qw(y|Z {rd*MQl;+]pJz7L#|7ZKV{C84<yAiK^iNqo2$bsd/+6QmAmsA%^l$=>[v');
define('SECURE_AUTH_SALT', '?>I&sQ+eV&-`O4<U29(gQ3UF`5]HjrYe@d-`Hfl!FS)/(RR3R,p[oCA|JXYVtbmy');
define('LOGGED_IN_SALT',   'H0]wAJ?~gLu3v;j|&)j?X-Zlrfu5?+8Gs(nWj+i!Gbe5;,j=(L)Saqz5(c~KJ6SW');
define('NONCE_SALT',       'jQlTO`I0>[+D}-R-E@{9z,`Co$KLgVm^)jj!.9K9*S+BkwY];a{eTl+[xDf^`[&3');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each a unique
 * prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = $_ENV['MYSQL_PREFIX'] ?? getenv_docker('WORDPRESS_TABLE_PREFIX', 'wp_');

// TESTING HERE AGAIN conflict

/**
 * Change CF7 Default Behaviors: https://t.ly/YobE
 */
define( 'WPCF7_AUTOP', false );
define( 'WPCF7_LOAD_CSS', false );

if ($configExtra = getenv_docker('WORDPRESS_CONFIG_EXTRA', '')) {
	eval($configExtra);
}

/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';