<?php

	$newData = array();

	for ( $i = 0; $i < count($data); $i++){
		$newData[$data[$i]['createdtime']][] = $data[$i];
	}
	


?>