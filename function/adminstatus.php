<?php
	class adminstatus
	{
		
		public static $admin_groups = array(6, 9, 12, 36, 111);
		public static $print_channel = 49;
		public static $desc = "";
		public static $count = 0;
		public static $cli_count = 0;
		
		function start($info){
			$server = $info->getElement('data',$info->serverInfo());
			$online = $server['virtualserver_clientsonline'] - $server['virtualserver_queryclientsonline'];
			if(self::$cli_count != $online){
				$clients = $info->getElement('data',$info->clientList("-uid -groups"));
				if(!empty($clients)){
					self::$count=0;
					self::$desc="";
					foreach($clients as $user){
						$n = count(self::$admin_groups);
						for ($i=0;$i<$n; $i++){
							$exp = explode(',', $user['client_servergroups']);
							if(in_array(self::$admin_groups[$i], $exp)){
								$nick = str_replace(' ', '%20', $user['client_nickname']);
								self::$desc = "[URL=client://".$user['clid']."/".$user['client_unique_identifier']."~".$nick."]".$user['client_nickname']."[/URL], ".self::$desc;
								self::$count++;
							}
						}
					}
					
					if(self::$count > 0){
						$info->channelEdit(self::$print_channel, [
						'channel_name' => '╔-● Lista administracji (online)', 
						'channel_topic' => 'Ostatni skan dokonano: '.date('Y-m-d H:i:s', time()),
						'channel_description' => '[hr][center][size=13][b]» ADMINISTRACJA «[/b][/size][/center][center][color=#e7ac20]Lista dostępnych członków administracji TS3.[/color][/center][hr][size=13]
'.self::$desc.' 

Razem: [b]'.self::$count.'[/b], status: [b][color=green] online [/color]

[/size][right]» [b]Ajon[color=#e7ac20]EG[/color][/b] | Publiczny @ TS3[/right]',
						]);
					}elseif(self::$count == 0){
						$info->channelEdit(self::$print_channel, [
						'channel_name' => '╔-● Lista administracji (offline)', 
						'channel_topic' => 'Ostatni skan dokonano: '.date('Y-m-d H:i:s', time()),
						'channel_description' => '[hr][center][size=13][b]» ADMINISTRACJA «[/b][/size][/center][center][color=#e7ac20]Lista dostępnych członków administracji TS3.[/color][/center][hr][size=13]
brak... 

Razem: [b]'.self::$count.'[/b], status: [b][color=red] offline [/color]

[/size][right]» [b]Ajon[color=#e7ac20]EG[/color][/b] | Publiczny @ TS3[/right]',
						]);
					}
				}
				self::$cli_count = $online;
			}
		}
		
	}
?>