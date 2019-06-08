<?php

class Db
{
	private static $host = "localhost";
	private static $db_name = "web-tests";
	private static $username = "root";
	private static $password = "";
	private static $conn;

	private function __construct()
	{ }

	public static function getConnection()
	{
		if (!isset(Db::$conn)) {
			try {
				Db::$conn = new PDO("mysql:host=" . DB::$host . ";dbname=" . Db::$db_name, Db::$username, Db::$password, []);
				Db::$conn->exec("set names utf8");
			} catch (PDOException $exception) {
				echo "Connection error: " . $exception->getMessage();
			}
		}

		return Db::$conn;
	}
}
