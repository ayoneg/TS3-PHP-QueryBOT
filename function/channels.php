<?php
	// funkcja (((
	// kanaly prywatne
	class channels
	{
		public static $channel_groups = array(5,6,13);
		public static $ran = 0;
		public static $guest_groupID = 8;
		public static $time_s = 1209600; // 1209600 s 14 dni w sekundach
		public static $time_cunt = 60; // 60 s
		public static $cuter = 1795;
		public static $cuer_channels = array();
		public static $test = array();
		
		public static $wymagane = array(7,193);//7, 193

		public function start($info,$mysqli){
			
			// wykrywajaca i aktualizujaca kanaly
			// raz na 60 sekund
			if(self::$ran >= self::$time_cunt){
				$channels = $mysqli->query("SELECT * FROM aj_channels") or die('Błąd zapytania');
				while($ch = mysqli_fetch_assoc($channels)) {
					$channel = $info->getElement('data',$info->channelInfo($ch['chid']));
					if(!empty($channel)){
						$calc = time()-self::$time_s;
						$namessdb = strlen($ch['id']);
						$namess = substr($channel['channel_name'], 0, $namessdb);
						if($calc > $ch['lastactive'] AND $ch['creator'] != 0){
							// remove channel from SERVER 
							//$info->sendMessage(1, 55243, "[b]kurwa z cb[/b]");
							$info->channelEdit($ch['chid'], [
							'channel_name' => $ch['id'].'. WOLNY KANAŁ', 
							'channel_topic' => $ch['id'].'. WOLNY KANAŁ @ AJBOT by AJONEG.EU',
							'channel_description' => '[hr][center][size=13][b]» WOLNY KANAŁ «[/b][/size][/center][center][color=#e7ac20] ['.$ch['id'].'] AJONEG.EU [/color][/center][hr]',
							'channel_password' => md5($ch['id'].'.ajoneg.e4u'),
							'channel_maxclients' => 0
							]);
							
							$clients = $info->getElement('data',$info->channelGroupClientList($ch['chid']));
							foreach($clients as $us){
								$info->setClientChannelGroup(self::$guest_groupID, $ch['chid'], $us['cldbid']);
							}
							unset(self::$cuer_channels[$ch['chid']]);
							// aktualizacja bazy po wszystkim
							// kanal dostaje creator=0 czyli moze zostac zaclaimowany przez innego usera
							$time_new = time()+(time()/2);
							$mysqli->query("UPDATE `aj_channels` SET creator='0', lastactive='$time_new' WHERE id='".$ch['id']."'");
						}elseif($ch['creator'] != 0 AND $namess != $namessdb){
							// funkcja zmienia {nazwe kanału} na {lp}. {nazwa kanału}
							// jesli kanał jest ustawiony prawidlowo nie zmienia nic
							$name = $namessdb.". ".$channel['channel_name'];
							$name = substr($name, 0, 40);
							$info->channelEdit($ch['chid'], [
							'channel_name' => $name, 
							]);
						}
					}else{
						unset(self::$cuer_channels[$ch['chid']]);
						$mysqli->query("UPDATE `aj_channels` SET creator='0', lastactive='0' WHERE id='".$ch['id']."'");
					}	
						
				}
				self::$ran = 0;
			}else{
				self::$ran++;
			}
			
			// tutaj odbywa się nadawanie kanalów do array raz na 30 min
			// pierwszy skan jest po 5s od odpalenia bota
			if(self::$cuter >= 1800){ // 30 min
				$chan = $mysqli->query("SELECT * FROM aj_channels WHERE creator<>'0'") or die('Błąd zapytania');
				// add new record to array
				while($ch = mysqli_fetch_assoc($chan)) {
					unset(self::$cuer_channels[$ch['chid']]);
					array_push(self::$cuer_channels, $ch['chid']);
				}
				self::$cuter=0;
			}else{
				self::$cuter++;
			}
			
			
			// nadawanie aktywnosci na dany kanal z listy
			foreach(self::$cuer_channels as $t){
				$chaninf = $info->getElement('data',$info->channelClientList($t,"-groups"));
				if(!empty($chaninf)){ // jesli nie jest empty
					foreach($chaninf as $us){
						if(in_array($us['client_channel_group_id'], self::$channel_groups)){
							$mysqli->query("UPDATE `aj_channels` SET lastactive='".time()."' WHERE chid='".$t."'");
							return;
						}
					}
				}
			}	
			
			// + sprawdzanie czy nie posiadamy aktualnie
			// + czy nie ma bana za poprzedni kanał nieaktywny (raczej nie potrzeba)
			$cha = $info->getElement('data',$info->channelClientList(228,"-groups -uid"));
			if(!empty($cha)){ // jesli nie jest empty
				foreach($cha as $c){
					$sql = mysqli_fetch_array($mysqli->query("SELECT *, COUNT(*) AS wynik FROM `aj_channels` WHERE creator='".$c['client_database_id']."'"));
					if($sql['wynik']==0){
						// jesli nie mamy kanalu
						$exp = explode(',', $c['client_servergroups']);
						foreach($exp as $cgid){
							if(in_array($cgid, self::$wymagane)){
								// spelnia wymagania
								// robimy kanal wow s
								$sql2 = mysqli_fetch_array($mysqli->query("SELECT *, COUNT(*) AS wynik FROM `aj_channels` WHERE creator='0' ORDER BY id ASC"));
								if($sql2['wynik']>0){
									$string = bin2hex(random_bytes(5));
									$name = $sql2['id'].'. Kanał '.$c['client_nickname'];
									$info->channelEdit($sql2['chid'], [
									'channel_name' => $name, 
									'channel_topic' => $name,
									'channel_description' => '[hr][center][size=13][b]» '.$sql2['id'].'. Kanał '.$c['client_nickname'].' «[/b][/size][/center][center][color=#e7ac20] Strefa prywatna na AJONEG.EU! [/color][/center][hr]',
									'channel_password' => $string,
									'channel_maxclients' => -1,
									]);
									
									$info->setClientChannelGroup(5, $sql2['chid'], $c['client_database_id']);
									
									$info->sendMessage(1, $c['clid'], "[b]Gratulacje![/b] Stworzyliśmy dla Ciebię prywatny kanał.");
									$info->sendMessage(1, $c['clid'], "[b]Nazwa[/b]: ".$sql2['id'].". Kanał ".$c['client_nickname']);
									$info->sendMessage(1, $c['clid'], "[b]Hasło[/b]: [color=orange][b]".$string."[/b][/color]");
									$info->sendMessage(1, $c['clid'], "Podane powyżej dane, możesz zmieniać do woli.");
									
									$mysqli->query("UPDATE `aj_channels` SET creator='".$c['client_database_id']."', lastactive='".time()."' WHERE id='".$sql2['id']."'");
									
									unset(self::$cuer_channels[$sql2['chid']]);
									array_push(self::$cuer_channels, $sql2['chid']);
									
									$info->clientMove($c['clid'], $sql2['chid']);
								}else{
									// robienie całkowicie nowego kanału
									// brak wolnych
									$ile = mysqli_fetch_array($mysqli->query("SELECT COUNT(*) AS ile FROM `aj_channels`"));
									$liczba = $ile['ile'] + 1;
									$string = bin2hex(random_bytes(5));
									$name = $liczba.'. Kanał '.$c['client_nickname'];
									$create = $info->channelCreate([
									'cpid' => 5,
									'channel_name' => $name,
									'channel_topic' => $name,
									'channel_description' => '[hr][center][size=13][b]» '.$liczba.'. Kanał '.$c['client_nickname'].' «[/b][/size][/center][center][color=#e7ac20] Strefa prywatna na AJONEG.EU! [/color][/center][hr]',
									'channel_password' => $string,
									'channel_maxclients' => -1,
									'channel_flag_pernament' => 1,
									]);
									
									$info->setClientChannelGroup(5, $create['data']['cid'], $c['client_database_id']);
									
									$info->sendMessage(1, $c['clid'], "[b]Gratulacje![/b] Stworzyliśmy dla Ciebię prywatny kanał.");
									$info->sendMessage(1, $c['clid'], "[b]Nazwa[/b]: ".$liczba .". Kanał ".$c['client_nickname']);
									$info->sendMessage(1, $c['clid'], "[b]Hasło[/b]: [color=orange][b]".$string."[/b][/color]");
									$info->sendMessage(1, $c['clid'], "Podane powyżej dane, możesz zmieniać do woli.");
									
									$mysqli->query("INSERT INTO `aj_channels` SET id='".$liczba."', creator='".$c['client_database_id']."', lastactive='".time()."', chid='".$create['data']['cid']."'");
									
									unset(self::$cuer_channels[$create['data']['cid']]);
									array_push(self::$cuer_channels, $create['data']['cid']);
									
									$info->clientMove($c['clid'], $create['data']['cid']);
								}
							}else{
								$info->clientKick($c['clid'], "channel", "Nie spełniasz wymagań, aby założyć kanał prywatny!");
							}
						}
					}else{
						// jesli mamy kanał
						$info->clientMove($c['clid'], $sql['chid']);
						$info->sendMessage(1, $c['clid'], "Zostałeś przeniesiony na swój kanał.");
					}
					// tylko jedna osoba na raz
					// TODO: ale czy to ma sens bo i tak zadziala w pentli
					return;
				}
			}
			
			
		}
	}
?>