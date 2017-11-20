<?php

class Message
{
    private $id;
    private $senderID;
    private $receiverID;
    private $text;
    private $isread;
    private $creationDate;

    public function __construct()
    {
        $this->id = -1;
        $this->senderID = null;
        $this->receiverID = null;
        $this->text = null;
        $this->creationDate = null;
    }

    public function create()
    {
        $message = new Message;

        $message->setText($_POST['text']);
        $message->setSenderID($_SESSION["user"]);
        $message->setReceiverID($_SESSION["user"]);
        $message->setCreationDate(date("Y-m-d H:i:s"));
        $message->setIsread("0");

        return $message;

    }

    public function saveToDB(\PDO $conn)
    {
        if(isset($_SESSION['user']))
        {
            $stmt = $conn->prepare(
                'INSERT INTO messages (senderID, receiverID, text, creationDate, isread) VALUES (:senderID, :receiverID :text, :creationDate, :isread)'
            );
            $message = [
                'senderID' => $this->getSenderID(),
                'receiverID' => $this->getReceiverID(),
                'text' => $this->getText(),
                'creationDate' => $this->getCreationDate(),
                'isread' => $this->getIsread()
            ];
            $stmt->execute($message);
        } return false;
    }



    public function getSenderID()
    {
        return $this->senderID;
    }

    public function setSenderID($senderID)
    {
        $this->senderID = $senderID;
    }

    public function getReceiverID()
    {
        return $this->receiverID;
    }

    public function setReceiverID($receiverID)
    {
        $this->receiverID = $receiverID;
    }

    public function getText()
    {
        return $this->text;
    }

    public function setText($text)
    {
        $this->text = $text;
    }

    public function getIsread()
    {
        return $this->isread;
    }

    public function setIsread($isread)
    {
        $this->isread = $isread;
    }

    public function getCreationDate()
    {
        return $this->creationDate;
    }

    public function setCreationDate($creationDate)
    {
        $this->creationDate = $creationDate;
    }

    public function getId(): int
    {
        return $this->id;
    }




}
