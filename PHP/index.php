<?php

// show all errors but not depricated ones
error_reporting(E_ALL & ~E_DEPRECATED);


require_once 'vendor/autoload.php';
$config = require_once 'config.php';
require_once 'functions.php';

// print_r($config);

$db = new SQLite3($config['db_folder'] . '/' . $config['db_name'] . '.sqlite');
$tags = ['cat', 'dog', 'bird', 'fish', 'horse', 'cow', 'pig', 'sheep', 'goat', 'chicken', 'duck', 'turkey', 'rabbit', 'mouse', 'rat', 'snake', 'lizard', 'turtle', 'frog', 'spider'];


$time = microtime(true);
// get all items with the tag 'cat'
// $result = $db->query("SELECT * FROM items WHERE tags LIKE '%cat%'");
// while ($row = $result->fetchArray()) {
//     echo '<pre>';
//     print_r($row);
//     echo '</pre>';
// }

// get all items with the tags 'cat' and 'dog' 
$result = $db->query("SELECT * FROM items WHERE tags LIKE '%cat%' AND tags LIKE '%dog%'");
// count the results
$count = 0;
while ($row = $result->fetchArray()) {
    $count++;
}
echo 'found ' . $count . ' items with the tags cat and dog<br>';

// while ($row = $result->fetchArray()) {
//     echo '<pre>';
//     print_r($row);
//     echo '</pre>';
// }

// print execution time
echo 'execution time: ' . round(((microtime(true) - $time) * 1000), 0) . ' milliseconds<br>';
