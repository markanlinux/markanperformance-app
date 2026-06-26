<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Models\User;
use App\Models\Car;

class DashboardController extends Controller
{
    private User $userModel;
    private Car $carModel;

    public function __construct()
    {
        $this->userModel = new User();
        $this->carModel  = new Car();
    }

    public function index(): void
    {
        $this->requireAuth();

        if ($this->currentRole() === "admin") {
            $this->adminDashboard();
        } else {
            $this->customerDashboard();
        }
    }

    private function adminDashboard(): void
    {
        $stats = [
            "totalUsers"    => count($this->userModel->all()),
            "totalCars"     => count($this->carModel->all()),
            "availableCars" => $this->carModel->countByStatus("available"),
            "pendingCars"   => $this->carModel->countByStatus("pending"),
            "soldCars"      => $this->carModel->countByStatus("sold"),
        ];

        $pendingRequests = array_filter(
            $this->carModel->all(),
            fn ($car) => $car["status"] === "pending"
        );

        $this->view("dashboard/admin", [
            "stats"           => $stats,
            "pendingRequests" => $pendingRequests,
        ]);
    }

    private function customerDashboard(): void
    {
        $myCars = $this->carModel->findByOwner($this->currentUserId());

        $availableCars = array_filter(
            $this->carModel->all(),
            fn ($car) => $car["status"] === "available"
        );

        $this->view("dashboard/customer", [
            "myCars"            => $myCars,
            "availableCarsCount" => count($availableCars),
        ]);
    }
}
