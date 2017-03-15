<?php

namespace CityGame\CityGame\Models;

/**
*
*/
class Caching
{

    function __construct($file, $url)
    {
        //no need to initialize stuff
        $this->update($file, $url);
        return $this;
    }
    //try to update the file
    public function update($file, $link)
    {
        for ($i=0; $i < 5; $i++) {//try 5 times to get the file
            $content = $this->get_url($link);
            if($this->verify($content)){
                file_put_contents($file,$content);
                $message = "OpenWeatherMap data retrieved";
                break;//stop the loop (stop retrying) and the update() methode
            } else {
                $message ="openwheaterapi is terrible(failed to update cache)";
            }
        }
        return $message;
        //failed 5 times to update it
    }
    /* gets content from a URL via curl */
    private function get_url($url) {
        $ch = curl_init();
        curl_setopt($ch,CURLOPT_URL,$url);
        curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
        curl_setopt($ch,CURLOPT_CONNECTTIMEOUT,5);
        $content = curl_exec($ch);
        curl_close($ch);
        return $content;
    }

    /* verify if the json is valid for */
    private function verify($content)
    {
        try {
            $json=json_decode($content, true);
            //not good... but it works
            if (strncasecmp($content,'{"city":{"id":',14) === 0){
                return true;
            }else{
                return false;
            }
        } catch (Exception $e) {
            echo "openwheaterapi did not responds in time";
            return false;
        }//*/
        //return true;
    }
}











/*
// gets the contents of a file if it exists, otherwise grabs and caches
function get_content($file,$url,$hours = 24,$fn = '',$fn_args = '') {
//vars
$current_time = time(); $expire_time = $hours * 60 * 60; $file_time = filemtime($file);
//decisions, decisions
if(file_exists($file) && ($current_time - $expire_time < $file_time)) {
//echo 'returning from cached file';
return file_get_contents($file);
}
else {
$content = get_url($url);
if($fn) { $content = $fn($content,$fn_args); }
$content.= '<!-- cached:  '.time().'-->';
file_put_contents($file,$content);
//echo 'retrieved fresh from '.$url.':: '.$content;
return $content;
}
}

// gets content from a URL via curl
function get_url($url) {
$ch = curl_init();
curl_setopt($ch,CURLOPT_URL,$url);
curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
curl_setopt($ch,CURLOPT_CONNECTTIMEOUT,5);
$content = curl_exec($ch);
curl_close($ch);
return $content;
}//*/
