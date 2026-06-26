<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Core\Validator;
use App\Models\Car;

class CarController extends Controller
{
    private Car $carModel;

    private const UPLOAD_DIR = "/assets/images/cars/";

    public function __construct()
    {
        $this->carModel = new Car();
    }

    public function index(): void
    {
        $this->requireAuth();

        $cars = $this->carModel->all();

        $this->view("cars/index", ["cars" => $cars]);
    }

    public function create(): void
    {
        $this->requireAuth("admin");

        $error   = "";
        $success = "";

        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            [$valid, $error, $data] = $this->validateCarInput();

            if ($valid) {
                $imageName = $this->handleImageUpload();
                $this->carModel->create(
                    $data["brand"],
                    $data["model"],
                    $data["year"],
                    $data["price"],
                    $data["description"],
                    $imageName
                );
                $success = "Automobil uspješno dodan!";
            }
        }

        $this->view("cars/create", ["error" => $error, "success" => $success]);
    }

    public function edit(): void
    {
        $this->requireAuth("admin");

        $id      = filter_input(INPUT_GET, "id", FILTER_VALIDATE_INT);
        $error   = "";
        $success = "";

        $car = $id ? $this->carModel->findById($id) : null;

        if (!$car) {
            $this->redirect("cars");
        }

        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            [$valid, $error, $data] = $this->validateCarInput();

            if ($valid) {
                $imageName = $this->handleImageUpload();
                $this->carModel->update(
                    $id,
                    $data["brand"],
                    $data["model"],
                    $data["year"],
                    $data["price"],
                    $data["description"],
                    $imageName
                );
                $success = "Automobil uspješno ažuriran!";
                $car     = $this->carModel->findById($id);
            }
        }

        $this->view("cars/edit", ["car" => $car, "error" => $error, "success" => $success]);
    }

    public function delete(): void
    {
        $this->requireAuth("admin");

        $id = filter_input(INPUT_GET, "id", FILTER_VALIDATE_INT);

        if ($id) {
            $this->carModel->delete($id);
        }

        $this->redirect("cars");
    }

    public function buy(): void
    {
        $this->requireAuth("customer");

        $id = filter_input(INPUT_GET, "id", FILTER_VALIDATE_INT);

        if ($id) {
            $this->carModel->requestPurchase($id, $this->currentUserId());
        }

        $this->redirect("cars");
    }

    public function approve(): void
    {
        $this->requireAuth("admin");

        $id = filter_input(INPUT_GET, "id", FILTER_VALIDATE_INT);

        if ($id) {
            $this->carModel->approvePurchase($id);
        }

        $this->redirect("dashboard");
    }

    public function reject(): void
    {
        $this->requireAuth("admin");

        $id = filter_input(INPUT_GET, "id", FILTER_VALIDATE_INT);

        if ($id) {
            $this->carModel->rejectPurchase($id);
        }

        $this->redirect("dashboard");
    }

    private function validateCarInput(): array
    {
        $brand       = filter_input(INPUT_POST, "brand", FILTER_SANITIZE_SPECIAL_CHARS);
        $model       = filter_input(INPUT_POST, "model", FILTER_SANITIZE_SPECIAL_CHARS);
        $year        = filter_input(INPUT_POST, "year", FILTER_VALIDATE_INT);
        $price       = filter_input(INPUT_POST, "price", FILTER_VALIDATE_FLOAT);
        $description = filter_input(INPUT_POST, "description", FILTER_SANITIZE_SPECIAL_CHARS);

        $validator = new Validator();
        $validator->required($brand, "brand", "Marka automobila je obavezna.")
            ->maxLength($brand, "brand", 50, "Marka može imati najviše 50 znakova.")
            ->required($model, "model", "Model automobila je obavezan.")
            ->maxLength($model, "model", 50, "Model može imati najviše 50 znakova.")
            ->numeric((string) $year, "year", "Godina proizvodnje mora biti broj.")
            ->min((string) $year, "year", 1950, "Godina proizvodnje nije valjana.")
            ->max((string) $year, "year", (float) (date("Y") + 1), "Godina proizvodnje nije valjana.")
            ->numeric((string) $price, "price", "Cijena mora biti broj.")
            ->min((string) $price, "price", 0, "Cijena ne može biti negativna.");

        $data = [
            "brand"       => $brand,
            "model"       => $model,
            "year"        => (int) $year,
            "price"       => (float) $price,
            "description" => $description ?: "",
        ];

        return [!$validator->fails(), $validator->firstError(), $data];
    }

    private function handleImageUpload(): ?string
    {
        if (empty($_FILES["image"]["name"]) || $_FILES["image"]["error"] !== UPLOAD_ERR_OK) {
            return null;
        }

        $allowedTypes = ["image/jpeg", "image/png", "image/webp"];
        $fileType     = mime_content_type($_FILES["image"]["tmp_name"]);

        if (!in_array($fileType, $allowedTypes, true)) {
            return null;
        }

        $extension   = pathinfo($_FILES["image"]["name"], PATHINFO_EXTENSION);
        $fileName    = bin2hex(random_bytes(8)) . "." . $extension;
        $destination = PUBLIC_PATH . self::UPLOAD_DIR . $fileName;

        move_uploaded_file($_FILES["image"]["tmp_name"], $destination);

        return $fileName;
    }
}
