<?php
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the installation.
 * You don't have to use the web site, you can copy this file to "wp-config.php"
 * and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * Database settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://wordpress.org/support/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** Database settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'filter' );

/** Database username */
define( 'DB_USER', 'root' );

/** Database password */
define( 'DB_PASSWORD', '' );

/** Database hostname */
define( 'DB_HOST', 'localhost' );

/** Database charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8mb4' );

/** The database collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );

/**#@+
 * Authentication unique keys and salts.
 *
 * Change these to different unique phrases! You can generate these using
 * the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}.
 *
 * You can change these at any point in time to invalidate all existing cookies.
 * This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY',         'hf*~+Pj1jO_W<6v5CcT?}Lm;zQVXJ;HZQ6`pV&`;<j?da20}!va)E9Y?.-ZBhc(1' );
define( 'SECURE_AUTH_KEY',  'R@_rrw&={,9ns^O*[QbD8,k )o1m`Mhr+ rBhB)@ zy`x_d$e,`3z:L>V%~`y5F-' );
define( 'LOGGED_IN_KEY',    'fO>i0uqVI9SMpA#Y/$@h4a}n1g|3j<0sHL5:> ec2`GNhLj]!%D*PjOfOIA0EfK)' );
define( 'NONCE_KEY',        'w#s53hzU]h:C?|8.AEMu#?mj$t5Yt!pQ{bv$tDYToz6+^ppSQ1}Nz4O{QEdSE]JG' );
define( 'AUTH_SALT',        'v3%UpGg)A8XIfun~P0Tk&>Po/%qtE+I=n(4z^PW)U;#>=q?=Et&8]$,Am57zc~I|' );
define( 'SECURE_AUTH_SALT', 'MY2*{3n)9YPg&Z=8Mlci6S9P=D:%FdVZ|tt5<tPAe7$btyw{]O@7A)ve[mCqFWT$' );
define( 'LOGGED_IN_SALT',   'U15A&=|9=xn+%#1qQ>;(73 X(^g0Pu`^9CGlCOn&28YriQ!Br8:q&M/h^m&?byj6' );
define( 'NONCE_SALT',       'ZqaFR>xP(Ibem`Xn6;9)bK4vtB^b*Xor>R@-$No-,n)2x7tMf2_RNB2VG-?+3@)<' );

/**#@-*/

/**
 * WordPress database table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'wp_';

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 *
 * For information on other constants that can be used for debugging,
 * visit the documentation.
 *
 * @link https://wordpress.org/support/article/debugging-in-wordpress/
 */
define( 'WP_DEBUG', false );

/* Add any custom values between this line and the "stop editing" line. */



/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
