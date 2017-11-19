<?php

require_once __DIR__."/DB.php";
require_once __DIR__."/../model/User.php";
require_once __DIR__."/../model/Tweet.php";
session_start();

class Controller
{
    private function render($template,$data = []) {
        $html = file_get_contents(__DIR__."/../template/$template.html");
        foreach ($data as $key => $value) {
            $html = str_replace('{{'.$key.'}}',$value,$html);
        }
        return $html;
    }

    public function showLogin()
    {
        return $this->render('login');
    }

    public function showProfile()
    {
        DB::init();

        if ($_SESSION['errors'] == "wrongPass"){
            echo "Wrong Password";
            unset($_SESSION['errors']);
        }

        if(isset($_SESSION["user"])) {
            $user = User::loadById(DB::$conn, $_SESSION["user"]);
            return $this->render('profile',$user->toArray());
        } else {
            return $this->showLogin();
        }

    }

    public function loginCheck()
    {
        DB::init();

        $email = $_POST["email"];
        $plain =$_POST["pass"];
        if(strlen($email) ===0 || strlen($plain) === 0) {
            throw new \Exception("Pass and email cannot be empty");
        }

        $user = User::loadByEmail(DB::$conn,$email);
        if(!$user) {
            throw new \Exception("User does not exists");
        }

        if(password_verify($plain,$user->getPass())) {
            $_SESSION["user"] = $user->getId();
            header('Location: /');
            return;
        } else {
            return "no";
        }
    }

    public function updateProfile() {
        DB::init();

        if(isset($_SESSION["user"])) {
            $user = User::loadById(DB::$conn, $_SESSION["user"]);

            if (!password_verify($_POST['oldPass'], $user->getPass()) || strlen($_POST['oldPass']) < 1)
            {
                $_SESSION['errors']="wrongPass";
                return $this->showProfile();
            } else {
                if (strlen($_POST['pass']) > 1)
                {
                    $user->setPass($_POST["pass"]);
                    $user->saveToDB(DB::$conn);
                    echo "Password has been changed";
                    return $this->showProfile();
                }
            }

            if (isset($_POST['delAccount'])) {
                $user->delete(DB::$conn);
                echo "Account has been deleted";
                return $this->showLogin();
            }

        }
        return $this->showLogin();
    }

    public function logout() {
        session_unset();
        header('Location: /login');
        return;
    }

    public function showRegister() {
        if ($_SESSION['errors'] === "userExists")
        {
            echo "User exists";
            unset($_SESSION['errors']);
        }
        return $this->render('register');
    }

    public function createUser()
    {
        DB::init();


        $userCheck = User::loadByEmail(DB::$conn, $_POST['email']);
        if ($userCheck != null)
        {
            $_SESSION['errors']="userExists";
            return $this->showRegister();
        }

        $user = new User;

        $user->setEmail($_POST['email'])->setPass($_POST["pass"]);

        try {
            $user->saveToDB(DB::$conn);
        } catch (\Exception $e) {
            return $e->getMessage();
        }

        $_SESSION["user"] = $user->getId();

        header('Location: /profile');
        return;
    }

    public function mainPage()
    {
        if(isset($_SESSION["user"])) {
            $html = $this->showAllTweets();
            $html .= $this->render('newTweet');
            return $html;
        } else {
            header('Location: /login');
            return;
        }
    }

    public function showAllTweets()
    {

        DB::init();
        $html = "<table><tbody><tr><th>User</th><th>Tweet</th><th>Date</th></tr>";
        $tweets = Tweet::loadAllTweets(DB::$conn);
        foreach ($tweets as $tweet) {
            $html .= "<tr><td>";
            $html .= User::loadById(DB::$conn,$tweet->getUserId())->getEmail();
            $html .= "</td>";
            $html .= "<td><a href=comment.php?tweet=".$tweet->getId().">";
            $html .= $tweet->getText();
            $html .= "</a></td><td>";
            $html .= $tweet->getCreationDate();
            $html .= "</td></tr>";
        }
        $html .= "</tbody></table>";
        return $html;


    }

    public function createTweet()
    {
        if (isset($_POST['tweet'])) {
            if (strlen($_POST['text']) < 1) {
                echo "Cannot send an empty tweet";
                return false;
            }
            $tweet = new Tweet();
            $tweet->create();
            $tweet->setText($_POST['text']);
            $tweet->setUserID($_SESSION["user"]);
            $tweet->setCreationDate(date("Y-m-d H:i:s"));
            $tweet->saveToDB(DB::$conn);
            echo "Tweet added";
            echo "<meta http-equiv='refresh' content='0'>";
            return $this->showAllTweets();

            }
        }

//        try {
//            $tweet->saveToDB(DB::$conn);
//        } catch (\Exception $e) {
//            return $e->getMessage();
//        }










}