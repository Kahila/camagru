<!-- nfigurations  -->
<?php
//echo "out here";
class config {
    public static function get($path = null){
    	//echo "here.....";
        if ($path){
            $config = $GLOBALS['config'];
            $path = explode('/', $path);
            //print_r($path);

            foreach ($path as $bit) {
            	if (isset($config[$bit])){
            		$config = $config[$bit];
            	}
            }
            return $config;
        }
        return false;
    }
}
//echo "this should work";