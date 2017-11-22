<?php

require_once __DIR__."/DB.php";
require_once __DIR__."/../model/User.php";
require_once __DIR__."/../model/Tweet.php";
require_once __DIR__."/../model/Comment.php";
require_once __DIR__."/../model/Message.php";
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
    public function showNavbar()
    {
        return $this->render('navbar');
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

    public function showMessageForm()
    {
        echo $this->render('messageForm');
        if (isset($_POST['sendMsg'])) {
            if (strlen($_POST['messageText']) < 1) {
                echo "Cannot send an empty comment";
                return false;
            }
            $messageText = $_POST['messageText'];
            $message = new Message();
            $message->create();
            $message->setText($messageText);
            $message->setSenderID($_SESSION["user"]);
            $message->setReceiverID($_GET["user"]);
            $message->setCreationDate(date("Y-m-d H:i:s"));
            $message->setIsread(0);
            try {
                $message->saveToDB(DB::$conn);
                echo "Message sent";
            } catch (\Exception $e) {
                echo "Unable to send message. Encountered problem:".$e->getMessage();
            }
        }
    }


    public function showReceivedMessages()
    {
        DB::init();
        $html = "<h2>Received messages</h2><table><tbody><tr><th>User</th><th>Message</th><th>Date</th></tr>";

        $messages = Message::loadAllMessagesForUser(DB::$conn, $_SESSION['user']);
        foreach ($messages as $message) {
            $senderID = $message->getSenderID();
            $html .= "<tr><td>";
            $html .= "<a href=user?user=".$senderID.">".User::loadById(DB::$conn,$senderID)->getEmail()."</a>";
            $html .= "</td>";
            $html .= "<td><b><a href=msg?message=".$message->getId().">";
            $messagePart = substr($message->getText(), 0, 30);
            $html .= $messagePart;
            $html .= "</a></b></td><td>";
            $html .= $message->getCreationDate();
            $html .= "</td></tr>";
        }


        $html .= "</tbody></table>";

        return $html;

    }

    public function showMessage()
    {
        DB::init();
        $message = Message::loadMessageByID(DB::$conn, $_GET['message']);
        $senderID = $message->getSenderID();

        $html = "<h2>Message from:</h2><table><tbody><tr><th>";
        $html .= User::loadById(DB::$conn,$senderID)->getEmail();
        $html .= "user</th><th>Date</th></tr>";
        $html .= "<td>";
        $html .= $message->getText();
        $html .= "</td><td>";
        $html .= $message->getCreationDate();
        $html .= "</td></tr>";
        $html .= "</tbody></table>";

        return $html;


        //TODO: validation (cannot see other users messages

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
        $html = "<table><tbody><tr><th>User</th><th>Tweet</th><th>Date</th><th>Comments</th></tr>";
        $tweets = Tweet::loadAllTweets(DB::$conn);
        foreach ($tweets as $tweet) {
            $html .= "<tr><td>";
            $html .= "<a href=user?user=".$tweet->getUserId().">".User::loadById(DB::$conn,$tweet->getUserId())->getEmail()."</a>";
            $html .= "</td>";
            $html .= "<td><a href=tweet?tweet=".$tweet->getId().">";
            $html .= $tweet->getText();
            $html .= "</a></td><td>";
            $html .= $tweet->getCreationDate();
            $html .= "</td><td>".$tweet->getNumberOfComments(DB::$conn, $tweet->getId())."</td></tr>";
        }
        $html .= "</tbody></table>";
        return $html;
    }

    public function showUserTweets()
    {

        DB::init();
        $tweets = Tweet::loadAllTweetsByUser(DB::$conn, $_GET['user']);
        $html = "<h1>User ".User::loadById(DB::$conn, $_GET['user'])->getEmail()."</h1><table><tbody><tr><th>Tweet</th><th>Date</th><th>Comments</th></tr>";
        foreach ($tweets as $tweet) {
            $html .= "<tr>";
            $html .= "<td><a href=tweet?tweet=".$tweet->getId().">";
            $html .= $tweet->getText();
            $html .= "</a></td><td>";
            $html .= $tweet->getCreationDate();
            $html .= "</td><td>".$tweet->getNumberOfComments(DB::$conn, $tweet->getId())."</td></tr>";
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


    public function showTweet()
    {
        DB::init();
            $tweet = Tweet::loadTweetById(DB::$conn, $_GET['tweet']);
            $html = "<table><tbody><tr><th>User</th><th>Tweet</th><th>Date</th></tr><tr><td>";
            $html .= User::loadById(DB::$conn,$tweet->getUserId())->getEmail();
            $html .= "</td><td>";
            $html .= $tweet->getText();
            $html .= "</td><td>";
            $html .= $tweet->getCreationDate();
            $html .= "</td></tr>";
            $html .= "</tbody></table>";

//wyświetlanie komentarzy do tweeta

        $comments = "<br><table><tbody><tr>Comments</tr>";
        $existingComments = Comment::loadCommentsByTweetID(DB::$conn, $_GET['tweet']);
            foreach ($existingComments as $key => $comment) {
                $comments .= "<tr><td>";
                $comments .= User::loadById(DB::$conn,$tweet->getUserId())->getEmail();
                $comments .= "</td><td>";
                $comments .= $comment->getText();
                $comments .= "</td><td>";
                $comments .= $comment->getCreationDate();
                $comments .= "</td></tr>";
            }
        $comments .= "</tbody></table>";

            return $html . $comments;
    }

    public function submitComment()
    {
        echo $this->render('comment');
        if (isset($_POST['send'])) {
            if (strlen($_POST['commentText']) < 1) {
                echo "Cannot send an empty comment";
                return false;
            }
            $commentText = $_POST['commentText'];
            $comment = new Comment();
            $comment->create();
            $comment->setText($commentText);
            $comment->setUserID($_SESSION["user"]);
            $comment->setTweetID($_GET['tweet']);
            $comment->setCreationDate(date("Y-m-d H:i:s"));
            $comment->saveToDB(DB::$conn);
            echo "Comment added";
            echo "<meta http-equiv='refresh' content='0'>";
        }
    }

}