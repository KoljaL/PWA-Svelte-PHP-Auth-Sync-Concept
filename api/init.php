<?php

$config = require_once 'config.php';
require_once 'functions.php';

// remove old database
if (file_exists($config['db_folder'].'/'.$config['db_name'].'.sqlite')) {
    unlink($config['db_folder'].'/'.$config['db_name'].'.sqlite');
}

// create a new SQLIte database
$db = new SQLite3($config['db_folder'].'/'.$config['db_name'].'.sqlite');

createTables($db);
initSettings();
// showTables($db);
showSettings($db);


function showSettings($db){ 
  // read settings table
  $result = $db->query("SELECT * FROM settings");
  $row = $result->fetchArray(SQLITE3_ASSOC);
  echo '<pre>';
  // foreach ($row as $key => $value) {
  //   if (isJson($value)) {
  //     $value = json_decode($value, true);
  //   }
  //   echo $key.': '.$value.'<br>';
  // }
  




  // print_r($row['item_types']);
  echo '<h4>item_types</h4>';
  $item_types_string = str_replace("\\", '', $row['item_types']);
  $item_types = json_decode($item_types_string, true);
  echo '<br>';
  print_r($item_types);
}
 


function createTables($db)
{
    // items
    $db->exec("CREATE TABLE IF NOT EXISTS items (
  id INTEGER PRIMARY KEY AUTOINCREMENT,
  title TEXT NOT NULL,
  content TEXT DEFAULT NULL,
  created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
  updated_at DATETIME DEFAULT CURRENT_TIMESTAMP,
  deleted_at DATETIME DEFAULT NULL,
  type TEXT NOT NULL,
  tags TEXT DEFAULT NULL,
  color TEXT DEFAULT NULL,
  icon TEXT DEFAULT NULL,
  archived INTEGER DEFAULT 0,
  pinned INTEGER DEFAULT 0,
  trashed INTEGER DEFAULT 0,
  date DATETIME DEFAULT CURRENT_TIMESTAMP,
  duration INTEGER DEFAULT 0,
  contact_name TEXT DEFAULT NULL,
  contact_email TEXT DEFAULT NULL,
  contact_phone TEXT DEFAULT NULL,
  contact_address TEXT DEFAULT NULL,
  contact_birthday DATETIME DEFAULT NULL,
  contact_website TEXT DEFAULT NULL
)");

    // settings
    $db->exec("CREATE TABLE IF NOT EXISTS settings (
  id INTEGER PRIMARY KEY AUTOINCREMENT,
  username TEXT NOT NULL,
  email TEXT DEFAULT NULL,
  password TEXT NOT NULL,
  created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
  updated_at DATETIME DEFAULT CURRENT_TIMESTAMP,
  items_per_page INTEGER DEFAULT 10,
  language TEXT DEFAULT 'en',
  theme TEXT DEFAULT 'light',
  item_types JSON DEFAULT '',
  smtp_host TEXT DEFAULT NULL,
  smtp_server TEXT DEFAULT NULL,
  smtp_port INTEGER DEFAULT NULL,
  smtp_username TEXT DEFAULT NULL,
  smtp_password TEXT DEFAULT NULL,
  smtp_encryption TEXT DEFAULT NULL,
  smtp_from_name TEXT DEFAULT NULL,
  smtp_from_email TEXT DEFAULT NULL
)");
}



function initSettings(){

$item_types = [
    'todo' => [
        'title' => 'Todo',
        'icon' => 'check',
        'color' => '#ff0000',
        'tags' => ['todo', 'task', 'list'],
    ],
    'note' => 'Note',
    'contact' => 'Contact',
    'bookmark' => 'Bookmark',
    'reminder' => 'Reminder',
];
 
$settings = [
    'username' => 'admin',
    'email' => 'test@web.de',
    'password' => password_hash("1234", PASSWORD_DEFAULT),
    'items_per_page' => 10,
    'language' => 'en',
    'theme' => 'light',
    'item_types' => json_encode($item_types),
    'smtp_host' => 'smtp.mailtrap.io',
    'smtp_server' => 'smtp.mailtrap.io',
    'smtp_port' => 2525,
    'smtp_username' => 'e0b0b0b0b0b0b0',
    'smtp_password' => 'e0b0b0b0b0b0b0',
    'smtp_encryption' => 'tls',
    'smtp_from_name' => 'Admin',
    'smtp_from_email' => 'test@web.de',
];
//   echo 'org item_types: <br>';
// print_r($settings['item_types']);
// echo '<br><br>';
$response = ARRAYtoSQL('settings', $settings);
}





function showTables($db)
{
    $result = $db->query("SELECT name FROM sqlite_master WHERE type='table';");
    echo <<<EOT
<style>
h3{
  text-align: center;
}
  table {
    border-collapse: collapse;
    width: max-content;
    margin-inline: auto;
  }
  table, th, td {
    border: 1px solid #ddd;
    padding: 5px;
  }
</style>
EOT;

    while ($row = $result->fetchArray()) {
        if ($row['name'] === 'sqlite_sequence') {
            continue;
        }
        echo '<h3>Table: '.$row['name'].'</h3>';
        $result2 = $db->query("PRAGMA table_info(".$row['name'].");");
        echo '<table>';
        echo '<tr>';
        echo '<th>Name</th>';
        echo '<th>Type</th>';
        echo '<th>NULL</th>';
        echo '<th>default</th>';
        echo '</tr>';

        while ($row2 = $result2->fetchArray()) {
            echo '<tr>';
            echo '<td> ' . $row2['name'] . '</td>';
            echo '<td> ' .$row2['type'].'</td>';
            echo '<td> ' .$row2['notnull'].'</td>';
            echo '<td> ' .$row2['dflt_value'].'</td>';
            echo '</tr>';
        }
        echo '</table>';
    }

    echo '<h3>Inserting fake data: <a href="faker.php">click</a></h3>';
}