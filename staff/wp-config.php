<?php
/**
 * The base configurations of the WordPress.
 *
 * This file has the following configurations: MySQL settings, Table Prefix,
 * Secret Keys, WordPress Language, and ABSPATH. You can find more information
 * by visiting {@link http://codex.wordpress.org/Editing_wp-config.php Editing
 * wp-config.php} Codex page. You can get the MySQL settings from your web host.
 *
 * This file is used by the wp-config.php creation script during the
 * installation. You don't have to use the web site, you can just copy this file
 * to "wp-config.php" and fill in the values.
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define('DB_NAME', 'staff');

/** MySQL database username */
define('DB_USER', 'root');

/** MySQL database password */
define('DB_PASSWORD', 'Bononer1988');

/** MySQL hostname */
define('DB_HOST', 'localhost');

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
define('AUTH_KEY',         'C0Sn-vyn2};r_q$^]8V;a#Az#2s&l)O]YQ*!|q=OC@W#z=i%9;7H>9^qZ_-i*m}X');
define('SECURE_AUTH_KEY',  '8[^x@*l;+3yA/JYmqq[gN.:KVj5d?aWm(Uj.5qZR&[AP=zwIFO89?Ae1iu^SDzm&');
define('LOGGED_IN_KEY',    'lc<_(|%,1Ir {l)EZcP+!+fo+88+(H.S1n7XBfk|(#Z!oSqY+.+{Sw?:vE+&Dxtn');
define('NONCE_KEY',        '9XaZ~>x*%x!b.T*M.DI%-N#W%L>x?$,t|X1@IWkC#Jr-p:r&h`bx98Y>&/Wg}ULl');
define('AUTH_SALT',        'CI+rNHW)d,k>{hcAl+|+JcqRL%@+E(,<q^h|&n!RKJ0r?+>!lTjV@9oyn)dfi8;6');
define('SECURE_AUTH_SALT', '[=wFoS^ID8A>$hmdW&,x~=F:=wc)$cO;*[8UUKvBJ,p{zJ~mH^B9h bSD$[KR=&}');
define('LOGGED_IN_SALT',   '(rh|?5A#R[QdSvOX#7p-wPa8.FSG-8V)1ca%f%)-W~ZJgFp4lJQ|||>-N}iVqSDl');
define('NONCE_SALT',       'tV&|O$s+k]pU3HWu^8)C=-~TL5Hr9PgHeW(FjS`$bTCJY@jbEfk.S6jnoNtmJC|h');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each a unique
 * prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'wp_';

/**
 * WordPress Localized Language, defaults to English.
 *
 * Change this to localize WordPress. A corresponding MO file for the chosen
 * language must be installed to wp-content/languages. For example, install
 * de_DE.mo to wp-content/languages and set WPLANG to 'de_DE' to enable German
 * language support.
 */
define('WPLANG', '');

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 */
define('WP_DEBUG', false);

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
