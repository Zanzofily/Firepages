<?php
  // database initialization 
	require_once ( __DIR__ . "/config.php");
	require_once ( __DIR__ . "/MysqliDb.php");

	$db = new Mysqlidb( $db_info );
	if(!$db) die("Database error.");

?>