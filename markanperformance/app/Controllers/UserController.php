<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Core\Validator;
use App\Models\User;

class UserController extends Controller
{
    private User $userModel;

    public function __construct()
    {
        $this->userModel = new User();
    }

    public function index(): void
    {
        $this->requireAuth("admin");

        $users = $this->userModel->all();

        $this->view("users/index", ["users" => $users]);
    }

    public function create(): void
    {
        $this->requireAuth("admin");

        $error   = "";
        $success = "";

        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            $username = filter_input(INPUT_POST, "username", FILTER_SANITIZE_SPECIAL_CHARS);
            $password = filter_input(INPUT_POST, "password", FILTER_DEFAULT);
            $role     = filter_input(INPUT_POST, "role", FILTER_SANITIZE_SPECIAL_CHARS);

            $validator = new Validator();
            $validator->required($username, "username", "Korisničko ime je obavezno.")
                ->minLength($username, "username", 4, "Korisničko ime mora imati najmanje 4 znaka.")
                ->required($password, "password", "Lozinka je obavezna.")
                ->minLength($password, "password", 4, "Lozinka mora imati najmanje 4 znaka.")
                ->inArray($role, "role", ["admin", "customer"], "Uloga nije valjana.");

            if ($validator->fails()) {
                $error = $validator->firstError();
            } elseif ($this->userModel->usernameExists($username)) {
                $error = "Korisničko ime već postoji!";
            } else {
                $hash = password_hash($password, PASSWORD_DEFAULT);
                $this->userModel->create($username, $hash, $role);
                $success = "Korisnik uspješno dodan!";
            }
        }

        $this->view("users/create", ["error" => $error, "success" => $success]);
    }

    public function edit(): void
    {
        $this->requireAuth("admin");

        $id      = filter_input(INPUT_GET, "id", FILTER_VALIDATE_INT);
        $error   = "";
        $success = "";

        $user = $id ? $this->userModel->findById($id) : null;

        if (!$user) {
            $this->redirect("users");
        }

        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            $username = filter_input(INPUT_POST, "username", FILTER_SANITIZE_SPECIAL_CHARS);
            $password = filter_input(INPUT_POST, "password", FILTER_DEFAULT);
            $role     = filter_input(INPUT_POST, "role", FILTER_SANITIZE_SPECIAL_CHARS);

            $validator = new Validator();
            $validator->required($username, "username", "Korisničko ime je obavezno.")
                ->minLength($username, "username", 4, "Korisničko ime mora imati najmanje 4 znaka.")
                ->inArray($role, "role", ["admin", "customer"], "Uloga nije valjana.");

            if (!empty($password)) {
                $validator->minLength($password, "password", 4, "Lozinka mora imati najmanje 4 znaka.");
            }

            if ($validator->fails()) {
                $error = $validator->firstError();
            } else {
                $hash = !empty($password) ? password_hash($password, PASSWORD_DEFAULT) : null;
                $this->userModel->update($id, $username, $role, $hash);
                $success          = "Korisnik uspješno ažuriran!";
                $user["username"] = $username;
                $user["role"]     = $role;
            }
        }

        $this->view("users/edit", ["user" => $user, "error" => $error, "success" => $success]);
    }

    public function delete(): void
    {
        $this->requireAuth("admin");

        $id = filter_input(INPUT_GET, "id", FILTER_VALIDATE_INT);

        if ($id) {
            $this->userModel->delete($id);
        }

        $this->redirect("users");
    }
}
