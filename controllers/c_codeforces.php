<?php
	// Include the class that we create objects of
	require_once("../models/m_contest.php");
	
	// Begin scraping
	scrape_codeforces();
	
	
	function scrape_codeforces()
	{
		// Pull data for all contests
		$site_data = file_get_contents("http://codeforces.com/contests");
	
		// Error, website not found
		if(empty($site_data))
		{
			echo json_encode("INV");
			return;
		}
		preg_match("/<div class=\"datatable\"[^>]*?>([\s\S]*?)<div class=\"datatable\"/", $site_data, $site_data);
		$site_data = $site_data[1];
		//echo $site_data;
		preg_match_all("/<tr[^d]*?(data-contestId=\"[\S\s]*?)<\/tr>/", $site_data, $matches);
		
		// Iterate through competitions
		foreach ($matches[1] as $match)
		{
			preg_match("/data-contestId=\"(.*?)\"/", $match, $url);
			preg_match("/<td>[\r\n]*([\S ]*)<\/td>/", $match, $title);
			preg_match("/\"format-time\"[^>]*?>(.*?)<\/span>/", $match, $date_start);
			preg_match("/month=(.*?)&/", $match, $month);
			$date_start = preg_replace("/^\w+/", $month[1], $date_start[1]);
			echo $date_start;
			// Add details to array
			$arr[] = new contest("CodeForces", "/images/CodeForces.png", $title[1], strtotime($date_start), $date_end[1], $details[1], "http://codeforces.com/contests/" . $url[1]);		
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
