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

    static public function loadAllTweets(\PDO $conn) {
        $stmt = $conn->query('SELECT * FROM tweets ORDER BY creationDate DESC');
        $res = [];
        foreach ($stmt->fetchAll() as $row) {
            $tweet = new Tweet();
            $tweet->id = $row["id"];
            $tweet->setUserID($row["userID"])
                ->setText($row["text"])
                ->setCreationDate($row["creationDate"]);
            $res[] = $tweet;
        }
        var_dump($res);
        return $res;
    }

    static public function loadTweetsByUserID(\PDO $conn, $userID) {
        $stmt = $conn->prepare('SELECT * FROM tweets WHERE id=:userID');
        $res = $stmt->execute(['userID'=>$userID]);
        if($res && $stmt->rowCount() > 0) {
            $row = $stmt->fetch();
            $tweet = new Tweet();
            $tweet->id = $row["id"];
            $tweet->setEmail($row["email"])
                ->setDirectPass($row["pass"]);
            return $tweet;
        }
        return null;
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

    public function toArray()
    {
        return [
            'id' => $this->getId(),
            'userID' => $this->getUserID(),
            'text' => $this->getText(),
            'creationDate' => $this->getCreationDate()
        ];
    }

}