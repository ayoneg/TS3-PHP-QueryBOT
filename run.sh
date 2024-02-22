	function start {
		if ! screen -list | grep -q "botphp"; then
			screen -AdmS botphp php bot.php -i 1
			echo "Pomyslnie uruchomiono bota"
		else
			echo "Bot jest juz uruchomiony!"
		fi
	}

	function stop {
		if ! screen -list | grep -q "botphp"; then
			echo "Bot nie był uruchomiony więc nie został zatrzymany"
		else
			echo "Pomyslnie zatrzymano bota!"
			screen -X -S botphp stuff "^C"
		fi
	}

	function restart {
		if ! screen -list | grep -q "botphp"; then
			echo "Bot nie był uruchomiony."
		else
			echo "Pomyslnie zatrzymano bota!"
			screen -X -S botphp stuff "^C"
		fi
		screen -AdmS botphp php bot.php -i 1
		echo "Pomyslnie uruchomiono bota"
	}
	
	clear
	
	echo "TEST AJONEG.EU BOT TS3"
	
	case "$1" in
		"start")
			start
		;;

		"stop")
			stop
		;;

		"restart")
			restart
		;;

		*)
			echo "Uzyj start | stop | restart"
		;; 
	esac