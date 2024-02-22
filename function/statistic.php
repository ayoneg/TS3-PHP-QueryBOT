<?php

	class statistic
	{
		//public static $timer_30 = 1798;
		//public static $timer_29 = 0;
		public static $thisrank = NULL;
		public static $zile = NULL;
		public static $blockgroups = array(13,74,205,204,139); //d
		public static $evgroups = array(220,221,235,236);
		public static $lasttimescan = NULL;


		public static $lastscan = 0; //time
		
		// TODO: dokoncz
		public function start($info,$mysqli)
		{
			$server = mysqli_fetch_array($mysqli->query("SELECT * FROM `aj_tsconfig` WHERE id='1'"));
			
			// EVENTOWY generator pogody
			/*
			$iesa = mysqli_fetch_array($mysqli->query("SELECT COUNT(*) AS ile FROM `aj_evpogo` WHERE time>='".time()."'"));
			if($iesa['ile'] < 16){
				
				$iesa2 = mysqli_fetch_array($mysqli->query("SELECT * FROM `aj_evpogo` ORDER BY id DESC"));
				if(!$iesa2['id']>0){
					$timeto = time() + rand(2000,7200);
					$time = time();
					$tempe = rand(-5,5);
				}else{
					$ntime = $iesa2['timeto'];
					$tempe = $iesa2['tempe'] + rand(-1,+1);
					$timeto = rand(2000,7200) + $ntime;
					$time = $ntime + 1;
				}	
				
				if($tempe >= -30 && $tempe < -15){
					$unrng = rand(1,100);
					if($unrng >= 95){
						$img='https://i.imgur.com/qUvNyUW.png';
						$name='ŚNIEŻYCA XP (x3)';
						$proc=rand(77,100);
						$boost=3;
						$ttncy=rand(395,555);
					}elseif($unrng < 95 && $unrng >= 66){
						$img='https://i.imgur.com/VbUzATc.png';
						$name='Intensywne opady śniegu';
						$proc=rand(80,100);
						$boost=rand(2,5);
						$ttncy=rand(700,1000);
					}elseif($unrng < 66 && $unrng >= 45){
						$img='https://i.imgur.com/FlzD6bQ.png';
						$name='Śnieg';
						$proc=rand(44,100);
						$ttncy=rand(284,570);
					}else{
						$img='https://i.imgur.com/yaEGwAU.png';
						$name='Pochmurnie';
						$proc=rand(77,100);
						$ttncy=420;
					}
				}elseif($tempe >= -15 && $tempe < 0){
					$unrng = rand(1,100);
					if($unrng >= 95){
						$img='https://i.imgur.com/qUvNyUW.png';
						$name='Śnieg z XP (x2)';
						$proc=rand(22,100);
						$boost=2;
						$ttncy=rand(400,550);
					}elseif($unrng < 95 && $unrng >= 86){
						$img='https://i.imgur.com/FlzD6bQ.png';
						$name='Śnieg';
						$proc=rand(44,100);
						$ttncy=rand(284,570);
					}elseif($unrng < 86 && $unrng >= 45){
						$img='https://i.imgur.com/yaEGwAU.png';
						$name='Pochmurnie';
						$proc=rand(77,100);
						$ttncy=420;
					}else{
						$img='https://i.imgur.com/9gZuUC8.png';
						$name='Słońce';
						$proc=rand(10,100);
						$ttncy=410;
					}
				}elseif($tempe >= 0 && $tempe < 5){
					$unrng = rand(1,10);
					if($unrng >= 8){
						$img='https://i.imgur.com/yaEGwAU.png';
						$name='Pochmurnie';
						$proc=rand(77,100);
						$ttncy=360;
					}elseif($unrng >= 4){
						$img='https://i.imgur.com/fOwspLr.png';
						$name='Duży deszcz';
						$proc=rand(67,100);
						$ttncy=550;
					}else{
						$img='https://i.imgur.com/s1Gerxv.png';
						$name='Pochmurnie ze słońcem';
						$proc=rand(55,100);
						$ttncy=300;
					}
				}elseif($tempe >= 5 && $tempe < 15){							
					$unrng = rand(1,10);
					if($unrng >= 8){
						$img='https://i.imgur.com/yaEGwAU.png';
						$name='Pochmurnie';
						$proc=rand(77,100);
						$ttncy=rand(357,478);
					}elseif($unrng >= 4){
						$img='https://i.imgur.com/B0jRsHP.png';
						$name='Deszcz i słońce';
						$proc=rand(22,100);
						$ttncy=rand(377,578);
					}else{
						$img='https://i.imgur.com/scPS6Z2.png';
						$name='Lekka burza';
						$proc=rand(22,77);
						$ttncy=500;
					}
				}elseif($tempe >= 15 && $tempe < 19){
					$unrng = rand(1,10);
					if($unrng >= 8){
						$img='https://i.imgur.com/B0jRsHP.png';
						$name='Deszcz i słońce';
						$proc=rand(22,100);
						$ttncy=400;
					}elseif($unrng >= 4){
						$img='https://i.imgur.com/fgHSjoM.png';
						$name='Burza';
						$proc=rand(80,100);
						$ttncy=555;
					}else{
						$img='https://i.imgur.com/scPS6Z2.png';
						$name='Lekka burza';
						$proc=rand(22,77);
						$ttncy=500;
					}
				}elseif($tempe >= 19 && $tempe < 23){
					$img='https://i.imgur.com/scPS6Z2.png';
					$name='Lekka burza';
					$proc=rand(22,77);
					$ttncy=600;
				}elseif($tempe >= 23 && $tempe < 25){
					$unrng = rand(1,10);
					if($unrng >= 8){
						$img='https://i.imgur.com/yaEGwAU.png';
						$name='Pochmurnie';
						$proc=rand(77,100);
						$ttncy=600;
					}elseif($unrng >= 4){
						$img='https://i.imgur.com/9gZuUC8.png';
						$name='Słońce';
						$proc=rand(10,100);
						$ttncy=310;
					}else{
						$img='https://i.imgur.com/scPS6Z2.png';
						$name='Lekka burza';
						$proc=rand(22,77);
						$ttncy=333;
					}
				}elseif($tempe >= 25 && $tempe < 29){
					$img='https://i.imgur.com/s1Gerxv.png';
					$name='Pochmurnie ze słońcem';
					$proc=rand(55,100);
					$ttncy=567;
				}elseif($tempe >= 29){
					$img='https://i.imgur.com/9gZuUC8.png';
					$name='Słońce';
					$proc=rand(10,100);
					$ttncy=675;
				}
				
				// litlle adder RNG
				$ttncy = $ttncy + rand(-15,25);
				$t=time();
				$desc33 = 'Generuje pogodę dla eventu';
				$mysqli->query("INSERT INTO `aj_log` SET desc_='$desc33', time='$t'");
				
				$mysqli->query("INSERT INTO `aj_evpogo` SET name='$name', img='$img', proc='$proc', time='$time', timeto='$timeto', boost='$boost', tempe='$tempe', ttncy='$ttncy';");
			}
			*/
			
			
			// WROKS AUTOMAT v1
			$task = $mysqli->query("SELECT * FROM `aj_works`");
			if(mysqli_num_rows($task) > 0) {
				while($tget = mysqli_fetch_assoc($task)){
					//$taskget = mysqli_fetch_array($task);
					if($tget['workid'] == "premiumRNG"){ // losowanie premki
						$t = time();
						$id = $tget['id'];
						if($tget['starttime'] <= $t){
							// wykonaj taska
							$clients = $info->getElement('data',$info->clientList("-uid -times -groups -ip"));
							$ile = count($clients);
							$rng = rand(1, $ile);
							foreach($clients as $user){
								self::$zile++;
								$type = $user['client_type'];
								if($type==0 AND $rng==self::$zile){
									// type == 0 fizyczny user
									// remove blocked ranks (bots,banned etc)
									$exp = explode(',', $user['client_servergroups']);
									self::$thisrank = false;
									foreach($exp as $cgid){
										if(in_array($cgid, self::$blockgroups)){
											// is here
											self::$thisrank = true;
										}
									}
									if(!self::$thisrank){
										$uuid = $user['client_unique_identifier'];
										$cldbid = $user['client_database_id'];
										$mysqli->query("DELETE FROM `aj_works` WHERE id='$id'");
										
										$rr = rand(1,77);
										if($rr>64){
											$iledni = 1 * rand(4,7);
										}elseif($rr<=64 && $rr>50){
											$iledni = 1 * rand(2,4);
										}else{
											$iledni = 1;
										}
										
										$desc33 = 'Wykonano losowanie konta premium ('.$iledni.' dni) dla '.$uuid.' ['.$cldbid.']';
										$mysqli->query("INSERT INTO `aj_log` SET desc_='$desc33', time='$t'");
										
										// sprawdzamy czy nie ma juz premki
										$premium = mysqli_fetch_array($mysqli->query("SELECT * FROM `aj_users` WHERE cldbid='$cldbid'"));
										if($premium['premium'] >= time()){
											$tt = 3600*24*$iledni;
											$mysqli->query("UPDATE `aj_users` SET premium=premium+'$tt' WHERE cldbid='$cldbid'");
											$info->sendMessage(1, $user['clid'], "[b]Premium[/b]: Twój pakiet premium, został przedłużony!");
										}else{
											$mysqli->query("INSERT INTO `aj_groups` SET cldbid='$cldbid', groups='234'");
											
											$tt = time()+3600*24*$iledni;
											$mysqli->query("UPDATE `aj_users` SET premium='$tt' WHERE cldbid='$cldbid'");
											$info->sendMessage(1, $user['clid'], "[b]Losowanie[/b]: Gratulacje, system wylosował nagrodę dla Ciebie!");
											$info->sendMessage(1, $user['clid'], " ");
											$info->sendMessage(1, $user['clid'], "[b]Premium[/b]: Twój pakiet premium, został aktywowany!");
											$info->sendMessage(1, $user['clid'], "[b]Premium[/b]: Ustawienia ikonek oraz rang [url=https://ajoneg.eu/ts/?rangits]kliknij tutaj[/url]");
											$info->sendMessage(1, $user['clid'], "[b]Premium[/b]: Możesz już teraz dołączyć do zabawy z premium! Wybierz grupę imprezową, pod poczekalnią i zbieraj punkty! [url=https://ajoneg.eu/ts/event/]ranking imprezy TOP[/url]");
										}
									}
								}
							}
							self::$zile = 0;
						}
					}

					if($tget['workid'] == "clkick"){
						$t = time();
						$id = $tget['id'];
						if($tget['starttime'] <= $t){
							$kickmess = $tget['workname'];
							$liczmess = strlen($kickmess);
							if($liczmess>0){$kickmess = $kickmess;}else{$kickmess = "Wyrzucony przez konsole AJONEG.EU";}
							$cldbid = $tget['workclid'];
							if($cldbid>0){
								// nowe
								$sprud = mysqli_fetch_array($mysqli->query("SELECT clid, name FROM `aj_users` WHERE cldbid='$cldbid'"));
								if(!empty($sprud)){
								
									$info->clientKick($sprud['clid'], "server", $kickmess);

									$desc33 = '[ADM:sys] Wyrzucono z serwera użytkownika '.$sprud['name'].' ('.$cldbid.') / '.$kickmess;
									$mysqli->query("INSERT INTO `aj_log` SET desc_='$desc33', time='$t'");
								}else{
									//error
									$desc33 = '[ADM:sys] Błąd, podane cldbid jest równe 0!';
									$mysqli->query("INSERT INTO `aj_log` SET desc_='$desc33', time='$t'");
								}
							}else{
								$desc33 = '[ADM:sys] Błąd, podane clid jest równe 0!';
								$mysqli->query("INSERT INTO `aj_log` SET desc_='$desc33', time='$t'");
							}
							$mysqli->query("DELETE FROM `aj_works` WHERE id='$id'");
						}
					}

					if($tget['workid'] == "clpoke"){
						$t = time();
						$id = $tget['id'];
						if($tget['starttime'] <= $t){
							$pokemess = $tget['workname'];
							$liczmess = strlen($pokemess);
							if($liczmess>0){$pokemess = $pokemess;}else{$pokemess = "Zaczepka przez konsole AJONEG.EU";}
							$cldbid = $tget['workclid'];
							if($cldbid>0){
								// nowe
								$sprud = mysqli_fetch_array($mysqli->query("SELECT clid, name FROM `aj_users` WHERE cldbid='$cldbid'"));
								if(!empty($sprud)){
								
									$info->clientPoke($sprud['clid'], $pokemess);

									$desc33 = '[ADM:sys] Zaczepiono użytkownika '.$sprud['name'].' ('.$cldbid.') / '.$pokemess;
									$mysqli->query("INSERT INTO `aj_log` SET desc_='$desc33', time='$t'");
								}else{
									//error
									$desc33 = '[ADM:sys] Błąd, podane cldbid jest równe 0!';
									$mysqli->query("INSERT INTO `aj_log` SET desc_='$desc33', time='$t'");
								}
							}else{
								$desc33 = '[ADM:sys] Błąd, podane clid jest równe 0!';
								$mysqli->query("INSERT INTO `aj_log` SET desc_='$desc33', time='$t'");
							}
							$mysqli->query("DELETE FROM `aj_works` WHERE id='$id'");
						}
					}
					
					if($tget['workid'] == "clmess"){
						$t = time();
						$id = $tget['id'];
						if($tget['starttime'] <= $t){
							$pokemess = $tget['workname'];
							$liczmess = strlen($pokemess);
							if($liczmess>0){$pokemess = $pokemess;}else{$liczmess = 0;}
							$cldbid = $tget['workclid'];
							if($cldbid>0 AND $liczmess!=0){
								// nowe
								$sprud = mysqli_fetch_array($mysqli->query("SELECT clid, name FROM `aj_users` WHERE cldbid='$cldbid'"));
								if(!empty($sprud)){
								
									$info->sendMessage(1, $sprud['clid'], "[b][color=orange]WIADOMOŚĆ OD KONSOLI AJONEG.EU[/color][/b]");
									$info->sendMessage(1, $sprud['clid'], " ");
									$info->sendMessage(1, $sprud['clid'], $pokemess);

									$desc33 = '[ADM:sys] Wysłano prywatną wiadmość do użytkownika '.$sprud['name'].' ('.$cldbid.')';
									$mysqli->query("INSERT INTO `aj_log` SET desc_='$desc33', time='$t'");
								}else{
									//error
									$desc33 = '[ADM:sys] Błąd, podane cldbid jest równe 0!';
									$mysqli->query("INSERT INTO `aj_log` SET desc_='$desc33', time='$t'");
								}
							}else{
								$desc33 = '[ADM:sys] Błąd, podane clid jest równe 0 i/lub wiadomość jest pusta!';
								$mysqli->query("INSERT INTO `aj_log` SET desc_='$desc33', time='$t'");
							}
							$mysqli->query("DELETE FROM `aj_works` WHERE id='$id'");
						}
					}
					/*
					if($tget['workid'] == "casesRNG"){ // losowanie premki
						$t = time();
						$id = $tget['id'];
						if($tget['starttime'] <= $t){
							// wykonaj taska
							$clients = $info->getElement('data',$info->clientList("-uid -times -groups -ip"));
							$ile = count($clients);
							$rng = rand(1, $ile);
							foreach($clients as $user){
								self::$zile++;
								$type = $user['client_type'];
								if($type==0 AND $rng==self::$zile){
									// type == 0 fizyczny user
									// remove blocked ranks (bots,banned etc)
									$exp = explode(',', $user['client_servergroups']);
									self::$thisrank = false;
									foreach($exp as $cgid){
										if(in_array($cgid, self::$blockgroups)){
											// is here
											self::$thisrank = true;
										}
									}
									if(!self::$thisrank){
										$cldbid = $user['client_database_id'];
										$ustest = mysqli_fetch_array($mysqli->query("SELECT * FROM `aj_events` WHERE userid='$cldbid'"));
										if($ustest['points']>=250){
											$uuid = $user['client_unique_identifier'];
											$mysqli->query("DELETE FROM `aj_works` WHERE id='$id'");
											
											$rr = rand(1,77);
											if($rr>64){
												$ilecase = 1 * rand(4,7);
											}elseif($rr<=64 && $rr>50){
												$ilecase = 1 * rand(2,4);
											}else{
												$ilecase = 1;
											}
											
											$desc33 = 'Wykonano losowanie pojemników ('.$ilecase.' szt) dla '.$uuid.' ['.$cldbid.']';
											$mysqli->query("INSERT INTO `aj_log` SET desc_='$desc33', time='$t'");
											
											$mysqli->query("UPDATE `aj_events` SET cases=cases+'$ilecase' WHERE userid='$cldbid'");

											$info->sendMessage(1, $user['clid'], "[b]Losowanie[/b]: Gratulacje, system wylosował nagrodę dla Ciebie!");
											$info->sendMessage(1, $user['clid'], " ");
											$info->sendMessage(1, $user['clid'], "[b]Pojemniki[/b]: Pojemniki czekają aż je otworzysz!");
											$info->sendMessage(1, $user['clid'], "[b]Pojemniki[/b]: Tutaj możesz je otwierać [url=https://ajoneg.eu/ts/event?pojemniki]kliknij tutaj[/url]");
										}
									}
								}
							}
							self::$zile = 0;
						}
					}
					
					CASE RNG END */ 
				}
			}

			$clients = $info->getElement('data',$info->clientList("-uid -times -groups -ip"));
			foreach($clients as $user){
				// DANE
				$type = $user['client_type'];
				// ZADANIA
				if($type==0){
					// DANE v2
					$cldbid = $user['client_database_id'];
					$clid = $user['clid'];
					$name = $user['client_nickname'];
					$uuid = $user['client_unique_identifier'];
					$lastseen = time()+1; // +1 sek bo delay pętli 
					$srvgroup = $user['client_servergroups'];
					$idletime = $user['client_idle_time']/1000;
					$firstcon = $user['client_created'];
					$lastcon = $user['client_lastconnected'];
					
					// welcome message
					/// ?? WHERE

					// SYSTEM BLOKAD I KAR (beta 18.03.2023)
					$us = mysqli_fetch_array($mysqli->query("SELECT * FROM `aj_users` WHERE cldbid='$cldbid'"));
					if($us['cldbid'] > 0){
						///
					}
					
					
					// test premium 2.0 (id 234) (działa)
					$exp = explode(',', $srvgroup);
					foreach($exp as $cgid){
						if($cgid == 234){
							// jest premium (xd)
							$premium = mysqli_fetch_array($mysqli->query("SELECT * FROM `aj_users` WHERE cldbid='$cldbid'"));
							if($premium['premium'] >= time()){
								// ok mamy premke w bazie
								// TODO: dopisac bonusy premki exp etc.
								if($lastcon>=time()){
									$czas = date('j F Y H : i', $premium['premium']);
									$czas = str_replace('January', 'Stycznia', $czas);
									$czas = str_replace('February', 'Lutego', $czas);
									$czas = str_replace('March', 'Marca', $czas);
									$czas = str_replace('April', 'Kwietnia', $czas);
									$czas = str_replace('May', 'Maja', $czas);
									$czas = str_replace('June', 'Czerwca', $czas);
									$czas = str_replace('July', 'Lipca', $czas);
									$czas = str_replace('August', 'Sierpnia', $czas);
									$czas = str_replace('September', 'Września', $czas);
									$czas = str_replace('October', 'Października', $czas);
									$czas = str_replace('November', 'Listopada', $czas);
									$czas = str_replace('December', 'Grudnia', $czas);
									
									$info->sendMessage(1, $user['clid'], "[b]Premium[/b]: Witamy ponownie!");
									$info->sendMessage(1, $user['clid'], "[b]Premium[/b]: Twój pakiet premium kończy się [b]".$czas."[/b]");
								}
								
							}else{
								// premium ts =/= baza
								// usuwamy o ile ja jeszcze posiada
								//$info->getElement('data',$info->serverGroupDeleteClient(234, $cldbid));
								$mysqli->query("INSERT INTO `aj_groups` SET cldbid='$cldbid', groups='234'");
								$info->sendMessage(1, $user['clid'], "[b]Premium[/b]: Twój pakiet premium, właśnie się skończył :(");
								
								$desc = '[PREMIUM] Pakiet premium, właśnie się skończył dla '.$user['client_database_id'];
								$time = time();
								$mysqli->query("INSERT INTO `aj_log` SET time='$time', desc_='$desc'");
							}
						}
						
						
						/*
						if(in_array($cgid, self::$evgroups)){
							$evtime = mysqli_fetch_array($mysqli->query("SELECT * FROM `aj_events` WHERE userid='$cldbid' AND eventid='1' ORDER BY id DESC"));
							if($evtime['time'] <= time()){
								$testtime = time()-3600*24;
								$antyCHEAT = mysqli_fetch_array($mysqli->query("SELECT SUM(ilosc) AS ilejuzma FROM `aj_eventshis` WHERE user='$cldbid' AND time>='$testtime'"));
								if($antyCHEAT['ilejuzma']>=280){$values = false;}else{$values = true;}
								//$values = true;
								if($evtime['value']==1){$values = false;}
								if($values){
									// EVENT SWIATECZNY
									$testtime = date('H:i', time());
									$fulltime = time() + ((300*2)*6)*24; // 24 h
									$t = time();
									if( ( $testtime >= "20:30" && $testtime <= "21:30" ) ){
										if($idletime >= 460){$boost=0;}else{
											$boost=1;
											$boostuser = $evtime['boost'];
											if($boostuser > 0){
												// dodatkowe premie
												$boost = $boost + $boostuser;
											}
										}
									}else{$boost=0;}
									
									// pojemniki
									// procentowo
									if($testtime >= "8:00" && $testtime <= "20:29"){
										$szanse = 10; // 1% szans
									}elseif($testtime >= "20:30" && $testtime <= "21:30"){
										$szanse = 250; // 25% szans
									}else{
										$szanse = 1; // 0,1% szans
									}
									
									
									// sprawdzanie idle
									if($idletime <= rand(300,460)){ // od 5 min do 7:30
										$rng_case = rand(0,1000); // 15 % szans
										if($rng_case >= 0 && $rng_case < $szanse && $evtime['points']>=5){
											if($evtime['cases']>0){$addtext=', a tyle szt. [b]('.$evtime['cases'].')[/b] czeka aż je otworzysz';}else{$addtext='';}
											$matm = $szanse / 10; // na %
											$matm = $matm."%";
											if($evtime['vmta']==1){
												$mysqli->query("UPDATE `aj_events` SET cases=cases+'1', vmta='0' WHERE userid='$cldbid'");
												
												$desc = '[POJEMNIKI] wylosowano 1 szt. pojemników dla '.$user['client_database_id'].' ('.$matm.')';
												$time = time();
												$mysqli->query("INSERT INTO `aj_log` SET time='$time', desc_='$desc'");
												
												if($evtime['dropinfo']==1){
													$info->sendMessage(1, $user['clid'], "[b]Pojemniki[/b]:");
													$info->sendMessage(1, $user['clid'], "Otrzymałeś właśnie 1 pojemnik imprezowy".$addtext."!");
													$info->sendMessage(1, $user['clid'], "Aby je otworzyć i odebrać super nagrody, [url=https://ajoneg.eu/ts/event/?pojemniki]kliknij w ten link[/url].");
													$info->sendMessage(1, $user['clid'], "Jeśli nie chcesz widzieć tych powiadomień, [url=https://ajoneg.eu/ts/?pojinfo]kliknij w ten link[/url].");
												}
											}else{
												$ilesk = rand(3,9);
												$mysqli->query("UPDATE `aj_events` SET cases=cases+'$ilesk', vmta='1' WHERE userid='$cldbid'");
												
												$desc = '[POJEMNIKI] wylosowano '.$ilesk.' szt. pojemników dla '.$user['client_database_id'].' ('.$matm.')';
												$time = time();
												$mysqli->query("INSERT INTO `aj_log` SET time='$time', desc_='$desc'");
												
												if($evtime['dropinfo']==1){
													$info->sendMessage(1, $user['clid'], "[b]Pojemniki[/b]:");
													$info->sendMessage(1, $user['clid'], "Otrzymałeś właśnie ".$ilesk." szt. pojemników imprezowych".$addtext."!");
													$info->sendMessage(1, $user['clid'], "Aby je otworzyć i odebrać super nagrody, [url=https://ajoneg.eu/ts/event/?pojemniki]kliknij w ten link[/url].");
													$info->sendMessage(1, $user['clid'], "Jeśli nie chcesz widzieć tych powiadomień, [url=https://ajoneg.eu/ts/?pojinfo]kliknij w ten link[/url].");
												}
											}
										}
									}
									
									// pogodowe premie i niespodzianki
									$pogoda = mysqli_fetch_array($mysqli->query("SELECT * FROM `aj_evpogo` WHERE timeto>='".time()."' ORDER BY time ASC LIMIT 1"));
									if($pogoda['boost']>0){
										$wtm = $pogoda['ttncy'] + $pogoda['tempe'];
										//if($boost>0){$boost = $boost;}else{$boost = 1;}
										$boost = ($boost + $pogoda['boost']);
									}else{
										$wtm = $pogoda['ttncy'] + $pogoda['tempe'];
									}
									
									
									//anty afk
									if($idletime >= 460){
										$topic='AFK sys. is enabled | TTNCY ('.$wtm.') => (900) / BOOST ('.$boost.') => (0)';$boost=0;$wtm=900;
									}else{
										//$wtm=$wtm;
										$topic='AFK sys. is disabled';
										$t=time();
										$tempttncy = $evtime['tmttncy'];
										$tempboost = $evtime['tmboost'];
										if($tempttncy>$t){
											$wtm = ( $wtm / 2 );
											$topic = $topic." + TTNCY (".$wtm.")";
										}
										if($tempboost>$t){
											$boost = ( $boost + 1 );
											$topic = $topic." + BOOST (".$boost.")";
										}
										if(!$tempboost && !$tempttncy){
											
										}
									}
									
									if($cgid == 220){
										//1
										$czas = time()+$wtm;
										if($evtime['userid']!=0){
											$points = 1 + $boost;
											$mysqli->query("UPDATE `aj_events` SET points=points+$points, time='$czas', rankid='$cgid' WHERE userid='$cldbid'");
										}else{
											$mysqli->query("INSERT INTO `aj_events` SET points=1, eventid='1', userid='$cldbid', rankid='$cgid', time='$czas'");
										}
										$mysqli->query("INSERT INTO `aj_eventshis` SET time='$t', ilosc='".$points."', grupa='$cgid', user='$cldbid', topic='$topic'");
									}elseif($cgid == 221){
										//2
										$czas = time()+$wtm;
										if($evtime['userid']!=0){
											$points = 1 + $boost;
											$mysqli->query("UPDATE `aj_events` SET points=points+$points, time='$czas', rankid='$cgid' WHERE userid='$cldbid'");
										}else{
											$mysqli->query("INSERT INTO `aj_events` SET points=1, eventid='1', userid='$cldbid', rankid='$cgid', time='$czas'");
										}
										$mysqli->query("INSERT INTO `aj_eventshis` SET time='$t', ilosc='".$points."', grupa='$cgid', user='$cldbid', topic='$topic'");
									}elseif($cgid == 235){
										//3
										$czas = time()+$wtm;
										if($evtime['userid']!=0){
											$points = 1 + $boost;
											$mysqli->query("UPDATE `aj_events` SET points=points+$points, time='$czas', rankid='$cgid' WHERE userid='$cldbid'");
										}else{
											$mysqli->query("INSERT INTO `aj_events` SET points=1, eventid='1', userid='$cldbid', rankid='$cgid', time='$czas'");
										}
										$mysqli->query("INSERT INTO `aj_eventshis` SET time='$t', ilosc='".$points."', grupa='$cgid', user='$cldbid', topic='$topic'");
									}elseif($cgid == 236){
										//3
										$czas = time()+$wtm;
										if($evtime['userid']!=0){
											$points = 1 + $boost;
											$mysqli->query("UPDATE `aj_events` SET points=points+$points, time='$czas', rankid='$cgid' WHERE userid='$cldbid'");
										}else{
											$mysqli->query("INSERT INTO `aj_events` SET points=1, eventid='1', userid='$cldbid', rankid='$cgid', time='$czas'");
										}
										$mysqli->query("INSERT INTO `aj_eventshis` SET time='$t', ilosc='".$points."', grupa='$cgid', user='$cldbid', topic='$topic'");
										
									}
								}
							}
						}
						*/
					}
					
					/*
					if($cldbid==3){
						$test = $info->getElement('data',$info->logView(1));
						foreach($test as $t){
							//if(md5($t['1']) != self::$remember){
								$info->sendMessage(1, 57015, $t['l']);
								//self::$remember = 0;
							//}
						}
					}
					*/

					// nadawanie/zabieranie grup servera automat (działa)
					$groupslist = $mysqli->query("SELECT * FROM `aj_groups` WHERE cldbid='$cldbid'");
					if(mysqli_num_rows($groupslist) > 0) {
						while($grp = mysqli_fetch_assoc($groupslist)){ 
							$ex = explode(',', $grp['groups']);
							foreach($ex as $cgids){
								// lista grup do nadania
								if(in_array($cgids, $exp)){
									//jesli juz mamy ta grupe (remove)
									$info->getElement('data',$info->serverGroupDeleteClient($cgids, $cldbid));
									$desc = '[RANK:sys] remove group ('.$cgids.') for cldbid '.$cldbid;
									$time = time();
									$mysqli->query("INSERT INTO `aj_log` SET time='$time', desc_='$desc'");
								}else{
									//jesli jej nie mamy (add)
									$info->serverGroupAddClient($cgids, $cldbid);
									$desc = '[RANK:sys] add group ('.$cgids.') for cldbid '.$cldbid;
									$time = time();
									$mysqli->query("INSERT INTO `aj_log` SET time='$time', desc_='$desc'");
								}
							}
							$mysqli->query("DELETE FROM `aj_groups` WHERE cldbid='$cldbid'");
						}
					}
					
					$sprawdz = mysqli_fetch_array($mysqli->query("SELECT COUNT(*) as ilosc FROM `aj_users` WHERE cldbid='$cldbid'"));
					if($sprawdz['ilosc']==0){
						// jesli goscia nie ma dodaje do bazy heheheeheheheheh
						$mysqli->query("INSERT INTO `aj_users` SET clid='$clid', cldbid='$cldbid', uuid='$uuid', name='$name', lastseen='$lastseen', firstcon='$firstcon', srvgroup='$srvgroup';");
					}elseif($sprawdz['ilosc']>0){
						// tutaj update danych
						$us = $info->getElement('data',$info->clientInfo($clid));
						$nowonlinetime = $us['connection_connected_time'];
						if($idletime >= 900){ $sql = "total_online=total_online+'1', total_afk=total_afk+'1'"; }else{ $sql = "total_online=total_online+'1'" ;}
						
						// STATISTIC FROM 7, 30 or all time DAYS
						if($server['lastscan'] <= time()){
							$count = mysqli_fetch_array($mysqli->query("SELECT COUNT(*) as ilosc FROM `aj_snapshot` WHERE cldbid='$cldbid' ORDER BY id DESC"));
							$count = $count['ilosc']+1; // zawsze o jeden wiecej
							//$oldcount = $count['ilosc']; // ostatni rekord
							
							$spr = mysqli_fetch_array($mysqli->query("SELECT * FROM `aj_users` WHERE cldbid='$cldbid'"));
							$total_online = $spr['total_online'];
							$total_afk = $spr['total_afk'];
							
							$spr1 = mysqli_fetch_array($mysqli->query("SELECT * FROM `aj_snapshot` WHERE cldbid='$cldbid' ORDER BY id DESC"));
							if($spr1){
								// dane
								$allonline = $spr1['allonline'];
								$allafk = $spr1['allafk'];
								// obliczenia różnicy
								$licz_online = $total_online - $allonline; // ile przybyło od ostatniego [ONLINE]
								$licz_afk = $total_afk - $allafk; // ile przybyło od ostatniego [AFK]
								// zapis do db
								$mysqli->query("INSERT INTO `aj_usersSnapshot` SET cldbid='$cldbid', onlinetime='$licz_online', afktime='$licz_afk', shottime='".time()."';");
								
								$time_7days = time()-604800; // 7d
								//$time_30days = time()-(3600*24*30); // 30d
								$spr2 = mysqli_fetch_array($mysqli->query("SELECT SUM(onlinetime) AS online, SUM(afktime) AS afk FROM `aj_usersSnapshot` WHERE cldbid='$cldbid' AND shottime>='$time_7days'"));
								if($spr2){
									$alltime_7d = $spr2['online'];
									$afktime_7d = $spr2['afk'];
									$mysqli->query("UPDATE `aj_users` SET alltime_7d='$alltime_7d', afktime_7d='$afktime_7d' WHERE cldbid='$cldbid';");
								}
							}
							
							$mysqli->query("INSERT INTO `aj_snapshot` SET cc='$count', cldbid='$cldbid', allonline='$total_online', allafk='$total_afk';");

						}
						
						// raz na 1 sekunde
						$mysqli->query("UPDATE `aj_users` SET clid='$clid', lastseen='$lastseen', ".$sql.", name='$name', srvgroup='$srvgroup', nowonlinetime='$nowonlinetime' WHERE cldbid='$cldbid';");
						
						// IP COM raz na sekunde O ile jest inne lub nowe
						$ip = $user['connection_client_ip'];
						$haship = md5($ip);
						$sp = mysqli_fetch_array($mysqli->query("SELECT haship FROM `aj_users` WHERE cldbid='".$user['client_database_id']."'"));
						if($sp['haship']!=$haship){
							$mysqli->query("UPDATE `aj_users` SET haship='$haship' WHERE cldbid='$cldbid';");
							$sp2 = mysqli_fetch_array($mysqli->query("SELECT COUNT(*) AS jest FROM `aj_usersIP` WHERE hashIP='$haship'"));
							if($sp2['jest']==0){
								$mysqli->query("INSERT INTO `aj_usersIP` SET ip='$ip', hashIP='$haship', cldbid='$cldbid';");
							}
						}
					}
				}
			}
			// koniec
			if($server['lastscan'] <= time()){
				$czas = time() + 1800;
				$mysqli->query("UPDATE `aj_tsconfig` SET lastscan='$czas' WHERE id='1';");
			}

		}
	}

?>