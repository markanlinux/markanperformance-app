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
      <a href="<?php echo url("cars"); ?>" class="button">Pregledaj automobile (<?php echo $availableCarsCount; ?> dostupno)</a>
    </div>

    <div class="page-header">
      <h2>Moja vozila</h2>
    </div>

    <?php if (empty($myCars)): ?>
      <p class="empty-message">Još nisi zatražio kupnju nijednog automobila.</p>
    <?php else: ?>
      <table>
        <thead>
          <tr>
            <th>Automobil</th>
            <th>Godina</th>
            <th>Cijena</th>
            <th>Status</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($myCars as $car): ?>
            <tr>
              <td><?php echo htmlspecialchars($car["brand"] . " " . $car["model"]); ?></td>
              <td><?php echo $car["year"]; ?></td>
              <td><?php echo number_format($car["price"], 2); ?> €</td>
              <td>
                <?php if ($car["status"] === "pending"): ?>
                  <span class="badge badge-pending">Čeka potvrdu</span>
                <?php elseif ($car["status"] === "sold"): ?>
                  <span class="badge badge-sold">Kupljeno</span>
                <?php endif; ?>
              </td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    <?php endif; ?>
  </main>
</body>
</html>
