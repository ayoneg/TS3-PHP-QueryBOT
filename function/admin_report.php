<?php
	// funkcja powiadamiajaca admina o prośbie rozpatrzenia raportów (rozmowa z adm. kanał)
	class admin_report
	{
		
		public static $admin_list = array(
			"value" => true,
			"channel" => (246), // 246
			"admin_group" => array(6, 9, 12, 36, 111), //6, 9, 12, 36, 111
			"raport_is" => false,
			"raport_time" => NULL,
			"raport_client" => NULL,
			"raport_count" => NULL,
		);
		
		public static $thisrank = NULL;
		
		public function start($info,$mysqli){
			// web insta settings
			$setings = mysqli_fetch_array($mysqli->query("SELECT * FROM `aj_tsconfig` WHERE id='1'"));
			if($setings['admin_report']==1){
				self::$admin_list["value"]=true;
			}else{
				self::$admin_list["value"]=false;
			}
			// web insta settings end
			if(self::$admin_list["value"]){
				
				
				
				// nowa funkcja admin report (po wejściu usera ==> wyslij pw (do adm) ==> daj znać ze wysłano)
				$chaninf = $info->getElement('data',$info->channelClientList(self::$admin_list['channel'],"-groups -uid -times"));
				if(!empty($chaninf)){ // jesli nie jest empty
					foreach($chaninf as $uss){
						$cldbid = $uss['client_database_id'];
						$clid = $uss['clid'];
						$uuid = $uss['client_unique_identifier'];
						$nick = $uss['client_nickname'];
						$timeadd = time()+300; // + 5 MIN
						$spr = mysqli_fetch_array($mysqli->query("SELECT COUNT(*) AS ile FROM `aj_ts3reports` WHERE cldbid='$cldbid' AND value='0' AND time>'".time()."'"));
						
						$exp = explode(',', $uss['client_servergroups']);
						self::$thisrank = false;
						foreach($exp as $cgid){
							if(in_array($cgid, self::$admin_list['admin_group'])){
								// is here
								self::$thisrank = true;
							}
						}
						
						if(!self::$thisrank){
							if($spr['ile']==0){ // AND $spr3['ile']==0
								// TODO: dodac integracje bazy adm, czy w ogole ktos online jest XD
								// jeśli nie ma
								$ch1 = $info->getElement('data',$info->channelClientList(543,""));
								$ch2 = $info->getElement('data',$info->channelClientList(544,""));
								if(!empty($ch1)){
									if(empty($ch2)){
										// join #2
										$info->clientMove($clid, 544);
										$info->sendMessage(1, $clid, "[b]Pomyślnie powiadomiono administracje, zaczekaj na odzew.[/b]");
										$mysqli->query("INSERT INTO `aj_ts3reports` SET cldbid='$cldbid', time='$timeadd', clid='$clid', uuid='$uuid', nick='$nick', channelid='544'");
									}else{
										// errr
										$info->sendMessage(1, $clid, "[b]Zaczekaj, aż zwolni się miejsce![/b]");
										$info->clientMove($clid, 1);
									}
								}else{
									// join #1
									$info->clientMove($clid, 543);
									$info->sendMessage(1, $clid, "[b]Pomyślnie powiadomiono administracje, zaczekaj na odzew.[/b]");
									$mysqli->query("INSERT INTO `aj_ts3reports` SET cldbid='$cldbid', time='$timeadd', clid='$clid', uuid='$uuid', nick='$nick', channelid='543'");
								}
								
							}
						}
						/*
						$spr5 = mysqli_fetch_array($mysqli->query("SELECT COUNT(*) AS ile FROM `aj_ts3reports` WHERE value='0' AND admcldbid='0'"));
						if($spr5['ile']>0){
							$info->sendMessage(1, $clid, "[b]Pomyślnie przyjęto zgłoszenie.[/b]");
							$mysqli->query("UPDATE `aj_ts3reports` SET admcldbid='$cldbid' WHERE value='0' AND display='1'");
						}
						*/
					}
				}
				
				// tutaj sprawdzamy w petli czy nie ma nowych raportów dla naszejadministracji :)))
				$spr2 = mysqli_fetch_array($mysqli->query("SELECT *, COUNT(*) AS ile  FROM `aj_ts3reports` WHERE value='0' AND display='0'"));
				if($spr2['ile']>0){
					$clients = $info->getElement('data',$info->clientList("-uid -groups"));
					foreach($clients as $uss){
						$n = count(self::$admin_list['admin_group']);
						for ($i=0;$i<$n; $i++){
							$exp = explode(',', $uss['client_servergroups']);
							if(in_array(self::$admin_list['admin_group'][$i], $exp)){
								$ch = $info->getElement('data',$info->channelInfo($spr2['channelid']));
								
								$info->sendMessage(1, $uss['clid'], " ");
								$info->sendMessage(1, $uss['clid'], "[b]Otrzymano nowe zgłoszenie![/b] [color=gray][ID: ".$spr2['id']."][/color]"); // [color=gray][ID: ".self::$admin_list['raport_count']."]
								$info->sendMessage(1, $uss['clid'], "[b]Aktywne do: [color=green]".date('Y-m-d H;i;s', $spr2['time'])."[/color][/b] [color=gray]|[/color] [b]Kanał[/b]: [color=orange][b]".$ch['channel_name']." [URL=channelid://".$spr2['channelid']."](wejdź, kliknij)[/URL][/b][/color]");
								$info->sendMessage(1, $uss['clid'], "[color=red]Zgłoszenia są rejestrowane, zgłoszenie automatycznie zostaje rozwiązane po dołączeniu administratora na kanał.[/color]");
								$info->sendMessage(1, $uss['clid'], " ");
								$info->sendMessage(1, $uss['clid'], "[b]Wysłano przez: [URL=client://".$spr2['clid']."/".$spr2['uuid']."]".$spr2['nick']."[/URL][/b]");
							}
						}
					}
					// dodaj nowe
					$mysqli->query("UPDATE `aj_ts3reports` SET display='1' WHERE id='".$spr2['id']."'");
				}
				
			}
		}
	}
?>