<?php

require_once __DIR__."/../src/Controller.php";


$uri = $_SERVER["REQUEST_URI"];
//REQUEST_URI nie dziala na moim localhoscie tak jakbym chcial, czyli zwracajac np. tylko /login. zwraca mi cala sciezke pliku ze struktura folderow, dlatego obejde to za pomoca strpos
var_dump($uri);
$method = $_SERVER["REQUEST_METHOD"];
$controller = new Controller();

//if($uri === "/login") {
if(strpos($uri, 'login') !== false) {
    if($method === "GET") {
        echo $controller->showLogin();die;
    } elseif ($method === "POST") {
        try {
            echo $controller->loginCheck();
        } catch (\Exception $e) {
            echo $e->getMessage();
        }

        die;
    }
}

//if($uri === "/profile") {
if(strpos($uri, 'profile') !== false) {

    if($method === "GET") {
        echo $controller->showProfile();die;
    } elseif($method === "POST") {
        echo $controller->updateProfile();die;
    }
}


//if($uri === "/register") {
if(strpos($uri, 'register') !== false) {
    if($method === "GET") {
        echo $controller->showRegister();die;
    } elseif($method === "POST") {
        echo $controller->createUser();die;
    }
}


//if($uri === "/logout") {
if(strpos($uri, 'logout') !== false) {

    echo $controller->logout();die;
}

if($uri === "/") {
    if($method === "GET") {
        echo "NOT IMPLEMENTED";die;
    }
}

echo "PATH NOT EXIST";

$checkUser->loadByEmail