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
define('DB_NAME', 'rbrowning');

/** MySQL database username */
define('DB_USER', 'ryan');

/** MySQL database password */
define('DB_PASSWORD', 'browning');

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
define('AUTH_KEY',         '4c~7Hv56xei9wsvn`HOt_Q]-51f`km3M5X?[GQqDKn{VT6=0eCv_bo-r&8Z=u.1@');
define('SECURE_AUTH_KEY',  '8xjM9HT~F>:Y9xEK1(Q#r&mM^q.02R71RqJB53$6%I=M4n-Wvk},qy2(v)[(w/jl');
define('LOGGED_IN_KEY',    'k,BX&QJ=M5;@72xe/x.=0MlRE5z6js)Ra~&N-@u^UC|3{|+P(L81_!WTs)?x.C_f');
define('NONCE_KEY',        'jsz2!GzQw:)pPPH<%YcY_V!wbS(.V;DsuHh>@-6NGv8/k Vf`zwE7FB12-KJrzLA');
define('AUTH_SALT',        'MCwr&OHl(N*v2xG`JQzgfxaffWc]NgU<@(Q_<#FjZ<}D:V^PVLp(nJE+du<F}o!K');
define('SECURE_AUTH_SALT', 'H*Ea>#A+)o@|NMX95D?0!~&rh>`*:I]y%QPDlEhwl=^Ta73sX[ap_fl8SbZW4.|$');
define('LOGGED_IN_SALT',   'KlLa[g~yQh{5ATUn-F1yx3K}R_5kKnD]<,gAa1w$QH1c7XaEK2GRZZ1AG=q`;+AH');
define('NONCE_SALT',       'KzA<{_r!r0H[fx+vVI>r&rbWm)bQhBhh=vH1*tXn$3i!/yg@FGdIImQH}[9:y5l:');

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
define('WP_DEBUG', false);

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
