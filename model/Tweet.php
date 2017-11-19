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
        $stmt = $conn->query("SELECT * FROM tweets WHERE id = $id");
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





//    static public function loadTweetsByUserID(\PDO $conn, $userID) {
//        $stmt = $conn->prepare('SELECT * FROM tweets WHERE id=:userID');
//        $res = $stmt->execute(['userID'=>$userID]);
//        if($res && $stmt->rowCount() > 0) {
//            $row = $stmt->fetch();
//            $tweet = new Tweet();
//            $tweet->id = $row["id"];
//            $tweet->setEmail($row["email"])
//                ->setDirectPass($row["pass"]);
//            return $tweet;
//        }
//        return null;
//    }

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

//    public function tweetsToArray()
//    {
//        return [
//            'id' => $this->getId(),
//            'userID' => $this->getUserID(),
//            'text' => $this->getText(),
//            'creationDate' => $this->getCreationDate()
//        ];
//    }

}