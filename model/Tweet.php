<?php

class Tweet
{
    private $id;
    private $userID;
    private $text;
    private $creationDate;

    public function __construct()
    {
        $this->id = -1;
        $this->userID = null;
        $this->text = null;
        $this->creationDate = null;
    }

    public function create()
    {
        $tweet = new Tweet;

        $tweet->setText($_POST['text']);
        $tweet->setUserID($_SESSION["user"]);
        $tweet->setCreationDate(date("Y-m-d H:i:s"));

        return $tweet;

    }

    public function saveToDB(\PDO $conn)
    {
        if(isset($_SESSION['user']))
        {
            $stmt = $conn->prepare(
                'INSERT INTO tweets (userID, text, creationDate) VALUES (:userID, :text, :creationDate)'
            );
            $tweet = [
                'userID' => $this->getUserID(),
                'text' => $this->getText(),
                'creationDate' => $this->getCreationDate()
            ];
            $stmt->execute($tweet);
        } return false;
    }

    static public function loadAllTweets(\PDO $conn)
    {
        $stmt = $conn->query('SELECT * FROM tweets ORDER BY creationDate DESC');
        $res = [];
        foreach ($stmt->fetchAll() as $row) {
            $tweet = new Tweet();
            $tweet->id = $row["id"];
            $tweet->setUserID($row["userID"]);
            $tweet->setText($row["text"]);
            $tweet->setCreationDate($row["creationDate"]);
            $res[] = $tweet;
        }
        return $res;
    }

    static public function loadTweetById(\PDO $conn, $id)
    {
        $stmt = $conn->prepare('SELECT * FROM Tweets WHERE id=:id');
        $res = $stmt->execute(['id' => $id]);
        if ($res && $stmt->rowCount() > 0) {
            $row = $stmt->fetch();
            $tweet = new Tweet();
            $tweet->id = $row["id"];
            $tweet->setText($row["text"]);
            $tweet->setUserId($row["userID"]);
            $tweet->setCreationDate($row["creationDate"]);
            return $tweet;
        } else {
            return null;
        }
    }

    static public function loadAllTweetsByUser(\PDO $conn, $id)
    {
        $stmt = $conn->query("SELECT * FROM tweets WHERE userID=$id ORDER BY creationDate DESC");
        $res = [];
        foreach ($stmt->fetchAll() as $row) {
            $tweet = new Tweet();
            $tweet->id = $row["id"];
            $tweet->setUserID($row["userID"]);
            $tweet->setText($row["text"]);
            $tweet->setCreationDate($row["creationDate"]);
            $res[] = $tweet;
        }
        return $res;
    }

    static public function getNumberOfComments(\PDO $conn, $id)
    {
        $stmt = $conn->query("SELECT * FROM comments WHERE tweetID=$id");
        $comments = $stmt->rowCount();

        return $comments;

    }

// getters & setters

    public function getId()
    {
        return $this->id;
    }

    public function getUserID()
    {
        return $this->userID;
    }

    public function setUserID($userID)
    {
        $this->userID = $userID;
    }

    public function getText()
    {
        return $this->text;
    }

    public function setText($text)
    {
        $this->text = $text;
    }

    public function getCreationDate()
    {
        return $this->creationDate;
    }

    public function setCreationDate($creationDate)
    {
        $this->creationDate = $creationDate;
    }

    public function tweetsToArray()
    {
        return [
            'id' => $this->getId(),
            'userID' => $this->getUserID(),
            'text' => $this->getText(),
            'creationDate' => $this->getCreationDate()
        ];
    }

}