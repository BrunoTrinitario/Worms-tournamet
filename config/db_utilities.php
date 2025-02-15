<?php
class Database {
    private static $host = "localhost";
    private static $port = "3535";  // Especificamos el puerto 3535
    private static $dbname = "worms_tournament";
    private static $username = "root";
    private static $password = "";
    private static $pdo = null;

    public static function connect() {
        if (self::$pdo == null) {
            try {
                // Modificamos la cadena de conexión para incluir el puerto
                $dsn = "mysql:host=" . self::$host . ";port=" . self::$port . ";dbname=" . self::$dbname;
                self::$pdo = new PDO($dsn, self::$username, self::$password);
                self::$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } catch (PDOException $e) {
                // Corregimos la concatenación del mensaje de error
                throw new Exception("Error to connect to database.\nError specs: " . $e->getMessage());
            }
        }
        return self::$pdo;
    }
}

?>