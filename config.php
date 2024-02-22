<?php
	/*
		AJ-BOT przygotowany na potrzeby https://ajoneg.eu/ts/
		© 2022 by AjonEG <ajonoficjalny@gmail.com>
		Wykorzystuje bibliotekę ts3admin.
	*/
	
	// Ładujemy nasz framework
	require('lib/ts3admin.class.php');

	// Ładujemy funkcje AJ-BOT
	require('function/dbcon.php'); // baza
	require('function/online.php'); // online
	require('function/recordonline.php'); // rekord online
	require('function/admin_report.php'); // admin report
	require('function/register.php'); // rejesteracja
	require('function/adminstatus.php'); // admin status
	require('function/channels.php'); // kanaly
	require('function/twitchstatus.php'); // twitch terst
	require('function/statistic.php'); // user global statistic
	require('function/functions.php'); // test page functions (ajoneg.eu)
	// Koniec ładowania
	
	$ajcfg = array();
	
	// Dane do logowanie query
	$ajcfg['ip'] = '127.0.0.1'; // domyslnie localhost
	$ajcfg['password'] = ''; // haslo do serveradmin
	$ajcfg['user'] = 'serveradmin'; // domyslnie serveradmin
	$ajcfg['port'] = '9987'; // domyslny port 9987
	$ajcfg['query_port'] = '10011'; // port query
	
	// Other
	$ajcfg['bot_name'] = 'AJONEG.EU'; // nazwa naszego bota
	$ajcfg['defaultChannel'] = 1;
	$ajcfg['interval'] = 1; //per second
?>