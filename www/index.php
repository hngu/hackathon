<?php

/**
 * A user's browser accesses this file when interacting with WishList (point of entry).
 * This file sets up the environment, validates the action request, makes the call, and then cleans
 * up the environment (performs any required shutdown procedures).
 */

define('APPLICATION_PATH', realpath(dirname(__FILE__)) . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR);

$app_name = 'wishlist_client_service';
//bootstrap($app_name);

// Add the application lib and shared lib directories to the include path.
$appLibPath = APPLICATION_PATH . 'lib';
set_include_path( $appLibPath . PATH_SEPARATOR . get_include_path () );

// Load the common scripts (path defined in SHARED_LIB_PATH [Apache]).
//require_once 'Log.php'; // Logging singleton
//require_once 'Database.php';
//require_once 'session.inc.db.php'; // DB backed session handling
//require_once 'Cache.php';
//require_once 'Common.php';
//require_once 'GlobalExceptionHandler.php'; //setup custom exception and error handlers

//register a shutdown function so any required cleanup is always run
function shutdown()
{
	//Database::close();
	//Log::close();
}
//register_shutdown_function('shutdown');

// Available controller calls that can be handled by Toolbar Service. The value of 'action'
// (passed as a URL parameter by the toolbar) is validated against this list. Each of these
// actions correspond to a file located in toolbar_service/controllers/
$controllers = array(

	'login',
	'logout',
	'refresh_session',  //causes the session to be kept alive (basically a no-op)

	'add_to_wishlist',
	'google_shopping',
	'product_detail',
    'update_item',
	'delete_item',
	'track_page'
);

$action_param = 'action';  // Name of the $_REQUEST param used to decide which controller to run
$default_action = 'dashboard';  // Default controller

if (!isset($_REQUEST[$action_param]) || !in_array($_REQUEST[$action_param], $controllers))
{
	# Either no action, or an invalid action.
	# Redirect to our default action.
	$action = $default_action;
}
else
{
	# We got a valid action, proceed.
	$action = strtolower($_REQUEST[$action_param]);  // Normalize the action / controller name
}

session_start(); // Start the session before anything is executed or output.

require_once APPLICATION_PATH . 'controllers' . DIRECTORY_SEPARATOR . $action . '.php'; // Load the controller
$action(); // Run the controllers
