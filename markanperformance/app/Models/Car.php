<?php

namespace App\Models;

use App\Core\Model;

class Car extends Model
{
    public function all(): array
    {
        $sql = "SELECT cars.*, users.username AS owner_username
                FROM cars
                LEFT JOIN users ON cars.owner_id = users.id
                ORDER BY cars.id DESC";

        $result = $this->db->query($sql);

        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function findById(int $id): ?array
    {
        $stmt = $this->db->prepare(
            "SELECT cars.*, users.username AS owner_username
             FROM cars
             LEFT JOIN users ON cars.owner_id = users.id
             WHERE cars.id = ?"
        );
        $stmt->bind_param("i", $id);
        $stmt->execute();

        $car = $stmt->get_result()->fetch_assoc();

        return $car ?: null;
    }

    public function findByOwner(int $ownerId): array
    {
        $stmt = $this->db->prepare(
            "SELECT * FROM cars WHERE owner_id = ? ORDER BY id DESC"
        );
        $stmt->bind_param("i", $ownerId);
        $stmt->execute();

        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    public function countByStatus(string $status): int
    {
        $stmt = $this->db->prepare("SELECT COUNT(*) AS total FROM cars WHERE status = ?");
        $stmt->bind_param("s", $status);
        $stmt->execute();

        return (int) $stmt->get_result()->fetch_assoc()["total"];
    }

    public function create(
        string $brand,
        string $model,
        int $year,
        float $price,
        string $description,
        ?string $image
    ): void {
        $stmt = $this->db->prepare(
            "INSERT INTO cars (brand, model, year, price, description, image, status)
             VALUES (?, ?, ?, ?, ?, ?, 'available')"
        );
        $stmt->bind_param("ssidss", $brand, $model, $year, $price, $description, $image);
        $stmt->execute();
    }

    public function update(
        int $id,
        string $brand,
        string $model,
        int $year,
        float $price,
        string $description,
        ?string $image
    ): void {
        if ($image !== null) {
            $stmt = $this->db->prepare(
                "UPDATE cars SET brand = ?, model = ?, year = ?, price = ?, description = ?, image = ?
                 WHERE id = ?"
            );
            $stmt->bind_param("ssidssi", $brand, $model, $year, $price, $description, $image, $id);
        } else {
            $stmt = $this->db->prepare(
                "UPDATE cars SET brand = ?, model = ?, year = ?, price = ?, description = ?
                 WHERE id = ?"
            );
            $stmt->bind_param("ssidsi", $brand, $model, $year, $price, $description, $id);
        }

        $stmt->execute();
    }

    public function delete(int $id): void
    {
        $stmt = $this->db->prepare("DELETE FROM cars WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
    }

    public function requestPurchase(int $carId, int $userId): void
    {
        $stmt = $this->db->prepare(
            "UPDATE cars SET status = 'pending', owner_id = ? WHERE id = ? AND status = 'available'"
        );
        $stmt->bind_param("ii", $userId, $carId);
        $stmt->execute();
    }

    public function approvePurchase(int $carId): void
    {
        $stmt = $this->db->prepare(
            "UPDATE cars SET status = 'sold' WHERE id = ? AND status = 'pending'"
        );
        $stmt->bind_param("i", $carId);
        $stmt->execute();
    }

    public function rejectPurchase(int $carId): void
    {
        $stmt = $this->db->prepare(
            "UPDATE cars SET status = 'available', owner_id = NULL WHERE id = ? AND status = 'pending'"
        );
        $stmt->bind_param("i", $carId);
        $stmt->execute();
    }
}
