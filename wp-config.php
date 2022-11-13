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
define( 'DB_NAME', 'vitech' );

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
define( 'AUTH_KEY',         '82}~rlBt9K8e9H1)S_q+:XeYFxZ!2;+9T&2~.8VN9u=kN*sLnvw%dQm~!wgzzbqt' );
define( 'SECURE_AUTH_KEY',  'QQN]2.@5:tg|;FBhoRR}?t2ROu%fs=&R*/Ey)3Lk#n&>MnipZ,Q<XOg31&R?E%B6' );
define( 'LOGGED_IN_KEY',    '@L@I)Yl4oYT*oZ?L0*T^(Ps&++7[$l:HV,[IT]?F2|m>ClDF.0GPh0B/Rp4&1iYa' );
define( 'NONCE_KEY',        't+a~$pDBGKzB_@l` m5sNN8/dDtT&m|n:hzuXZfU]_<[zO{w?hYRt=$ v*n3iop5' );
define( 'AUTH_SALT',        'UNX^pq32|JK)bm4>M!.vh;_.W6SId|qA<(01vS-vk{Yy9+onp}MEWX?-[5-kTZVx' );
define( 'SECURE_AUTH_SALT', '~r0`}>G]24FI=0huDQ6>T}rUFB53(Jz.HfO31}#GIj^P>HYQ(7<wDI-9/,]Hp@!L' );
define( 'LOGGED_IN_SALT',   'x=WFdZkX[q[}UFJ[{8u#GZXDX *$C*w9E 36^trWmSpO>jO{_)4GHVH <Zj+3l,k' );
define( 'NONCE_SALT',       'n9(/q6VU/]V{cO/LA^)BX<^*x!t.+eo4^82ccL[I[o{fQ]<[S6$*_@>gjqk~un}g' );

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
