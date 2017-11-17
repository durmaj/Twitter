<?php

require_once __DIR__."/../model/User.php";

$conn = new \PDO("mysql:host=127.0.0.1;dbname=twitter",'root','coderslab');
$conn->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);

try {
    (new User())
        ->setEmail("kadam@spadam.pl")
        ->setPass('pass')
        ->saveToDB($conn);

    $user = User::loadById($conn, 1);
    $users = User::loadAll($conn);
    $user->setEmail('agnieszka@śmieszka.pl')->saveToDB($conn);

    unset($user);

    $user = User::loadById($conn, 1);

    echo "Test 1 ".(($user instanceof User) ? "ok" : "no" )." \n";
    echo "Test 2 ".((is_array($users) and count($users)) ? "ok" : "no" )." \n";
    echo "Test 3 ".(($user->getEmail() === 'agnieszka@śmieszka.pl') ? "ok" : "no" )." \n";

//    $user->delete($conn);
//    $users = User::loadAll($conn);
//
//    echo "Test 4 ".((is_array($users) and count($users) === 0) ? "ok" : "no" )." \n";


} catch (\Exception $e) {
    var_dump($e->getMessage());
}