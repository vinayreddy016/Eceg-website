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
define('DB_NAME', 'eceg_db');

/** MySQL database username */
define('DB_USER', 'eceg_db_user');

/** MySQL database password */
define('DB_PASSWORD', 'ezerka@2017');

/** MySQL hostname */
define('DB_HOST', '198.71.230.53');

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
define('AUTH_KEY',         'd~g<Cw]Q]1vRT7R.u5C^WXlhdGF#av_PVafIhEV#u1lxXWz<fHg%](AvWZ6C@eLT');
define('SECURE_AUTH_KEY',  'H!iH)Ky>u|+_q]S1y&s:Q;d17sWhh+eM(?`/Yle=xT0jY[?ZLJ8P|ITHUEid~))z');
define('LOGGED_IN_KEY',    ']Hsgj7$<8iq`D=xZF(bx^LafDc0x~@1EP>#t13Rm+qH*D],XC~9l1r-C.=}@5u6@');
define('NONCE_KEY',        'oD(`*fN(uQoTam8SDRpe.z8;08T^t1/3G4r1Xoz9TJ@v[>n2#Q<t@}SVjVn7oi+m');
define('AUTH_SALT',        'crU%]@`Q3yvX5<gqBpbPyV]n8Rp5liI|XmfFTYjMVel4%`5vNRGvMLHkV~Be6HPH');
define('SECURE_AUTH_SALT', 'aJyHQUo5=$Vo3<E<WF`0*$y4^G+mZq98jYGf)Yx [Ab)Kr?xbGHy 4&#,}mw7bmb');
define('LOGGED_IN_SALT',   '~/D%-Ln|Mo)q%g!$0s)1[N7X( /hk}ybQ5hAOv|X<f<<-RD^Qe+1~p)f3rUb]t c');
define('NONCE_SALT',       'Te2zK(/P^O=[4Smy4o>/$FSe2:1rf<zr?Sk@],bVTTaSzYejPMq]M3^^r4i470Z,');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'wp_eceg_website_';

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
