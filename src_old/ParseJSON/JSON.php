<?php
	if(isset($_POST['json'])){ #post correctly
		$obj = json_decode($_POST['json'],true);
		echo $obj[0]["subject"]; #print out random to see works
		echo "success";
		#must connect to off site DB and then do sql command
		#To Be Completed...
	}
	else{
		echo "getting called";
	}
?>
