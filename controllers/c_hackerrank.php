<?php
	require("../models/m_contest.php");
	scrape();
	function scrape()
	{
		$out_arr;
		$data = new contest;
		$site_data = file_get_contents("https://www.hackerrank.com/contests");
		if(empty($site_data))
		{
			echo json_encode("INV");
			return;
		}
		if(!preg_match_all("/<a href=\"(.*?)\"[^>]*>View Details/", $site_data, $matches))
		{
			echo json_encode("INV");
			return;
		}
		foreach ($matches[1] as $match)
		{
			$n_file = file_get_contents("https://www.hackerrank.com" . $match);
			preg_match("/h1[^>]*>(.*?)</", $n_file, $title);
			if(empty($title))
			{
				continue;
			}
			echo $title[1];
		}
	}	
?>
