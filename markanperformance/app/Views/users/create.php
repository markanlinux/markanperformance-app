<!DOCTYPE html>
<html lang="hr">
<head>
  <meta charset="UTF-8">
  <title>MP | Dodaj korisnika</title>
  <link rel="icon" href="<?php echo BASE_URL; ?>assets/images/favicon.svg" type="image/svg+xml">
  <link rel="stylesheet" href="<?php echo BASE_URL; ?>assets/css/style.css">
  
</head>
<body>
  <?php require APP_PATH . "/Views/layouts/nav.php"; ?>
  <main>
    <div class="page-header">
      <h1>Dodaj korisnika</h1>
      <a href="<?php echo url("users"); ?>" class="button">Natrag</a>
    </div>
    <div class="form-container">
      <form method="POST">
        <input type="text" name="username" placeholder="Korisničko ime" required>
        <input type="password" name="password" placeholder="Lozinka" required>
        <select name="role">
          <option value="customer">Customer</option>
          <option value="admin">Admin</option>
        </select>
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
