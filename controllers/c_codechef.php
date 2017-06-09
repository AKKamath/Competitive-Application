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

		// Iterate through competitions
		foreach ($matches[1] as $match)
		{
			// Pull details of competition
			$n_file = file_get_contents("https://www.codechef.com/api/contests/" . $match);
			// Grab title
			preg_match("/\"name\":\"([^\"]*)\"/", $n_file, $title);
			if(empty($title))
			{
				continue;
			}
			echo $title;
			// Grab start date
			preg_match("/starttime.setUTCSeconds\((.*?)\)/", $n_file, $date_start);
			if(empty($title))
			{
				continue;
			}

			// Grab end date
			preg_match("/endtime.setUTCSeconds\((.*?)\)/", $n_file, $date_end);
			
			// Grab contest details
			preg_match("/og:description' content='([^']*?)'/", $n_file, $details);
			
			// Add details to array
			$arr[] = new contest("CodeChef", "/images/CodeChef.jpg", $title[1], $date_start[1], $date_end[1], $details[1], "https://www.codechef.com" . $match);		
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
