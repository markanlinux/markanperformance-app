<!DOCTYPE html>
<html lang="hr">
<head>
  <meta charset="UTF-8">
  <title>MP | Registracija</title>
  <link rel="icon" href="<?php echo BASE_URL; ?>assets/images/favicon.svg" type="image/svg+xml">
  <link rel="stylesheet" href="<?php echo BASE_URL; ?>assets/css/style.css">
</head>
<body class="auth-page">
  <div class="auth-box">
    <img src="<?php echo BASE_URL; ?>assets/images/logo.svg" alt="Markan Performance">
    <form method="POST">
      <input type="text" name="username" placeholder="Korisničko ime" required>
      <input type="password" name="password" placeholder="Lozinka" required>
      <?php if ($error): ?>
        <p class="error"><?php echo $error; ?></p>
      <?php endif; ?>
      <?php if ($success): ?>
        <p class="success"><?php echo $success; ?></p>
      <?php endif; ?>
      <button type="submit" class="button">Registriraj se</button>
      <a href="<?php echo url("auth/login"); ?>">Već imaš račun? <span>Prijavi se!</span></a>
    </form>
  </div>
</body>
</html>
