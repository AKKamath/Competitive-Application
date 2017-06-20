<?php
	// Include the class that we create objects of
	require_once("../models/m_contest.php");
	
	// Begin scraping
	scrape_codechef();
	
	function scrape_codechef()
	{
		// Pull data for all contests
		$site_data = file_get_contents("https://www.codechef.com/contests");
		
		// Error, website not found
		if(empty($site_data))
		{
			echo json_encode("INV");
			return;
		}
		
		preg_match("/<tbody>([\s\S]*?)<\/tbody>/", $site_data, $site_data);
		$site_data = $site_data[0];

		// Check for errors, and grab webpage of individual competitions
		if(!preg_match_all("/<a href=\"(.*?)\"[^>]*>/", $site_data, $matches))
		{
			echo json_encode("INV");
			return;
		}
		preg_match_all("/<td data-starttime=\"(.*?)\"/", $site_data, $dates_start);
		preg_match_all("/<td data-endtime=\"(.*?)\"/", $site_data, $dates_end);
		// Iterate through competitions
		for ($i = 0; $i < count($matches[1]); $i = $i + 1)
		{
			$match = $matches[1][$i];
			// Pull details of competition
			$n_file = file_get_contents("https://www.codechef.com/api/contests/" . $match);
			// Grab title
			preg_match("/\"name\":\"([^\"]*)\"/", $n_file, $title);
			if(empty($title))
			{
				continue;
			}
			// Grab contest details
			preg_match("/og:description' content='([^']*?)'/", $n_file, $details);
			
			// Add details to array
			$arr[] = new contest("CodeChef", "/images/CodeChef.jpg", $title[1], strtotime($dates_start[1][$i]), strtotime($dates_end[1][$i]), $details, "https://www.codechef.com" . $match);		
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
