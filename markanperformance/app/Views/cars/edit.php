<!DOCTYPE html>
<html lang="hr">
<head>
  <meta charset="UTF-8">
  <title>MP | Uredi automobil</title>
  <link rel="icon" href="<?php echo BASE_URL; ?>assets/images/favicon.svg" type="image/svg+xml">
  <link rel="stylesheet" href="<?php echo BASE_URL; ?>assets/css/style.css">
  
</head>
<body>
  <?php require APP_PATH . "/Views/layouts/nav.php"; ?>
  <main>
    <div class="page-header">
      <h1>Uredi automobil</h1>
      <a href="<?php echo url("cars"); ?>" class="button">Natrag</a>
    </div>
    <div class="form-container">
      <?php if ($car["image"]): ?>
        <img
          src="<?php echo BASE_URL . "assets/images/cars/" . $car["image"]; ?>"
          alt="<?php echo htmlspecialchars($car["brand"]); ?>"
          class="car-image-preview"
        >
      <?php endif; ?>
      <form method="POST" enctype="multipart/form-data">
        <input type="text" name="brand" value="<?php echo htmlspecialchars($car["brand"]); ?>" required>
        <input type="text" name="model" value="<?php echo htmlspecialchars($car["model"]); ?>" required>
        <input type="number" name="year" value="<?php echo $car["year"]; ?>" required>
        <input type="number" name="price" step="0.01" value="<?php echo $car["price"]; ?>" required>
        <textarea name="description" rows="4"><?php echo htmlspecialchars($car["description"]); ?></textarea>
        <input type="file" name="image" accept="image/png, image/jpeg, image/webp">
        <button type="submit" class="button">Spremi</button>
      </form>
      <?php if ($error): ?>
        <p class="error"><?php echo $error; ?></p>
      <?php endif; ?>
      <?php if ($success): ?>
        <p class="success"><?php echo $success; ?></p>
      <?php endif; ?>
    </div>
  </main>
</body>
</html>
