<?php
// Include the class that we create objects of
require_once(__DIR__ . "/../models/m_contest.php");

// Begin scraping
scrape_atcoder();

function scrape_atcoder()
{
    // Pull data for all contests
    $site_data = file_get_contents("https://atcoder.jp/contests/");

    // Error, website not found
    if (empty($site_data)) {
        echo json_encode("INV");

        return;
    }

    preg_match_all("/<tbody>([\s\S]*?)<\/tbody>/", $site_data, $site_data);

    foreach($site_data[1] as $match)
    {
        // Grab title and dates

        preg_match("/<a href=\"(\/contests[^>]*?)\">/", $match, $site);
        preg_match("/<a href=\"\/contests[^>]*>(.*)<\/a>/", $match, $name);
        preg_match("/time class=[^>]*?>([\s\S]*?)<\/time/", $match, $dates_start);
        // Add details to array
        $arr[] = new contest(
            "AtCoder",
            "/images/AtCoder.png",
            $name[1],
            date("M d Y H:i:s", strtotime($dates_start[1])),
            date("M d Y H:i:s", strtotime($dates_start[1])),
            "Click link to view details",
            "https://atcoder.jp" . $site[1]
        );
    }

    // No details found!
    if (empty($arr)) {
        echo json_encode("INV");

        return;
    }

    // Output details
    echo json_encode($arr);
}
