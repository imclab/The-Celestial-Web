<?php

$year_month = "2012-10";
//$countries = array("AD","AE","AF","AG","AI","AL","AM","AN","AO","AQ","AR","AS","AT","AU","AW","AX","AZ","BA","BB","BD","BE","BF","BG","BH","BI","BJ","BM","BN","BO","BR","BS","BT","BV","BW","BY","BZ","CA","CC","CD","CF","CG","CH","CI","CK","CL","CM","CN","CO","CR","CS","CU","CV","CW","CX","CY","CZ","DE","DJ","DK","DM","DO","DZ","EC","EE","EG","EH","ER","ES","ET","FI","FJ","FK","FM","FO","FR","GA","GB","GD","GE","GF","GG","GH","GI","GL","GM","GN","GP","GQ","GR","GT","GU","GW","GY","HK","HM","HN","HR","HT","HU","ID","IE","IL","IM","IN","IO","IQ","IR","IS","IT","JE","JM","JO","JP","KE","KG","KH","KI","KM","KN","KP","KR","KW","KY","KZ","LA","LB","LC","LI","LK","LR","LS","LT","LU","LV","LY","MA","MC","MD","ME","MG","MH","MK","ML","MM","MN","MO","MP","MQ","MR","MS","MT","MU","MV","MW","MX","MY","MZ","NA","NC","NE","NF","NG","NI","NL","NO","NP","NR","NU","NZ","OM","PA","PE","PF","PG","PH","PK","PL","PM","PN","PR","PS","PT","PW","PY","QA","RE","RO","RS","RU","RW","SA","SB","SC","SD","SE","SG","SH","SI","SK","SL","SM","SN","SO","SR","ST","SV","SY","SZ","TC","TD","TF","TG","TH","TJ","TK","TL","TM","TN","TO","TR","TT","TV","TW","TZ","UA","UG","UM","US","UY","UZ","VA","VC","VE","VG","VI","VN","VU","WF","WS","YE","YT","ZA","ZM","ZW");
  $countries = array("AD","AE","AF","AG","AI","AL","AM","AN","AO","AQ","AR","AS","AT","AU","AW","AX","AZ","BA","BB","BD","BE","BF","BG","BH","BI","BJ","BM","BN","BO","BR","BS","BT","BW","BY","BZ","CA","CD","CF","CG","CH","CI","CK","CL","CM","CN","CO","CR","CS","CU","CV","CW","CY","CZ","DE","DJ","DK","DM","DO","DZ","EC","EE","EG","ER","ES","ET","FI","FJ","FK","FM","FO","FR","GA","GB","GD","GE","GF","GH","GI","GL","GM","GN","GP","GQ","GR","GT","GU","GW","GY","HK","HN","HR","HT","HU","ID","IE","IL","IM","IN","IO","IQ","IR","IS","IT","JE","JM","JO","JP","KE","KG","KH","KI","KM","KN","KP","KR","KW","KY","KZ","LA","LB","LC","LI","LK","LR","LS","LT","LU","LV","LY","MA","MC","MD","ME","MG","MH","MK","ML","MM","MN","MO","MP","MQ","MR","MS","MT","MU","MV","MW","MX","MY","MZ","NA","NC","NE","NF","NG","NI","NL","NO","NP","NR","NU","NZ","OM","PA","PE","PF","PH","PK","PL","PM","PR","PS","PT","PW","PY","QA","RE","RO","RS","RU","RW","SA","SB","SC","SD","SE","SG","SI","SK","SL","SM","SN","SO","SR","ST","SV","SY","SZ","TC","TD","TF","TG","TH","TJ","TK","TL","TM","TN","TO","TR","TT","TV","TW","TZ","UA","UG","UM","US","UY","UZ","VA","VC","VE","VG","VI","VN","VU","WF","WS","YE","YT","ZA","ZM","ZW");

//for($month=1;$month<=12;$month++) {
	$top_market_share_owner = array();
	$data = "";
	
	//if($month < 10) $month_str = "0" . $month;
	//else $month_str = $month;

	for($i=0;$i<sizeof($countries);$i++) {	
		$row = 1;

		//$get_url = "http://gs.statcounter.com/chart.php?bar=1&statType_hidden=browser&region_hidden=" . $countries[$i] . "&granularity=daily&statType=Browser&fromMonthYear=2012-08&fromDay=31&toMonthYear=2012-08&toDay=31&csv=1";
		$get_url = "http://gs.statcounter.com/chart.php?bar=1&statType_hidden=browser&region_hidden=" . $countries[$i] . "&granularity=monthly&statType=Browser&fromMonthYear=" . $year_month . "&toMonthYear=" . $year_month . "&csv=1";

		if(($handle = fopen($get_url, "r")) !== FALSE) {
    		while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
				//skip first line
				if($row == 1) { $row++; continue; }

	    		//2nd line in the csv file is what we want, so we add that country to the set of the particular browser that it's mapped to
    	    	//$top_market_share_owner[$data[0]] = $data[1]; //data[1] is the percentage; might need it in a future iteration
	        	$top_market_share_owner[strtolower($data[0])][] = $countries[$i];

    	    	break;
		    }
    		fclose($handle);
		}

		usleep(100+rand(100,1100));
	}
		
	$data = json_encode($top_market_share_owner);
	echo $data;
	print_r($top_market_share_owner);

	$file = "data/$year_month.json";
	file_put_contents($file, $data);
//}

?>