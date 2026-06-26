<?php

namespace App\Models;

use App\Core\Model;

class User extends Model
{
    public function findByUsername(string $username): ?array
    {
        $stmt = $this->db->prepare(
            "SELECT id, username, password, role FROM users WHERE username = ?"
        );
        $stmt->bind_param("s", $username);
        $stmt->execute();

        $user = $stmt->get_result()->fetch_assoc();

        return $user ?: null;
    }

    public function findById(int $id): ?array
    {
        $stmt = $this->db->prepare(
            "SELECT id, username, role FROM users WHERE id = ?"
        );
        $stmt->bind_param("i", $id);
        $stmt->execute();

        $user = $stmt->get_result()->fetch_assoc();

        return $user ?: null;
    }

    public function all(): array
    {
        $result = $this->db->query("SELECT id, username, role FROM users ORDER BY id ASC");

        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function usernameExists(string $username): bool
    {
        return $this->findByUsername($username) !== null;
    }

    public function create(string $username, string $passwordHash, string $role): void
    {
        $stmt = $this->db->prepare(
            "INSERT INTO users (username, password, role) VALUES (?, ?, ?)"
        );
        $stmt->bind_param("sss", $username, $passwordHash, $role);
        $stmt->execute();
    }

    public function update(int $id, string $username, string $role, ?string $passwordHash = null): void
    {
        if ($passwordHash !== null) {
            $stmt = $this->db->prepare(
                "UPDATE users SET username = ?, password = ?, role = ? WHERE id = ?"
            );
            $stmt->bind_param("sssi", $username, $passwordHash, $role, $id);
        } else {
            $stmt = $this->db->prepare(
                "UPDATE users SET username = ?, role = ? WHERE id = ?"
            );
            $stmt->bind_param("ssi", $username, $role, $id);
        }

        $stmt->execute();
    }

    public function delete(int $id): void
    {
        $stmt = $this->db->prepare("DELETE FROM users WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
    }
}
