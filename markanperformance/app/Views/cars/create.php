<!DOCTYPE html>
<html lang="hr">
<head>
  <meta charset="UTF-8">
  <title>MP | Dodaj automobil</title>
  <link rel="icon" href="<?php echo BASE_URL; ?>assets/images/favicon.svg" type="image/svg+xml">
  <link rel="stylesheet" href="<?php echo BASE_URL; ?>assets/css/style.css">
  
</head>
<body>
  <?php require APP_PATH . "/Views/layouts/nav.php"; ?>
  <main>
    <div class="page-header">
      <h1>Dodaj automobil</h1>
      <a href="<?php echo url("cars"); ?>" class="button">Natrag</a>
    </div>
    <div class="form-container">
      <form method="POST" enctype="multipart/form-data">
        <input type="text" name="brand" placeholder="Marka (npr. Porsche)" required>
        <input type="text" name="model" placeholder="Model (npr. 911 Turbo S)" required>
        <input type="number" name="year" placeholder="Godina proizvodnje" required>
        <input type="number" name="price" step="0.01" placeholder="Cijena (€)" required>
        <textarea name="description" placeholder="Opis automobila" rows="4"></textarea>
        <input type="file" name="image" accept="image/png, image/jpeg, image/webp">
        <button type="submit" class="button">Dodaj</button>
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
