<?php

	class worksengine
	{
		
		// TODO: dokoncz
		public function start($info,$mysqli)
		{
			$server = mysqli_fetch_array($mysqli->query("SELECT * FROM `aj_tsconfig` WHERE id='1'"));
            

        }

    }

?>
