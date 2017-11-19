<?php
class Comment
{
    private $id;
    private $text;
    private $tweetID;
    private $userID;

    public function __construct()
    {
        $this->id = -1;
        $this->text = null;
        $this->tweetID = null;
        $this->userID = null;
    }

    public function create()
    {
        $comment = new Comment;

        $comment->setText($_POST['text']);
        $comment->setUserID($_SESSION["user"]);
        $comment->setTweetID($_GET['tweet']);

        return $comment;

    }

    public function saveToDB(\PDO $conn)
    {
        if(isset($_SESSION['user']))
        {
            $stmt = $conn->prepare(
                'INSERT INTO comments (text, tweetID, userID) VALUES (:text, :tweetID, :userID)'
            );
            $comment = [
                'text' => $this->getText(),
                'tweetID' => $this->getTweetID(),
                'userID' => $this->getUserID()
            ];
            $stmt->execute($comment);
        } return false;
    }

//getters and setters

    public function getId()
    {
        return $this->id;
    }

    public function getText()
    {
        return $this->text;
    }

    public function setText($text)
    {
        $this->text = $text;
    }

    public function getTweetID()
    {
        return $this->tweetID;
    }

    public function setTweetID($tweetID)
    {
        $this->tweetID = $tweetID;
    }

    public function getUserID()
    {
        return $this->userID;
    }

    public function setUserID($userID)
    {
        $this->userID = $userID;
    }


}