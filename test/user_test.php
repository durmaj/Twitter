<?php

require_once __DIR__."./../model/user.php";

$conn = new PDO("mysql:host=localhost;dbname=twitter",'root','coderslab');
$conn->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);

try {
    $user = (new User())
        ->setEmail("adam@spadam.pl")
        ->setPass('pass');


    $user
        ->saveToDB($conn);

    unset($user);

    $user = User::loadById($conn, 1);
    $users = User::loadAll($conn);

    $user->setEmail('agnieszka@smieszka.pl')->saveToDB($conn);

    unset($user);

    echo "Test 1 ".(($user instanceof User) ? "ok" : "no")." \n";
    echo "Test 2 ".((is_array($users) and count($users)) ? "ok" : "no")." \n";
    echo "Test 3 ".(($user->getEmail() === 'agnieszka@smieszka.pl') ? "ok" : "no")." \n";

} catch (\Exception $e) {
    var_dump($e->getMessage());
}
