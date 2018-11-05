<?php
	class SmsSentPMS {
        public function getLatestSentMessages($conn, $minutes = 10) {
        	$outbox_container = [];
        	$outbox_query = "SELECT outbox_id, ts_written, ts_sent FROM smsoutbox_users NATURAL JOIN smsoutbox_user_status order by outbox_id desc limit 1";
        	$result = $conn->query($outbox_query);
        	if ($result->num_rows != 0) {
        		while ($row = $result->fetch_assoc()) {
        			array_push($outbox_container, $row);
        		}
        	}
        	return $outbox_container;
        }
	}
?>