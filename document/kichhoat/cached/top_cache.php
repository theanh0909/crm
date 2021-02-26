<?php
$cachefile = "../cached/log-" .date("d-m-Y") . ".html";


$cachetime = 1*60; // 5 minutes
// Serve from the cache if it is younger than $cachetime

if (file_exists($cachefile) && (time() - $cachetime < filemtime($cachefile))) {

    include($cachefile);


    echo "<!-- Cached " . date('jS F Y H:i', filemtime($cachefile)) . " 
         -->n";


    exit;
}

ob_start(); // start the output buffer
?>