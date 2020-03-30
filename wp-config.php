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
define( 'DB_NAME', 'icontrac_wp281' );

/** MySQL database username */
define( 'DB_USER', 'icontrac_wp281' );

/** MySQL database password */
define( 'DB_PASSWORD', '88p]RK2CS(' );

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
define( 'AUTH_KEY',         'voefvawhpwqcza4khscp2wfevgpxfizu1wqzkcymemivgn8jaidlifqt5t7pubx2' );
define( 'SECURE_AUTH_KEY',  'pjizjbegtluzzv4oauutvmlpqhpdmrnp42gzquglmlwes6pysmxneeigm1lkjcys' );
define( 'LOGGED_IN_KEY',    'f8kdsvhz7ayc56l2ns7ri7khb9ykuxzea9tiue8ypozyowz3r5t2r8vyjj1rlq4a' );
define( 'NONCE_KEY',        'al6veglb7zuvpgycfbhtsu5ib8exlifhh79d33fvuorprasbwumytemzz7s1dr1w' );
define( 'AUTH_SALT',        'uwdcwo1rxdswjtai7wgluo9zkyphrvblqgdy30m7xq9nidbjpc13xxgc6zbclnbp' );
define( 'SECURE_AUTH_SALT', 'jfphhlrrqpqtk3nlh3ouyolomi0c4rllgwnufwxv75eywbmcclqa8l4jbqnq88qc' );
define( 'LOGGED_IN_SALT',   'ryrydjaelsrqlklfqvgegcd3jkhaz7vlovlcafs8ouvr59ahsdqdejsbfkwua75u' );
define( 'NONCE_SALT',       'atl722loxrbkvjlu5uksbbl5a7rqccxekzvky0h9lf47mdcudrkkfjxdc4rox9jr' );

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'wptr_';

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
define( 'WP_DEBUG', false );

/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', dirname( __FILE__ ) . '/' );
}

/** Sets up WordPress vars and included files. */
require_once( ABSPATH . 'wp-settings.php' );