<?php
class GameRepository {

    public static function save(Game $game) {
        try {
            $pdo = Database::connect();
            
            if ($game->id) {
                $stmt = $pdo->prepare("UPDATE game SET 	game_date = ? WHERE id = ?");
                $stmt->execute([$game->date, $game->id]);
            } else {
                $stmt = $pdo->prepare("INSERT INTO game (game_date) VALUES (?)");
                $stmt->execute([$game->date]);
                $game->id = $pdo->lastInsertId();
            }
            return $game;
        } catch (PDOException $e) {
            throw new Exception("Error al guardar la partida: " . $e->getMessage());
        }
    }


    public static function findById($id) {
        try {
            $pdo = Database::connect();
            $stmt = $pdo->prepare("SELECT * FROM game WHERE id = ?");
            $stmt->execute([$id]);
            $data = $stmt->fetch(PDO::FETCH_ASSOC);
            return $data ? new Game($data['id'], $data['date']) : null;
        } catch (PDOException $e) {
            throw new Exception("Error al buscar partida por ID: " . $e->getMessage());
        }
    }

    public static function findByDate($date) {
        try {
            $pdo = Database::connect();
            $stmt = $pdo->prepare("SELECT * FROM game WHERE date = ?");
            $stmt->execute([$date]);
            $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return array_map(fn($g) => new Game($g['id'], $g['date']), $data);
        } catch (PDOException $e) {
            throw new Exception("Error al buscar partidas por fecha: " . $e->getMessage());
        }
    }

    public static function deleteById($id) {
        try {
            $pdo = Database::connect();
            $stmt = $pdo->prepare("DELETE FROM game WHERE id = ?");
            $stmt->execute([$id]);
            
            if ($stmt->rowCount() === 0) {
                throw new Exception("No se encontró ninguna partida con ID: $id");
            }
        } catch (PDOException $e) {
            throw new Exception("Error al eliminar partida: " . $e->getMessage());
        }
    }

    public static function findBetweenDates($startDate, $endDate) {
        try {
            $pdo = Database::connect();
            $stmt = $pdo->prepare("SELECT * FROM game WHERE date BETWEEN ? AND ?");
            $stmt->execute([$startDate, $endDate]);
            $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return array_map(fn($g) => new Game($g['id'], $g['date']), $data);
        } catch (PDOException $e) {
            throw new Exception("Error al buscar partidas entre fechas: " . $e->getMessage());
        }
    }
}


?>