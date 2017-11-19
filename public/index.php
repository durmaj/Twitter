<?php

require_once __DIR__."/../src/Controller.php";


$uri = $_SERVER["REQUEST_URI"];
$method = $_SERVER["REQUEST_METHOD"];
$controller = new Controller();

if($uri === "/login") {
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

if($uri === "/profile") {
    if($method === "GET") {
        echo $controller->showNavbar();
        echo $controller->showProfile();die;
    } elseif($method === "POST") {
        echo $controller->updateProfile();die;
    }
}

if($uri === "/register") {
    if($method === "GET") {
        echo $controller->showRegister();die;
    } elseif($method === "POST") {
        return $controller->createUser();
    }
}

if($uri === "/logout") {
    echo $controller->logout();die;
}

if($uri === "/") {
    echo $controller->showNavbar();
    echo $controller->mainPage();
    echo $controller->createTweet();
}

if(strpos($_SERVER['REQUEST_URI'], 'tweet')){
    echo $controller->showNavbar();
    echo $controller->showTweet();
    echo $controller->submitComment();

}

if(strpos($_SERVER['REQUEST_URI'], 'user')){
    echo $controller->showNavbar();
    echo $controller->showUser();
}



