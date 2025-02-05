<?php
class Database {
    private static $host = "localhost";
    private static $dbname = "worms_tournament";
    private static $username = "root";
    private static $password = "";
    private static $pdo = null;

    public static function connect() {
        if (self::$pdo == null) {
            try {
                self::$pdo = new PDO("mysql:host=" . self::$host . ";dbname=" . self::$dbname, self::$username, self::$password);
                self::$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } catch (PDOException $e) {
                throw new DataBaseException("Error to connecto into database.\nError specs: "+$e->getMessage());
            }
        }
        return self::$pdo;
    }
}
?>