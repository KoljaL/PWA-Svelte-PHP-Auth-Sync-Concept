<?php


// function to insert array to sqlite database
function ARRAYtoSQL($table, $obj)
{
    global $db;
    $keys   = implode('`,`', array_map('addslashes', array_keys($obj)));
    // $values = implode("','", array_map('addslashes', str_replace("'", "", array_values($obj))));
    $values = implode("','", array_map('addslashes',  array_values($obj)));
    // echo $values.'<br>';
    // $values = implode("','", array_map('addslashes', array_values($obj)));
    try {
        $db->exec("INSERT INTO `$table` (`$keys`) VALUES ('$values')");
        $last_id = $db->lastInsertRowID();
        $last_note = $db->query("SELECT * FROM items WHERE id = $last_id")->fetchArray(SQLITE3_ASSOC);
        return json_encode($last_note);
    } catch (Exception $e) {
        return $e->getMessage();
    }
}


function formatSizeUnits($bytes)
{
    if ($bytes >= 1073741824) {
        $bytes = number_format($bytes / 1073741824, 2) . ' GB';
    } elseif ($bytes >= 1048576) {
        $bytes = number_format($bytes / 1048576, 2) . ' MB';
    } elseif ($bytes >= 1024) {
        $bytes = number_format($bytes / 1024, 2) . ' KB';
    } elseif ($bytes > 1) {
        $bytes = $bytes . ' bytes';
    } elseif ($bytes == 1) {
        $bytes = $bytes . ' byte';
    } else {
        $bytes = '0 bytes';
    }

    return $bytes;
}

function isJson($string)
{
  // $string = str_replace("\\", '', $string);
  // echo $string.'<br>';

    json_decode($string);
    // echo json_last_error();
    return (json_last_error() == JSON_ERROR_NONE);
}