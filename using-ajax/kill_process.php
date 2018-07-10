<?php
$pidData = $_GET['pid'];

$kill = function($pid){ return stripos(php_uname('s'), 'win')>-1 
                        ? exec("taskkill /F /PID $pid") : exec("kill -9 $pid");
};
//e.g.
$kill($pidData);
echo 'ok';

?>
