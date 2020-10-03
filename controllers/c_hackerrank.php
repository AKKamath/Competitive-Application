<?php
	// Include the class that we create objects of
	require_once(__DIR__ . "/../models/m_contest.php");
	
	// Begin scraping
	scrape_hackerrank();
	
	
	function scrape_hackerrank()
	{
		// Pull data for all contests
		$site_data = file_get_contents("https://www.hackerrank.com/contests");
	
		// Error, website not found
		if(empty($site_data))
		{
			echo json_encode("INV");
			return;
		}
		
		// Check for errors, and grab webpage of individual competitions
		if(!preg_match_all("/<a href=\"(.*?)\"[^>]*>View Details/", $site_data, $matches))
		{
			echo json_encode("INV");
			return;
		}

		// Iterate through competitions
		foreach ($matches[1] as $match)
		{
			// Pull details of competition
			$n_file = file_get_contents("https://www.hackerrank.com" . $match);

			// Grab title
			preg_match("/h1[^>]*>(.*?)</", $n_file, $title);
			if(empty($title))
			{
				continue;
			}

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
			$arr[] = new contest("HackerRank", "/images/HackerRankImg.png", $title[1], date("M d Y H:i:s", $date_start[1]), date("M d Y H:i:s", $date_end[1]), $details[1], "https://www.hackerrank.com" . $match);		
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
