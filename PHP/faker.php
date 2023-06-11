<?php

// show all errors but not depricated ones
error_reporting(E_ALL & ~E_DEPRECATED);


require_once 'vendor/autoload.php';
$config = require_once 'config.php';
require_once 'functions.php';
// print_r($config);
$time = microtime(true);

$db = new SQLite3($config['db_folder'].'/'.$config['db_name'].'.sqlite');

// init faker
$faker = Faker\Factory::create();
$faker->addProvider(new Faker\Provider\en_US\Person($faker));
$faker->addProvider(new Faker\Provider\en_US\Address($faker));
$faker->addProvider(new Faker\Provider\en_US\PhoneNumber($faker));

$tags = ['cat', 'dog', 'bird', 'fish', 'horse', 'cow', 'pig', 'sheep', 'goat', 'chicken', 'duck', 'turkey', 'rabbit', 'mouse', 'rat', 'snake', 'lizard', 'turtle', 'frog', 'spider'];

echo '<pre>';
// echo $faker->hexColor();
$count = 1000;
addTodos($count);
addContacts($count);
addReminders($count);
addCalendars($count);
additems($count);

echo '</pre>';
// echo 'added '.$count.' items of each type';
$filesize = filesize($config['db_folder'].'/'.$config['db_name'].'.sqlite');
echo '<br>database size: '.formatSizeUnits($filesize).'<br>';
echo 'execution time: '. round(((microtime(true) - $time)),1).' seconds<br>';


function additems($count)
{
    global $faker, $tags;
    for ($i = 0; $i < $count; $i++) {
        $note = [];
        $note['tags'] = implode(',', $faker->randomElements($tags, 3));
        $note['color'] = $faker->hexColor();
        $note['title'] =  $faker->sentence(3);
        $note['type'] = 'note';
        $note['content'] = $faker->paragraph(3);
        $note['icon'] = 'file-text';
        $note['archived'] = $faker->boolean(20);
        $note['pinned'] = $faker->boolean(20);
        $note['trashed'] = $faker->boolean(20);
        // echo '<pre>';
        // print_r($note);
        $response = ARRAYtoSQL('items', $note);
        // print($response);
    }
    echo 'added '.$count.' items<br>';
}


function addCalendars($count)
{
    global $faker, $tags;
    for ($i = 0; $i < $count; $i++) {
        $calendar = [];
        $calendar['tags'] = implode(',', $faker->randomElements($tags, 3));
        $calendar['color'] = $faker->hexColor();
        $calendar['title'] =  $faker->sentence(3);
        $calendar['type'] = 'calendar';
        $calendar['content'] = $faker->paragraph(3);
        $calendar['date'] = $faker->dateTimeBetween('now', '+1 year')->format('d.m.Y H:i');
        $calendar['duration'] = $faker->numberBetween(0, 120);
        $calendar['icon'] = 'calendar';
        $calendar['archived'] = $faker->boolean(20);
        $calendar['pinned'] = $faker->boolean(20);
        $calendar['trashed'] = $faker->boolean(20);
        // echo '<pre>';
        // print_r($calendar);
        $response = ARRAYtoSQL('items', $calendar);
        // print($response);
    }
    echo 'added '.$count.' calender entries<br>';
}

function addReminders($count)
{
    global $faker, $tags;
    for ($i = 0; $i < $count; $i++) {
        $reminder = [];
        $reminder['tags'] = implode(',', $faker->randomElements($tags, 3));
        $reminder['color'] = $faker->hexColor();
        $reminder['title'] =  $faker->sentence(3);
        $reminder['type'] = 'reminder';
        $reminder['content'] = $faker->paragraph(3);
        $reminder['date'] = $faker->dateTimeBetween('now', '+1 year')->format('d.m.Y H:i');
        $reminder['icon'] = 'bell';
        $reminder['archived'] = $faker->boolean(20);
        $reminder['pinned'] = $faker->boolean(20);
        $reminder['trashed'] = $faker->boolean(20);
        // echo '<pre>';
        // print_r($reminder);
        $response = ARRAYtoSQL('items', $reminder);
        // print($response);
    }
    echo 'added '.$count.' reminder<br>';

}

function addTodos($count)
{
    global $faker, $tags;
    for ($i = 0; $i < $count; $i++) {
        $todo = [];
        // $todo['tags'] = $faker->randomElements($tags, $count = 3);
        // convert array to string
        $todo['tags'] = implode(',', $faker->randomElements($tags, 3));
        $todo['color'] = $faker->hexColor();
        $todo['title'] =  $faker->sentence(3);
        $todo['type'] = 'todo';
        $todo['content'] = $faker->paragraph(3);
        $todo['date'] = $faker->dateTimeBetween('now', '+1 year')->format('d.m.Y H:i');
        $todo['icon'] = 'check';
        $todo['archived'] = $faker->boolean(20);
        $todo['pinned'] = $faker->boolean(20);
        $todo['trashed'] = $faker->boolean(20);
        // echo '<pre>';
        // print_r($todo);
        $response = ARRAYtoSQL('items', $todo);
        // print($response);
    }
    echo 'added '.$count.' todos<br>';
}


function addContacts($count)
{
    global $faker, $tags;
    for ($i = 0; $i < $count; $i++) {
        $contact = [];
        $contact['color'] = $faker->hexColor();
        $contact['tags'] = implode(',', $faker->randomElements($tags, 3));
        $contact['title'] =  $faker->name;
        $contact['contact_name'] = $contact['title'];
        $contact['type'] = 'contact';
        $contact['contact_email'] = $faker->email;
        $contact['contact_phone'] = $faker->phoneNumber;
        $contact['contact_address'] = $faker->address;
        // escape single quotes
        // $contact['contact_address'] = str_replace("'", " ", $contact['contact_address']);
        $contact['contact_birthday'] =$faker->dateTimeBetween('-50 years', '-20 years')->format('d.m.Y');
        $contact['contact_website'] = $faker->url();
        // echo '<pre>';
        // print_r($contact);
        $response = ARRAYtoSQL('items', $contact);
        // print($response);
    }
    echo 'added '.$count.' contacts<br>';

} 