<!DOCTYPE html>
<html lang="hr">
<head>
  <meta charset="UTF-8">
  <title>MP | Dashboard</title>
  <link rel="icon" href="<?php echo BASE_URL; ?>assets/images/favicon.svg" type="image/svg+xml">
  <link rel="stylesheet" href="<?php echo BASE_URL; ?>assets/css/style.css">
  
</head>
<body>
  <?php require APP_PATH . "/Views/layouts/nav.php"; ?>
  <main>
    <div class="page-header">
      <h1>Dobrodošao, <?php echo htmlspecialchars($_SESSION["username"]); ?>!</h1>
    </div>

    <div class="stats-grid">
      <div class="stat-card">
        <span class="stat-number"><?php echo $stats["totalUsers"]; ?></span>
        <span class="stat-label">Korisnika</span>
      </div>
      <div class="stat-card">
        <span class="stat-number"><?php echo $stats["totalCars"]; ?></span>
        <span class="stat-label">Automobila ukupno</span>
      </div>
      <div class="stat-card">
        <span class="stat-number"><?php echo $stats["availableCars"]; ?></span>
        <span class="stat-label">Na prodaju</span>
      </div>
      <div class="stat-card">
        <span class="stat-number"><?php echo $stats["pendingCars"]; ?></span>
        <span class="stat-label">Čeka potvrdu</span>
      </div>
      <div class="stat-card">
        <span class="stat-number"><?php echo $stats["soldCars"]; ?></span>
        <span class="stat-label">Prodano</span>
      </div>
    </div>

    <div class="page-header">
      <h2>Zahtjevi za kupnju koji čekaju potvrdu</h2>
    </div>

    <?php if (empty($pendingRequests)): ?>
      <p class="empty-message">Trenutno nema zahtjeva za kupnju.</p>
    <?php else: ?>
      <table>
        <thead>
          <tr>
            <th>Automobil</th>
            <th>Kupac</th>
            <th>Cijena</th>
            <th>Akcije</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($pendingRequests as $car): ?>
            <tr>
              <td><?php echo htmlspecialchars($car["brand"] . " " . $car["model"]); ?></td>
              <td><?php echo htmlspecialchars($car["owner_username"]); ?></td>
              <td><?php echo number_format($car["price"], 2); ?> €</td>
              <td class="actions">
                <a href="<?php echo url("cars/approve?id=" . $car["id"]); ?>" class="button">Potvrdi</a>
                <a href="<?php echo url("cars/reject?id=" . $car["id"]); ?>" class="button">Odbij</a>
              </td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    <?php endif; ?>
  </main>
</body>
</html>
