<?php
// show all errors
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require_once 'functions.php';

// echo "<pre>";

// remove the old database file if it exists
if (file_exists('db.sqlite')) {
  // unlink('db.sqlite');
}

$db = new PDO('sqlite:db.sqlite');
// $db->exec("CREATE TABLE IF NOT EXISTS users (  id INTEGER PRIMARY KEY,  name TEXT NOT NULL,  data TEXT)");
// createDummyData(10000);


// $tags = ['fun', 'work', 'home'];
// $items = getByTags($tags);
// print_r($items);

if (isset($_GET['tags'])) {
  $tags = explode(',', $_GET['tags']);
  $items = getByTags($tags);
  // json header
  header('Content-Type: application/json');
  echo json_encode($items);
  // print_r($items);
}

// echo "</pre>";

if (isset($_GET['createDummyData'])) {
  createDummyData($_GET['createDummyData']);
}

if (isset($_GET['input'])) {
?>
<pre>
  'work', 'home', 'school', 'fun', 'sport', 'health', 'food', 'travel', 'music', 'art', 'tech', 'science', 'nature', 'animals', 'family', 'friends', 'love', 'money', 'politics', 'religion', 'philosophy', 'history', 'literature', 'movies', 'games', 'fashion', 'beauty', 'cars', 'motorcycles', 'sports', 'fitness', 'cooking', 'baking', 'gardening', 'DIY', 'crafts', 'pets', 'photography', 'design', 'architecture', 'business', 'finance', 'marketing', 'education', 'languages', 'books', 'comics', 'magazines',
  'newspapers', 'journals', 'technology', 'science', 'nature', 'animals', 'family', 'friends', 'love', 'money', 'politics', 'religion', 'philosophy', 'history', 'literature', 'movies', 'games', 'fashion', 'beauty', 'cars', 'motorcycles', 'sports', 'fitness', 'cooking', 'baking', 'gardening', 'DIY', 'crafts', 'pets', 'photography', 'design', 'architecture', 'business', 'finance', 'marketing', 'education', 'languages', 'books', 'comics', 'magazines', 'newspapers', 'journals'
</pre>
<input type="text" name="tags" id="tags" value="fun,work,home" oninput="getItems()">
<div class=output></div>

<script>
function getItems() {
  let output = document.querySelector('.output');
  let tags = document.getElementById('tags').value;
  let url = 'https://dev.rasal.de/PSPASC/PHP/json-test.php?tags=' + tags;
  fetch(url)
    .then(response => response.json())
    .then(data => {
      console.log(data.data.length);
      if (data.data.length > 0) {
        console.log(data.extime);
        output.innerHTML = '';
        data.data.forEach(item => {
          output.innerHTML += `<div class="item">${item.data}</div>`;
        });
      } else {
        output.innerHTML = 'no items found';
      }
    });
}
</script>
<?php
}


//
// FUNCTIONS
//



// fake data
$usernames = ['John', 'Jane', 'Bob', 'Alice', 'Peter', 'Paul', 'Mary'];
$tags   = ['work', 'home', 'school', 'fun', 'sport', 'health', 'food', 'travel', 'music', 'art', 'tech', 'science', 'nature', 'animals', 'family', 'friends', 'love', 'money', 'politics', 'religion', 'philosophy', 'history', 'literature', 'movies', 'games', 'fashion', 'beauty', 'cars', 'motorcycles', 'sports', 'fitness', 'cooking', 'baking', 'gardening', 'DIY', 'crafts', 'pets', 'photography', 'design', 'architecture', 'business', 'finance', 'marketing', 'education', 'languages', 'books', 'comics', 'magazines', 'newspapers', 'journals', 'technology', 'science', 'nature', 'animals', 'family', 'friends', 'love', 'money', 'politics', 'religion', 'philosophy', 'history', 'literature', 'movies', 'games', 'fashion', 'beauty', 'cars', 'motorcycles', 'sports', 'fitness', 'cooking', 'baking', 'gardening', 'DIY', 'crafts', 'pets', 'photography', 'design', 'architecture', 'business', 'finance', 'marketing', 'education', 'languages', 'books', 'comics', 'magazines', 'newspapers', 'journals'];
$ipsum = 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nulla euismod, nisl eget aliquam ultricies, nunc sapien aliquet nunc, vitae aliquam nis iaculis sem.m ipsum dolor sit amet, consectetur adipiscing elit. Nulla euismod, nisl eget aliquam ultricies, nunc sapien aliquet nunc, vitae aliquam nis iaculis sem.m ipsum dolor sit amet, consectetur adipiscing elit. Nulla euismod, nisl eget aliquam ultricies, nunc sapien aliquet nunc, vitae aliquam nis iaculis sem.m ipsum dolor sit amet, consectetur adipiscing elit. Nulla euismod, nisl eget aliquam ultricies, nunc sapien aliquet nunc, vitae aliquam nis iaculis sem.m ipsum dolor sit amet, consectetur adipiscing elit. Nulla euismod, nisl eget aliquam ultricies, nunc sapien aliquet nunc, vitae aliquam nis iaculis sem.m ipsum dolor sit amet, consectetur adipiscing elit. Nulla euismod, nisl eget aliquam ultricies, nunc sapien aliquet nunc, vitae aliquam nis iaculis sem.m ipsum dolor sit amet, consectetur adipiscing elit. Nulla euismod, nisl eget aliquam ultricies, nunc sapien aliquet nunc, vitae aliquam nis iaculis sem.m ipsum dolor sit amet, consectetur adipiscing elit. Nulla euismod, nisl eget aliquam ultricies, nunc sapien aliquet nunc, vitae aliquam nis iaculis sem.m ipsum dolor sit amet, consectetur adipiscing elit. Nulla euismod, nisl eget aliquam ultricies, nunc sapien aliquet nunc, vitae aliquam nis iaculis sem. Nulla ';
function createDummyData($count)
{
  $time = microtime(true);

  global $db, $usernames, $tags, $ipsum;
  for ($i = 0; $i < $count; $i++) {
    $username = $usernames[array_rand($usernames)];
    $randomKey = randomKey();
    $data = [
      'username' => $username,
      'tags' => implode(',', array_rand(array_flip($tags), 3)),
      'content' => $ipsum . $i
    ];
    $data = json_encode($data);
    // echo $data . "\n";
    $db->exec("INSERT INTO users (name, data) VALUES ('$randomKey', '$data')");
  }
  $filesize = filesize('db.sqlite');
  echo '<br>database size: ' . formatSizeUnits(filesize('db.sqlite')) . '<br>';
  echo 'execution time: ' . round(((microtime(true) - $time) * 1000), 0) . ' milliseconds<br>';
}





function getByTags($tags)
{
  $time = microtime(true);

  global $db;

  // Construct the query with multiple conditions
  $query = "SELECT * FROM users WHERE (";

  // Add conditions for each tag
  foreach ($tags as $index => $tag) {
    $query .= "(',' || json_extract(data, '$.tags') || ',') LIKE ?";
    if ($index !== count($tags) - 1) {
      $query .= " OR ";
    }
  }
  $query .= ")";

  // Prepare the statement
  $stmt = $db->prepare($query);

  // Bind the parameters
  foreach ($tags as $index => $tag) {
    $stmt->bindValue($index + 1, "%,$tag,%");
  }

  // Execute the query
  $stmt->execute();

  $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
  // echo 'execution time: ' . round(((microtime(true) - $time) * 1000), 0) . ' milliseconds<br>';
  $extime = round(((microtime(true) - $time) * 1000), 0);

  $result = [
    'data' => $data,
    'extime' => $extime
  ];

  return $result;

  // foreach ($result as $row) {
  //   echo "ID: " . $row['id'] . ", Name: " . $row['name'] . ", Data: " . $row['data'] . "<br>";
  // }
}



function randomKey($length = 32)
{
  $key = '';
  $keys = array_merge(range(0, 9), range('a', 'z'));

  for ($i = 0; $i < $length; $i++) {
    $key .= $keys[array_rand($keys)];
  }

  return $key;
}


//
// NOT IN USE
//
// function createQueryForFindByTags($tags)
// {
//   $query = "SELECT * FROM users WHERE (";
//   foreach ($tags as $index => $tag) {
//     $query .= "(',' || json_extract(data, '$.tags') || ',') LIKE ?";
//     if ($index !== count($tags) - 1) {
//       $query .= " OR ";
//     }
//   }
//   $query .= ")";
//   return $query;
// }
// echo createQueryForFindByTags($tags);


// show all the data in the database
// $result = $db->query('SELECT * FROM users');
// print_r($result->fetchAll(PDO::FETCH_ASSOC));




// $tag = "fun";
// $stmt = $db->prepare("SELECT * FROM users WHERE ',' || json_extract(data, '$.tags') || ',' LIKE ?");
// $stmt->execute(['%,' . $tag . ',%']);
// $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
// foreach ($result as $row) {
//   echo "ID: " . $row['id'] . ", Name: " . $row['name'] . ", Data: " . $row['data'] . "<br>";
// }



// $data = json_encode(['age' => 30, 'country' => 'USA']);
// $db->exec("INSERT INTO users (name, data) VALUES ('John', '$data')");


// $result = $db->query("SELECT name, JSON_EXTRACT(data, '$.age') AS age FROM users");
// print_r($result->fetchAll(PDO::FETCH_ASSOC));


// show all the data in the database
// $result = $db->query('SELECT * FROM users');
// print_r($result->fetchAll(PDO::FETCH_ASSOC));