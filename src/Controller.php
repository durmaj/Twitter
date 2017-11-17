<?php

require_once __DIR__."/DB.php";
require_once __DIR__."/../model/User.php";
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
            return $this->showProfile();
        } else {
            return "no";
        }
    }

    public function updateProfile() {
        DB::init();

        if(isset($_SESSION["user"])) {
            $user = User::loadById(DB::$conn, $_SESSION["user"]);
            $formData = [
                $_POST['email'],
                $_POST['pass'],
            ];

//            var_dump($user->getPass());die();

            if (!password_verify($_POST['oldPass'], $user->getPass()) || strlen($_POST['oldPass']) < 1)
            {
                $_SESSION['errors']="wrongPass";
                return $this->showProfile();
            } else {
                echo "zalogowany";
                die();
            }
            $user->setEmail($_POST["email"]);
            $user->saveToDB(DB::$conn);
            return $this->showProfile();
        }
        return $this->showLogin();
    }

    public function logout() {
        session_unset();
        return $this->showLogin();
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
}