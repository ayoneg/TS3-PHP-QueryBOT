<?php
	class twitchstatus
	{
		public $clientid = "i9pif5imtc0dms7foy4o4alry87ptw";
		public $secret = "8xnvqcmsakxcqdsnb0jsdvg2hg28r0";
		public $user = "neeqsaiyan";
		
		private $token = NULL;
		private $users = NULL;
		private $follows = NULL;
		private $emot = NULL;
		private $streams = NULL;
		
		private function setToken(): void
		{
			$ch = curl_init();
				curl_setopt_array($ch, [
				CURLOPT_URL => "https://id.twitch.tv/oauth2/token?client_id=".$this->clientid."&client_secret=".$this->secret."&grant_type=client_credentials",
				CURLOPT_POST => 1,
				CURLOPT_RETURNTRANSFER => true,
			]);
			$token = json_decode(curl_exec($ch), true);
			if(!$token['access_token']){
				// tu log że ni ma tokena
			}else{
				$this->token = $token['access_token'];
			}
		}
		
		private function setUsers(string $name): void
		{
			$ch = curl_init();
				curl_setopt_array($ch, [
					CURLOPT_URL => "https://api.twitch.tv/helix/users?login={$name}",
					CURLOPT_RETURNTRANSFER => true,
					CURLOPT_HTTPHEADER => [
						'Authorization: Bearer '.$this->token,
						'Client-ID: '.$this->clientid,
						],
				]);
			$this->users = json_decode(curl_exec($ch));
		}
		
		private function setFollows(): void
		{
			$ch = curl_init();
				curl_setopt_array($ch, [
					CURLOPT_URL => "https://api.twitch.tv/helix/users/follows?to_id={$this->users->data[0]->id}&first=1",
					CURLOPT_RETURNTRANSFER => true,
					CURLOPT_HTTPHEADER => [
						'Authorization: Bearer '.$this->token,
						'Client-ID: '.$this->clientid,
					],
				]);
			$this->follows = json_decode(curl_exec($ch));
		}
		
		private function setStreams(string $name): void
		{
			$ch = curl_init();
			curl_setopt_array($ch, [
				CURLOPT_URL => "https://api.twitch.tv/helix/streams?user_login={$name}",
				CURLOPT_RETURNTRANSFER => true,
				CURLOPT_HTTPHEADER => [
					'Authorization: Bearer '.$this->token,
					'Client-ID: '.$this->clientid,
				],
			]);
			$this->streams = json_decode(curl_exec($ch));
		}
		
		public static $times = 25;
		public static $times_s = 0;
		public static $lastscan = 0;
		public static $streamOff = false;
		public static $streamOn = false;
		
		public function start($info){
			if(self::$times>=30){
				$this->setToken();
				$this->setUsers($this->user);
				$this->setStreams($this->user);
				$this->setFollows();
				
				if(!empty($this->streams->data[0])){
					//$info->sendMessage(1, 59831, $this->streams->data[0]->viewer_count);
					$user_follow = $this->follows->total;
					/*
					$stream_host = $this->streams->data[0]->user_name;
					$stream_game = $this->streams->data[0]->game_name;
					$stream_title = $this->streams->data[0]->title;
					$stream_views = $this->streams->data[0]->viewer_count;
					$stream_image = $this->streams->data[0]->thumbnail_url;
					$user_img = $this->users->data[0]->profile_image_url;
					$better_cat = str_replace(' ', '%20', $stream_game);
					
					$stream_image = str_replace('{width}', '250', $stream_image);
					$stream_image = str_replace('{height}', '150', $stream_image);
					*/
					
					
					//$clientuid = $info->getElement('data',$info->clientGetIds("CMs8uhDodMFkRhjyUJKxWkX5OBE=")); //  CMs8uhDodMFkRhjyUJKxWkX5OBE=
					//$info->sendMessage(1, $clientuid['clid'], "Hej, właśnie odpaliłeś LIVE, otrzymałeś grupę na serwerze!");
					
					/*
					$channel = $info->getElement('data',$info->channelInfo(59));
					$channel_desc = '[center][img]'.$stream_image.'[/img]
					
					[size=11][b]'.$stream_host.'[/b] ('.$stream_game.')[/size]
					'.$stream_title.'
					Oglądających: '.$stream_views.'[/center]';
					//$channel_desc = '[hr][center][size=13][b]» [url=https://twitch.tv/'.$stream_host.']'.$stream_host.'[/url] [[url=https://www.twitch.tv/directory/game/'.$better_cat.']'.$stream_game.'[/url]] «[/b][/size][/center][center][color=#e7ac20] '.$stream_title.' - Oglądających: '.$stream_views.'  [/color][/center][hr]';
					if($channel['channel_name'] == $stream_host.' [ONLINE]' && self::$lastscan < time()){
						$info->channelEdit(59, ['channel_description' => $channel_desc]);
						self::$lastscan = time()+900; // 15min
					}elseif($channel['channel_name'] != $stream_host.' [ONLINE]'){
						$info->channelEdit(59, ['channel_name' => $stream_host.' [ONLINE]','channel_description' => $channel_desc]);
					}
					*/
					if(self::$streamOn == false){
						$client = $info->getElement('data',$info->serverGroupAddClient(224, 2181)); // LIVE ON, domel
						self::$streamOn=true;
					}
					self::$streamOff=false;
					
					if(self::$times_s == 2){
						$name = 'twitch.tv/neeqsaiyan';
						$group = $info->getElement('data',$info->serverGroupRename(224, $name));
						self::$times_s=0;
					}elseif(self::$times_s == 1){
						//$name = $user_follow.' OBS';
						//$group = $info->getElement('data',$info->serverGroupRename(224, $name));
						self::$times_s++;
					}else{
						$name = 'LIVE ON';
						$group = $info->getElement('data',$info->serverGroupRename(224, $name));
						self::$times_s++;
					}
					
				}else{
					if(self::$streamOff == false){
						$client = $info->getElement('data',$info->serverGroupDeleteClient(224, 2181)); // LIVE ON, domel
						self::$streamOff=true;
					}
					self::$streamOn=false;
				}
				
				self::$times=0;
			}else{
				self::$times++;
			}
		}
		
	}
?>