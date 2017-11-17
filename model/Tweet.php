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

    static public function loadTweetsByUserID(\PDO $conn, $userID) {
        $stmt = $conn->prepare('SELECT * FROM users WHERE id=:userID');
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




}