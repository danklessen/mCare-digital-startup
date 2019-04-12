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
define('DB_NAME', 'wp2');

/** MySQL database username */
define('DB_USER', 'root');

/** MySQL database password */
define('DB_PASSWORD', 'root');

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
define('AUTH_KEY',         'D12l+rrzlsSg,,B@Y~>d/ ,Qgj<aFc&/OG,_3Y5}QP^>C]HK%B5xS!Z$HsPVE:kO');
define('SECURE_AUTH_KEY',  ')+tp4FO&mX)*bQi6#G!9dWD^)ZSY&n5^hvepKB2|QEAcx#Nu(NRev7$4*uLZVO,%');
define('LOGGED_IN_KEY',    ' AKp0{,x@fU70&G1fLc2D2WU-S;%`mrFEcUhBXYS<z]1`]<b8mTBq.R5mN]$yf|t');
define('NONCE_KEY',        '5tllte8qCwJGK/J,Le5W,ROPZ2W:QM K+AzLwhxb%oa*;Gv g,2rP>lTS@O[_</&');
define('AUTH_SALT',        'if;|:H(,wgW6l[/9c2od1=U$T#}NTT.-<QUE/7e$<|zR=+sMRiX{sY>@cWHHyL__');
define('SECURE_AUTH_SALT', '/4?ATUucjk+0YgLD4TN]=*91v]T]bBTb+Fox%A|!`G~h(CNspF)Fdx{sAHvs+5%k');
define('LOGGED_IN_SALT',   'hNr_FU4CAOJlR+|q4MSI>#y]m(jjN}[P2SV751gMa3pQKlZ7VleVkN~S&fR2=fo7');
define('NONCE_SALT',       'DT1a-8dU/tYGs.UqH UXP?sRSw1r.xf8YG>/?F6Q:P.FM?E^qMRTd)iL`Z{C1|4?');

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
