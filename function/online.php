<?php
	// funkcja zliczająca ilość online	
	class online
	{
		public static $cnt = 0;
		
		public function start($info,$mysqli){
			$serverInfo = $info->getElement('data',$info->serverInfo());
			$count = $serverInfo['virtualserver_clientsonline'] - $serverInfo['virtualserver_queryclientsonline'];
			if(self::$cnt != $count){
				$info->channelEdit(51, ['channel_name' => '[cspacer]ONLINE : '.$count]);
				self::$cnt = $count;
				$mysqli->query("UPDATE aj_tsconfig SET online='$count' WHERE id='1';");
			}
		}
	}
?>