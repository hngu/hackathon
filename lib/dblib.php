<?php

	bootstrap('hackathon');
	require_once 'S3_helpers.php';
	require_once 'IniConfiguration.php';

	$cfg = IniConfiguration::getInstance();
	$username = $cfg->USERNAME;
	$host = $cfg->HOST;
	$password = $cfg->PASSWORD;
	$database = $cfg->DATABASE;
	
	$db = new mysqli($host, $username, $password, $database);
	
	if (!$db) {
		die('Cannot connect to the database: ' . mysql_error());
	}

		function getDB()
		{
			global $db;
			return $db;
		}
	
?>