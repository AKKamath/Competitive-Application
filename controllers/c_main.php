<?php
	$file = file_get_contents("../websites.json");
	if(empty($file))
		exit;
	
	$details = json_decode($file, true);
	for($i = 0; $i < 1/*$details['num']*/; ++$i)
	{
		$site = $details['sites']['site' . (string)$i];
		ob_start();		
		require("../" . $site);
		$result = json_decode(ob_get_clean(), true);
		if(!strcmp($result, "INV"))
		{
			echo $details['sites']['site' . (string)$i] . " needs updating.";
		}
	}
?>
