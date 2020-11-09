<?php 

#TODO: check all setters is IsEmpty 2 of the properties declared are useless because they are duplicate
class Chatrooms
{
    private $id;
	private $userId;
	private $msg;
	private $matchedId, $senderId,$receiverId;
	private $created_on;
    public $dbConn;
	

	function setId($id)
	{
		$this->id = $id;
	}
	function getId()
	{
		return $this->id;
	}
	function setUserId($userId)
	{
		$this->userId = $userId;
	}
	function getUserId()
	{
		return $this->userId;
	}
	function setMsg($msg)
	{
		$this->msg = $msg;
	}
	function getMsg()
	{
		return $this->msg;
	}

	/**
	 * Get the value of receiverId
	 */ 
	public function getReceiverId()
	{
		return $this->receiverId;
	}

	/**
	 * Set the value of receiverId
	 *
	 * @return  self
	 */ 
	public function setReceiverId($receiverId)
	{
		$this->receiverId = $receiverId;

		return $this;
	}

	/**
	 * Get the value of senderId
	 */ 
	public function getSenderId()
	{
		return $this->senderId;
	}

	/**
	 * Set the value of senderId
	 *
	 * @return  self
	 */ 
	public function setSenderId($senderId)
	{
		$this->senderId = $senderId;

		return $this;
	}

	/**
	 * Get the value of matchedId
	 */ 
	public function getMatchedId()
	{
		return $this->matchedId;
	}

	/**
	 * Set the value of matchedId
	 *
	 * @return  self
	 */ 
	public function setMatchedId($matchedId)
	{
		$this->matchedId = $matchedId;

		return $this;
	}

    	function setCreated_on($created_on)
	{
		$this->created_on = $created_on;
	}
	function getCreated_on()
	{
		return $this->created_on;
	}
	
    public function __construct()
	{
		require_once("DbConnect.php");
		$db = new DbConnect();
		$this->dbConn = $db->connect();

	}

	function saveMsg(){
		$sql = "INSERT INTO `message`( `message_id`, `messageString`, `sender`, `receiver`, `timestamp`)
		 							VALUES (null, :msg, :senderId, :receiverId, :created_on)";
		$stmt = $this->dbConn->prepare($sql);
		$stmt->bindParam(":msg", $this->msg);
		$stmt->bindParam(":senderId", $this->senderId);
		$stmt->bindParam(":receiverId", $this->receiverId);
		$stmt->bindParam(":created_on", $this->created_on);
	
		try {
			if ($stmt->execute()) {
				return true;
			} else {
				return false;
			}
		} catch (Exception $e) {
			echo $e->getMessage();
		}
	}

	function getAllChatRooms(){
		$stmt = $this->dbConn->prepare("SELECT c.*, u.name FROM chatrooms c
		 JOIN users u On (c.userId = u.id) ");
		$stmt->execute();
		$msgs = $stmt->fetchAll(PDO::FETCH_ASSOC);
		return $msgs;
	}

	function getChats($sId, $rId){
		$stmt = $this->dbConn->prepare("SELECT m.*, u.u_name,u.profile_image FROM message m JOIN users u ON (m.sender = u.user_id)  where (m.sender = '$sId' AND m.receiver ='$rId' ) OR (m.receiver ='$sId' AND m.sender ='$rId' )") ;
		$stmt->execute();
		$chats = $stmt->fetchAll(PDO::FETCH_ASSOC);
		return $chats;
	}



	
}



?>