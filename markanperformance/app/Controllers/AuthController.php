<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Core\Validator;
use App\Models\User;

class AuthController extends Controller
{
    private User $userModel;

    public function __construct()
    {
        $this->userModel = new User();
    }

    public function login(): void
    {
        if (isset($_SESSION["user_id"])) {
            $this->redirect("dashboard");
        }

        $error = "";

        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            $username = filter_input(INPUT_POST, "username", FILTER_SANITIZE_SPECIAL_CHARS);
            $password = filter_input(INPUT_POST, "password", FILTER_DEFAULT);

            $user = $this->userModel->findByUsername($username ?? "");

            if ($user && password_verify($password ?? "", $user["password"])) {
                $_SESSION["user_id"] = $user["id"];
                $_SESSION["username"] = $user["username"];
                $_SESSION["role"] = $user["role"];
                $this->redirect("dashboard");
            } else {
                $error = "Neispravno korisničko ime ili lozinka!";
            }
        }

        $this->view("auth/login", ["error" => $error]);
    }

    public function register(): void
    {
        if (isset($_SESSION["user_id"])) {
            $this->redirect("dashboard");
        }

        $error   = "";
        $success = "";

        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            $username = filter_input(INPUT_POST, "username", FILTER_SANITIZE_SPECIAL_CHARS);
            $password = filter_input(INPUT_POST, "password", FILTER_DEFAULT);

            $validator = new Validator();
            $validator->required($username, "username", "Korisničko ime je obavezno.")
                ->minLength($username, "username", 4, "Korisničko ime mora imati najmanje 4 znaka.")
                ->required($password, "password", "Lozinka je obavezna.")
                ->minLength($password, "password", 4, "Lozinka mora imati najmanje 4 znaka.");

            if ($validator->fails()) {
                $error = $validator->firstError();
            } elseif ($this->userModel->usernameExists($username)) {
                $error = "Korisničko ime već postoji!";
            } else {
                $hash = password_hash($password, PASSWORD_DEFAULT);
                $this->userModel->create($username, $hash, "customer");
                $success = "Registracija uspješna! Možeš se prijaviti.";
            }
        }

        $this->view("auth/register", ["error" => $error, "success" => $success]);
    }

    public function logout(): void
    {
        $_SESSION = [];
        session_destroy();
        $this->redirect("auth/login");
    }
}
