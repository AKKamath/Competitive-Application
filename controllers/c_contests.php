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
                $t_contests = [];
                $t_contests[] = (array)new contest($site_name, '', "Needs updating", date("M d Y H:i:s"), date("M d Y H:i:s"), '', "");
            }
            $contests = array_merge($contests, $t_contests);
        }
        if(count($contests) > 1)
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
        return strtotime($a['date_end']) > strtotime($b['date_end']);
    }

    echo json_encode($contests);