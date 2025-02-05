<?php
require_once "../models/PersonGame.php";
class PersonGameRepository {
    public static function createPersonGame(PersonGame $personGame) {
        try {
            $pdo = Database::connect();
            $stmt = $pdo->prepare("
                INSERT INTO persongame (
                    person_id, 
                    game_id, 
                    points, 
                    mvp_points, 
                    damage_points, 
                    quantity_points
                ) VALUES (?, ?, ?, ?, ?, ?)
            ");
            $stmt->execute([
                $personGame->person->id,
                $personGame->game->id,
                $personGame->game_points,
                $personGame->mvp_points,
                $personGame->damage_points,
                $personGame->quantity_points
            ]);
            $personGame->id = $pdo->lastInsertId();
            return $personGame->id;
        } catch (PDOException $e) {
            throw new Exception("Error al crear PersonGame: " . $e->getMessage());
        }
    }

    public static function updatePersonGame(PersonGame $personGame) {
        try {
            if (!$personGame->id) {
                throw new Exception("El ID es necesario para actualizar un registro.");
            }
            $pdo = Database::connect();
            $stmt = $pdo->prepare("
                UPDATE persongame SET 
                    person_id = ?,
                    game_id = ?,
                    mvp_points = ?,
                    damage_points = ?,
                    quantity_points = ?
                WHERE id = ?
            ");
            $stmt->execute([
                $personGame->person->id,
                $personGame->game->id,
                $personGame->game_points,
                $personGame->mvp_points,
                $personGame->damage_points,
                $personGame->quantity_points,
                $personGame->id
            ]);
            return true;
        } catch (PDOException $e) {
            throw new Exception("Error al actualizar PersonGame: " . $e->getMessage());
        }
    }

    public static function deleteById($id) {
        try {
            $pdo = Database::connect();
            $stmt = $pdo->prepare("DELETE FROM persongame WHERE id = ?");
            $stmt->execute([$id]);
            if ($stmt->rowCount() === 0) {
                throw new Exception("No se encontró ningún registro con ID: $id");
            }
            return true;
        } catch (PDOException $e) {
            throw new Exception("Error al eliminar PersonGame: " . $e->getMessage());
        }
    }
}
?>