<?php
	// funkcja (((
	class register
	{
		// tablice i dane		
		// == NEW project 2.0
		// AUTOMATYCZNE GRUPY
		public static $testarray = array(
			array(
			    "value" => true, // true/false => on/off
				"channel" => (53), // channel ID (only one parm. ID)
				"addgroups" => array(7), // add groups (122, 199, 222, ...)
				"blockgroups" => array(7, 193), // banned groups (11, 22, 78, ...)
			),
		);
		// ban users
		public static $block_users = array(
		"sadas", // neMRSHT+bXaw3jgnW7HUQpZPYjw=
		);
		public static $czbyl = array();
		public static $czyjuzma = array();
		
		// NEW FUNCTION
		public function start($info){
			$n = count(self::$testarray);
			for ($i=0;$i<$n; $i++){
				if(self::$testarray[$i]['value']==true){
					$chaninf = $info->getElement('data',$info->channelClientList(self::$testarray[$i]['channel'],"-groups -uid -times"));
					if(!empty($chaninf)){ // jesli nie jest empty
						foreach($chaninf as $channel){
							$exp = explode(',', $channel['client_servergroups']);
							foreach($exp as $cgid){
								if(in_array($cgid, self::$testarray[$i]['blockgroups'])){
									array_push(self::$czyjuzma[$channel['client_unique_identifier']] = 1);
								}
							}
							if(self::$czyjuzma[$channel['client_unique_identifier']] == 0){
								if(!in_array($channel['client_unique_identifier'], self::$block_users)){
									foreach(self::$testarray[$i]['addgroups'] as $add){
										$info->serverGroupAddClient($add, $channel['client_database_id']);
									}
								}else{ // jesli banned
									if(!in_array($channel['client_unique_identifier'], self::$czbyl) AND self::$czbyl[$channel['client_unique_identifier']] < $channel['client_lastconnected']){
										$info->sendMessage(1, $channel['clid'], "[b]Blokada[/b]: zostałeś/aś wykluczony/a!");
										$info->sendMessage(1, $channel['clid'], "Apeluj od nałożonej kary na forum [url=https://ajoneg.eu/ts/?community&tag=2-apelacje]ajoneg.eu[/url]");
										$info->sendMessage(1, $channel['clid'], "Nie proś w prywatnej wiadomości o sprawdzenie apelacji.");
										array_push(self::$czbyl[$channel['client_unique_identifier']] = $channel['client_lastconnected']);
									}
								}
							}
							array_push(self::$czyjuzma[$channel['client_unique_identifier']] = 0);
						}
					}
				}   
			}
		}
		
		// wpisane rangi, jakie blokuja nadawanie
		//public static $allow_groups = array(7, 193);
		// co ma nadac
		//public static $add_groups = array(7);
		
		// funkcja
		/* OLD OLD
		public function start($info){
			$chaninf = $info->getElement('data',$info->channelClientList(59,"-groups -uid"));
			if(!empty($chaninf)){ // jesli nie jest empty
				foreach($chaninf as $channel){
					$exp = explode(',', $channel['client_servergroups']);
					foreach($exp as $cgid){
						if(in_array($cgid, self::$allow_groups)){
							$czyjuzma = 1;
						}
					}
					if($czyjuzma == 0){
						if(!in_array($channel['client_unique_identifier'], self::$block_users)){
							foreach(self::$add_groups as $add){
								$info->serverGroupAddClient($add, $channel['client_database_id']);
							}
						}else{ // jesli banned
							if(!in_array($channel['client_unique_identifier'], self::$czbyl)){
								$info->sendMessage(1, $channel['clid'], "[b]Blokada[/b]: zostałeś/aś wykluczony/a!");
								$info->sendMessage(1, $channel['clid'], "Apeluj od nałożonej kary na forum [url=https://ajoneg.eu/ts/?community&tag=2-apelacje]ajoneg.eu[/url]");
								$info->sendMessage(1, $channel['clid'], "Nie proś w prywatnej wiadomości o sprawdzenie apelacji.");
								array_push(self::$czbyl, $channel['client_unique_identifier']);
							}
						}
					}
				}
			}
		}
		*/
	}
?>