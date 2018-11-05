<?php
	require_once(__DIR__.'/src/db_connect.php');
	require_once(__DIR__.'/src/ground_measurement_lib.php');
	require_once(__DIR__.'/src/sms_sent_lib.php');

	$db_credentials = include(__DIR__.'/config/config.php');

	class Main {
        public function __construct() {
        	global $db_credentials, $connect, 
        			$gndmeas_lib, $smssent_lib, $memcached;
			$gndmeas_lib = new GroundMeasPMS();
			$smssent_lib = new SmsSentPMS();
			$db_connect = new DBConnect();
			$memcached = new Memcached;
			$memcached->addServer('127.0.0.1', 11211);
			$connect = $db_connect->__connection($db_credentials);
        }
	}

	
	$main = new Main();
	
	$memcached->add("smsoutbox_last_id","anathaone");

	if ($memcached->get("smsoutbox_last_id") == false) {
		$smssent_lib->getLatestSentMessages($connect['cbx_conn']);
	} else {
		var_dump($memcached->get("smsoutbox_last_id"));
	}
?>