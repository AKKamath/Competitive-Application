<?php 
    $file = file_get_contents(__DIR__ . "/../websites.json");
    $test = @file_get_contents("http://www.google.com");
    $contests = [];
    if(!empty($test)) {
        if(empty($file)) {
            exit;
        }

        $details = json_decode($file, true);
        foreach($details['sites'] as $site_name => $site) {
            ob_start();     
            include(__DIR__ . "/../" . $site);
            $t_contests = json_decode(ob_get_clean(), true);
            
            if(empty($t_contests) || (is_string($t_contests) && !strcmp($t_contests, "INV"))) {
                echo $site_name . " needs updating.";
                continue;
            }
            $contests = array_merge($contests, $t_contests);
        }
        usort($contests, "cmp");
        if(!empty($contests)) {
            file_put_contents(__DIR__ . "/../cache.json", json_encode($contests));
        }
    } else {
        $cache = json_decode(file_get_contents(__DIR__ . "/../cache.json"), true);
        if(!empty($cache)) {
            $contests = $cache;
        } else {
            json_encode(['error' => 'Internet is Down.']);
        }
    }
    
    function cmp($a, $b)
    {
        return $a['date_start'] > $b['date_start'];
    }

    echo json_encode($contests);