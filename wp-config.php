<?php
/**
 * The base configurations of the WordPress.
 *
 * This file has the following configurations: MySQL settings, Table Prefix,
 * Secret Keys, and ABSPATH. You can find more information by visiting
 * {@link https://codex.wordpress.org/Editing_wp-config.php Editing wp-config.php}
 * Codex page. You can get the MySQL settings from your web host.
 *
 * This file is used by the wp-config.php creation script during the
 * installation. You don't have to use the web site, you can just copy this file
 * to "wp-config.php" and fill in the values.
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define('DB_NAME', 'skyicoupon');

/** MySQL database username */
define('DB_USER', 'root');

/** MySQL database password */
define('DB_PASSWORD', '');

/** MySQL hostname */
define('DB_HOST', 'localhost');

/** Database Charset to use in creating database tables. */
define('DB_CHARSET', 'utf8mb4');

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
define('AUTH_KEY',         'F-Ri~hpgTosGHY+-/V|hRU7QAWuB|6F-,E80FF9e9.ZHlZJ2-G.cxbnc8giPsBHs');
define('SECURE_AUTH_KEY',  'og.T/UkNy|Tp2yCGF b11V9`zq;6)}@qx.3q]~-!/n|0LeNa+P/.ij9O:1KZc*H7');
define('LOGGED_IN_KEY',    'osJ9/LF.<5l1UZ_,AG!&2NI+7=!_Z+GOI=<1WQ [%Z7MyEjbi+gN7qDj=(<hUD$o');
define('NONCE_KEY',        'IX,rH1Nffx+66FvR+DXUUM. f^<|-.,0V4L)g;Tv8y[jzir$|Upwp4B(o|J0%|+G');
define('AUTH_SALT',        'HT,61+|Y`@x+cF<cTW~xsDJQ2p@=t#DNv<B;HT7G=*HW7i;Rllej$K2>+}(B+/w2');
define('SECURE_AUTH_SALT', 'ji_aR9*)IR-lJ_bp`_5vz6h&~j{l_horJ_UI-3b!$@b], %vNy]bv^N$Pe@61u|$');
define('LOGGED_IN_SALT',   '$J<Z^RYa?+My8aj!ubqz!kaaYxc?:)HH)B3y+@]:i1S`+fs1UEUv iPULm#H1H ^');
define('NONCE_SALT',       'q1XkKbKWG%3B|kX55]f=)vYVRWcSm&b>T@5K|F>il 2?,RF:^YMxBwz2ovoN;KXP');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each a unique
 * prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'wp_';

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 */
define('WP_DEBUG', true);
define('WP_DEBUG_LOG', true);
/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
