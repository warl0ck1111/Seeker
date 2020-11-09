<?php
class users
{
	private $id;
	private $name;
	private $email;
	private $loginStatus;
	private $lastLogin;
	public $dbConn;

	function setId($id)
	{
		$this->id = $id;
	}
	function getId()
	{
		return $this->id;
	}
	function setName($name)
	{
		$this->name = $name;
	}
	function getName()
	{
		return $this->name;
	}
	function setEmail($email)
	{
		$this->email = $email;
	}
	function getEmail()
	{
		return $this->email;
	}
	function setLoginStatus($loginStatus)
	{
		$this->loginStatus = $loginStatus;
	}
	function getLoginStatus()
	{
		return $this->loginStatus;
	}
	function setLastLogin()
	{
		$this->lastLogin = date("y-m-d h:i:s");
	}
	function getLastLogin()
	{
		return $this->lastLogin;
	}

	public function __construct()
	{
		require_once("DbConnect.php");
		$db = new DbConnect();
		$this->dbConn = $db->connect();
	}

	public function getUserByEmail()
	{
		$stmt = $this->dbConn->prepare('SELECT * FROM users WHERE email = :email');
		$stmt->bindParam(':email', $this->email);
		try {
			if ($stmt->execute()) {
				$user = $stmt->fetch(PDO::FETCH_ASSOC);
			}
		} catch (Exception $e) {
			echo $e->getMessage();
		}
		return $user;
	}

	

	public function getUserById()
	{
		$stmt = $this->dbConn->prepare('SELECT * FROM users WHERE user_id = :id');
		$stmt->bindParam(':id', $this->id);
		try {
			if ($stmt->execute()) {
				$user = $stmt->fetch(PDO::FETCH_ASSOC);
			}
		} catch (Exception $e) {
			echo $e->getMessage();
		}
		return $user;
	}

	public function updateLoginStatus()
	{
		$stmt = $this->dbConn->prepare('UPDATE users SET login_status = :loginStatus, last_login = :lastLogin WHERE user_id = :id');
		$stmt->bindParam(':loginStatus', $this->loginStatus);
		$stmt->bindParam(':lastLogin', $this->lastLogin);
		$stmt->bindParam(':id', $this->id);
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

	public function getAllUsers()
	{
		$stmt = $this->dbConn->prepare("SELECT * FROM users");
		$stmt->execute();
		$users = $stmt->fetchAll(PDO::FETCH_ASSOC);
		return $users;
	}
}
