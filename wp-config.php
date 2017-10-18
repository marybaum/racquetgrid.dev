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
 * @link https://codex.wordpress.org/Editing_wp-config.php
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define('DB_NAME', 'racquetgDB7mara');

/** MySQL database username */
define('DB_USER', 'racquetgDB7mara');

/** MySQL database password */
define('DB_PASSWORD', 'Bjr2RaRamA');

/** MySQL hostname */
define('DB_HOST', '127.0.0.1');

/** Database Charset to use in creating database tables. */
define('DB_CHARSET', 'utf8');

/** The Database Collate type. Don't change this if in doubt. */
define('DB_COLLATE', '');

/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define('AUTH_KEY',         'myj$jTAMmTAIITA<u*A<u*m.qXiPqXiP6PXE]6.!nzgNgrYF}7UBM3^4F}zgr}y');
define('SECURE_AUTH_KEY',  'WW;yrrjYfX<MBuAujjXQTLA6<$g4kocgRF0NB}!Fvg@rcQSD:_9pa~sdSpdO9C:!9');
define('LOGGED_IN_KEY',    'oBN4UcJ0$,7F}z^n,yfrUnzcJQ7FfIU7,{FM3$>uo-hKV8SZGO5~[K:8!o-[w~kR');
define('NONCE_KEY',        'I1~lSZt-hOWDZlO5C[1K:9_p-1~|sZh-!oRdGgoVCJ08R8G:w!*itXDPeLTAH;PWD');
define('AUTH_SALT',        '-~kwd@|sZgNdoV8K:qxeLTAHbEP2*<itOmWD]O5H;~2~p+ljUB<FQ7>v3^q$j$nUf');
define('SECURE_AUTH_SALT', 'pXH2D]nUgJ0BYF}z7J0^n^r@jUv$jQYEUfI7,}M3B<q$y^nUbZhO1C|8G:-!ow0');
define('LOGGED_IN_SALT',   'xODdK5G:H:9#tQbI$3E{yfryjPbyfQAbI2E{AM$.q{2*<uai+eqXALF}4!>v>0');
define('NONCE_SALT',       'LATeL;A.DP2*#t#;+.pWeB,0zgn!>vckQnzcIQ7FYFM3$>I{7^nu>v$jrYy^nQbEX');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'wp_';

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 *
 * For information on other constants that can be used for debugging,
 * visit the Codex.
 *
 * @link https://codex.wordpress.org/Debugging_in_WordPress
 */
define('WP_DEBUG', false);define('FS_METHOD', 'direct');

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
