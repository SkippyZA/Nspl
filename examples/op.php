<?php

require_once __DIR__ . '/../autoload.php';

use nspl\op;
use function nspl\op\itemGetter;
use function nspl\op\propertyGetter;

use function nspl\f\map;
use function nspl\a\sorted;


$users = [
    array('name' => 'John', 'age' => 15),
    array('name' => 'Jack', 'age' => 35),
    array('name' => 'Sarah', 'age' => 25),
    array('name' => 'Norah', 'age' => 20),
    array('name' => 'Michael', 'age' => 30),
];


// 1. Get user names from list of users presented with array data
$names = map(itemGetter('name'), $users);

echo sprintf("User names are: %s (users were presented with array data)\n", implode(', ', $names));


// 2. Convert list of user presented with array data to list of objects
$objects = map(op::$object, $users);

echo sprintf("List of users converted to objects consists of types: %s\n", implode(', ', map('\nspl\ds\getType', $objects)));


// 3. Sort users by age
$sorted = sorted($users, false, itemGetter('age'));

echo "Users sorted by age:\n";
foreach ($sorted as $user) {
    echo sprintf("    %s - %s y.o.\n", $user['name'], $user['age']);
}

