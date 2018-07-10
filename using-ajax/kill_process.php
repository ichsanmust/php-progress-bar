<?php
$pidData = $_GET['pid'];
$file = str_replace(".", "", $_GET['file']);
$file = "tmp/" . $file . ".txt";
$kill = function($pid){ return stripos(php_uname('s'), 'win')>-1 
                        ? exec("taskkill /F /PID $pid") : exec("kill -9 $pid");
};



$kill($pidData); // kill php process
if (file_exists($file)) { // delete file checker progress bar
    unlink($file);
}

echo 'killed';

?>
