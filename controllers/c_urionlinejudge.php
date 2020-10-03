<?php
	// Include the class that we create objects of
	require_once("../models/m_contest.php");
	
	// Begin scraping
	scrape_urionlinejudge();
	
	function scrape_urionlinejudge()
	{
		
		// Pull data for all contests
		$site_data = file_get_contents("https://www.urionlinejudge.com.br/judge/en/contests");

		// Error, website not found
		if(empty($site_data))
		{
			echo json_encode("INV");
			return;
		}

		$name_regex = "/<a href=\"\/judge\/en\/contests\/view\/(\d+)\">((?!\d+?).+)<\/a>/";
		$date_regex = "/<td class=\"date center\">(.+?)<\/td>/s";

		preg_match_all($name_regex, $site_data, $names);
		preg_match_all($date_regex, $site_data, $dates);

		$arr = [];

		for($i = 0; $i < count($names[0]); $i++)
		{
			//if the contest is in the future
			if(strtotime($dates[1][$i]) > time()){
				$id = $names[1][$i];
				$name = $names[2][$i];
				$date = $dates[1][$i];

				$arr[] = new contest("Uri Online Judge", "/images/UriOnlineJudge.png", $name, strtotime($date), '', 'Click link to view details', "https://www.urionlinejudge.com.br/judge/pt/contests/view/" . $id);
			}
		}
		
		// No details found!
		if(empty($arr))
		{
			echo json_encode("INV");
			return;
		}

		// Output details
		echo json_encode($arr);
	}	
?>
