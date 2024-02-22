<?php
	// funkcja ...	
	class recordonline
	{
		public static $ct = 0;
		public $second = 15;
		
		public function start($info){
			//$etc = $info->getElement('data',$info->clientGetNameFromUid("neMRSHT+bXaw3jgnW7HUQpZPYjw="));
			//$etc = $info->clientGetIds(45840);
			//$info->sendMessage(1, 45840, "Name: ".$etc['name']." | UID: ".$etc['cldbid']);
			if(self::$ct >= $this->second){
				$sif = $info->getElement('data',$info->serverInfo());
				$count = $sif['virtualserver_clientsonline'] - $sif['virtualserver_queryclientsonline'];
				
				require('dbcon.php');
				$sql = mysqli_fetch_array($mysqli->query("SELECT record FROM `aj_tsconfig` WHERE id='1';"));
				if($sql['record'] < $count){
					$idch = 52;
					$czs = time();
					$data = date('Y-m-d H:i:s', $czs);
					$info->channelEdit($idch, ['channel_name' => '[cspacer1]REKORD ONLINE : '.$count,
					'channel_description' => '[hr][center][size=13][b]» REKORD ONLINE «[/b][/size][/center][center][color=#e7ac20]'.$count.' Online ustalony [b]'.$data.'[/b][/color][/center][hr]']);
					//$info->channelEdit($idch, ['channel_description' => '[hr][center][size=13][b]» REKORD ONLINE «[/b][/size][/center][center][color=#e7ac20]'.$count.' Online ustalony [b]'.$data.'[/b][/color][/center][hr]']);
					$mysqli->query("UPDATE aj_tsconfig SET record='$count', record_time='$czs' WHERE id='1';");
					self::$ct = 0;
				}
			}else{
				self::$ct++;
			}		
		}
	}
?>