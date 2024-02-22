<?php
	// oraz biblio
	// Ładujemy naszą konfigurację
	require("config.php");
	
	$ts = new ts3admin($ajcfg['ip'], $ajcfg['query_port']);
	if($ts->getElement('success', $ts->connect())){
		$ts->login($ajcfg['user'], $ajcfg['password']);
		$ts->selectServer($ajcfg['port']);
		$ts->setName($ajcfg['bot_name']);		
		while (true)
		{
			$p1 = new statistic();
			$p1->start($ts,$mysqli); // ,$mysqli is 
			
			$p2 = new admin_report();
			$p2->start($ts,$mysqli); // ,$mysqli is 

			$p3 = new online();
			$p3->start($ts,$mysqli); // ,$mysqli is 

			//$p4 = new adminstatus();
			//$p4->start($ts); // ,$mysqli is 

			$p5 = new register();
			$p5->start($ts); // ,$mysqli is 

			sleep($ajcfg['interval']);
		}
	}
?>