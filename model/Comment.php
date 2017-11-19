<?php
class Comment
{
    private $id;
    private $text;
    private $tweetID;
    private $userID;
    private $creationDate;

    public function __construct()
    {
        $this->id = -1;
        $this->text = null;
        $this->tweetID = null;
        $this->userID = null;
        $this->creationDate = null;

    }

    public function create()
    {
        $comment = new Comment;

        $comment->setText($_POST['text']);
        $comment->setUserID($_SESSION["user"]);
        $comment->setTweetID($_GET['tweet']);
        $comment->setCreationDate(date("Y-m-d H:i:s"));


        return $comment;

    }

    public function saveToDB(\PDO $conn)
    {
        if(isset($_SESSION['user']))
        {
            $stmt = $conn->prepare(
                'INSERT INTO comments (text, tweetID, userID, creationDate) VALUES (:text, :tweetID, :userID, :creationDate)'
            );
            $comment = [
                'text' => $this->getText(),
                'tweetID' => $this->getTweetID(),
                'userID' => $this->getUserID(),
                'creationDate' => $this->getCreationDate()
            ];
            $stmt->execute($comment);
        } return false;
    }

    public function loadCommentsByTweetID(\PDO $conn, $id)
    {
        $stmt = $conn->query("SELECT * FROM comments WHERE tweetID=$id ORDER BY creationDate DESC");
        $res = [];
        foreach ($stmt->fetchAll() as $row) {
            $comment = new Comment();
            $comment->id = $row["id"];
            $comment->setText($row["text"]);
            $comment->setTweetID($row["tweetID"]);
            $comment->setUserID($row["userID"]);
            $comment->setCreationDate($row["creationDate"]);
            $res[] = $comment;
        }
        return $res;
    }

    public function loadCommentByID(\PDO $conn, $id)
    {
        $stmt = $conn->prepare('SELECT * FROM comments WHERE id=:id');
        $res = $stmt->execute(['id' => $id]);
        if ($res && $stmt->rowCount() > 0) {
            $row = $stmt->fetch();
            $comment = new Comment();
            $comment->id = $row["id"];
            $comment->setText($row["text"]);
            $comment->setTweetID($row["tweetID"]);
            $comment->setUserID($row["userID"]);
            $comment->setCreationDate($row["creationDate"]);

            return $comment;
        } else {
            return null;
        }
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

    public function getCreationDate()
    {
        return $this->creationDate;
    }

    public function setCreationDate($creationDate)
    {
        $this->creationDate = $creationDate;
    }


}