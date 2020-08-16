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

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'wordpress' );

/** MySQL database username */
define( 'DB_USER', 'root' );

/** MySQL database password */
define( 'DB_PASSWORD', '' );

/** MySQL hostname */
define( 'DB_HOST', 'localhost' );

/** Database Charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8mb4' );

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
define( 'AUTH_KEY',         ';O=?qO}9Ui~C&LUR<V2 wS%,?xQTDu[-~%Oak?|JKaL%[6_BG3T;v;LiS^t[jgsH' );
define( 'SECURE_AUTH_KEY',  'J@7nvP?mvkN}tRy%GdSw=H%026E,8kB%f0NF@ym5g,brqN<W8=mU4EAd2]>aR5;@' );
define( 'LOGGED_IN_KEY',    'a_Bgzc@,UQY#E?u8h_p@>Oj)7Wzc5se!J_M`UVu6h>ps~;T2:??%|NS*&K R~u~k' );
define( 'NONCE_KEY',        '_i*YQhODZ~+L[E#?A]lha-U85n$ ^=0w|f~a8Fi=~Yw5Enu#+^;ACPtLU+V0PZ?:' );
define( 'AUTH_SALT',        'pt6ZrK<|M2hO#iHYwlTgM^O+HjV$~Iw<wC tNq;QcM8Rra%_nL$w#W=8@8M!.-;_' );
define( 'SECURE_AUTH_SALT', 'm&7m,*%Gx9/EM8TX]>m8|Wb:LgH8#SlO0C+6v%g#/N1:vGv_XV7XN@:yJ, A$:X<' );
define( 'LOGGED_IN_SALT',   'l)J~LG?%6EUO+0sFYHg6uG,XTzWKL(N<#r9{a_~R/`:`#F*zE|8Ennd1ggMusE?]' );
define( 'NONCE_SALT',       '=l+xG}tElLf-@%Z$]mO{vtEMP*nHU#-r}m|,E|,U~c3fm#*:I.Zio0[NpP4xjGs!' );

/**#@-*/

/**
 * WordPress Database Table prefix.
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

/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
