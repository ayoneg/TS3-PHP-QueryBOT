<?php
	// funkcja (((
	class functions
	{
		// TODO: dokoncZyc
		/*
		function start($info,$mysqli){
			// administrator miesiaca automat
			$sprawdz = mysqli_fetch_array($mysqli->query("SELECT * FROM `ajon_console` WHERE contype='49' ORDER BY contime DESC LIMIT 1"));
			if(($sprawdz['contime']+2592000)<=time()){
				$normy = $mysqli->query("SELECT * FROM ajon_user WHERE ranga>0 ORDER BY raporty DESC LIMIT 3") or die('Błąd zapytania');
				while($r = mysqli_fetch_assoc($normy)) {
					$mysqli->query("INSERT INTO `addon_assign_groups` SET uuid='".$r['uuid']."', grpids='216'");
				}
				$mysqli->query("UPDATE `job_check` SET `timestamp`='1' WHERE `job_name`='reload_trigger';");
				$contype = 49;
				$czasoff = time();
				$mysqli->query("INSERT INTO `ajon_console` SET contime='$czasoff', contype='$contype'");
				//mini pow system
				$pow = $mysqli->query("SELECT * FROM ajon_user WHERE ranga>0") or die('Błąd zapytania');
				while($r = mysqli_fetch_assoc($pow)) {
					$mysqli->query("UPDATE `ajon_user` SET admpow=admpow+1 WHERE MD5(uuid)='".md5($r['uuid'])."'");
				}
			}
		}
		*/
	}
?>