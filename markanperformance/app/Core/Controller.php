<?php

namespace App\Core;

abstract class Controller
{
    protected function view(string $view, array $data = []): void
    {
        extract($data);

        $viewPath = APP_PATH . "/Views/" . $view . ".php";

        if (!file_exists($viewPath)) {
            die("Pogled ne postoji: " . $view);
        }

        require $viewPath;
    }

    protected function redirect(string $route): void
    {
        header("Location: " . url($route));
        exit;
    }

    protected function requireAuth(?string $role = null): void
    {
        if (!isset($_SESSION["user_id"])) {
            $this->redirect("auth/login");
        }

        if ($role !== null && $_SESSION["role"] !== $role) {
            $this->redirect("dashboard");
        }
    }

    protected function currentUserId(): ?int
    {
        return $_SESSION["user_id"] ?? null;
    }

    protected function currentRole(): ?string
    {
        return $_SESSION["role"] ?? null;
    }
}
