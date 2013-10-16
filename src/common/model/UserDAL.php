<?php

namespace common\model;

require_once("login/model/UserCredentials.php");

class UserDAL {
	private $pdo;

	public function __construct() {
		$this->pdo = new \PDO("mysql:host=localhost;dbname=database", "1dv408", "mypassword");
	}

	public static function create(\login\model\UserCredentials $user) {
		$db = new UserDAL();
		$db->createUser($user);
	}

	public static function find(\login\model\UserCredentials $user) {
		$db = new UserDAL();
		return $db->findUser($user);
	}

	private function createUser(\login\model\UserCredentials $user) {
		$query = $this->pdo->prepare("INSERT INTO `users` (`username`, `password`)
																	VALUES (:username, :password)");
		$query->execute(array("username" => $user->getUserName(),
													"password" => $user->getPassword()));
	}

	private function findUser(\login\model\UserCredentials $user) {
		$query = $this->pdo->prepare("SELECT * FROM users WHERE username = :username LIMIT 1");
		$query->execute(array(":username" => $user->getUserName()));
		$result = $query->fetch(\PDO::FETCH_ASSOC);

		if ($query->rowCount() < 1)
			throw new \Exception("no matching user");

		$password = \login\model\Password::fromEncryptedString($result["password"]);
		return \login\model\UserCredentials::create($result["username"],
																								$password->__toString());
	}
}
