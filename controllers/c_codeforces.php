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
		preg_match_all("/<tr>([\S\s]*?)<\/tr>/", $site_data, $site_data);
		// Iterate through competitions
		foreach ($matches[1] as $match)
		{
			// Add details to array
			$arr[] = new contest("CodeForces", "/images/CodeForces.png", $title[1], $date_start[1], $date_end[1], $details[1], "" . $match);		
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
