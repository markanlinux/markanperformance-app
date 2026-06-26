<!DOCTYPE html>
<html lang="hr">
<head>
  <meta charset="UTF-8">
  <title>MP | Automobili</title>
  <link rel="icon" href="<?php echo BASE_URL; ?>assets/images/favicon.svg" type="image/svg+xml">
  <link rel="stylesheet" href="<?php echo BASE_URL; ?>assets/css/style.css">
  
</head>
<body>
  <?php require APP_PATH . "/Views/layouts/nav.php"; ?>
  <main>
    <div class="page-header">
      <h1>Automobili</h1>
      <?php if ($_SESSION["role"] === "admin"): ?>
        <a href="<?php echo url("cars/create"); ?>" class="button">Dodaj</a>
      <?php endif; ?>
    </div>

    <div class="cars-grid">
      <?php foreach ($cars as $car): ?>
        <div class="car-card">
          <img
            src="<?php echo BASE_URL . "assets/images/cars/" . ($car["image"] ?: "placeholder.svg"); ?>"
            alt="<?php echo htmlspecialchars($car["brand"] . " " . $car["model"]); ?>"
            class="car-image"
          >
          <div class="car-info">
            <h3><?php echo htmlspecialchars($car["brand"] . " " . $car["model"]); ?></h3>
            <p class="car-year"><?php echo $car["year"]; ?>.</p>
            <p class="car-price"><?php echo number_format($car["price"], 2); ?> €</p>
            <p class="car-description"><?php echo htmlspecialchars($car["description"]); ?></p>

            <?php if ($car["status"] === "available"): ?>
              <span class="badge badge-available">Na prodaju</span>
            <?php elseif ($car["status"] === "pending"): ?>
              <span class="badge badge-pending">Čeka potvrdu</span>
            <?php else: ?>
              <span class="badge badge-sold">Prodano</span>
            <?php endif; ?>

            <div class="car-actions">
              <?php if ($_SESSION["role"] === "admin"): ?>
                <a href="<?php echo url("cars/edit?id=" . $car["id"]); ?>" class="button">Uredi</a>
                <a href="<?php echo url("cars/delete?id=" . $car["id"]); ?>" class="button" onclick="return confirm('Obrisati ovaj automobil?');">Obriši</a>
              <?php elseif ($car["status"] === "available"): ?>
                <a href="<?php echo url("cars/buy?id=" . $car["id"]); ?>" class="button" onclick="return confirm('Zatražiti kupnju ovog automobila?');">Kupi</a>
              <?php endif; ?>
            </div>
          </div>
        </div>
      <?php endforeach; ?>
    </div>
  </main>
</body>
</html>
