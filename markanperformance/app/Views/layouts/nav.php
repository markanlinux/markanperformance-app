<nav>
  <img src="<?php echo BASE_URL; ?>assets/images/logo.svg" alt="Markan Performance">
  <a href="<?php echo url("dashboard"); ?>" class="button">Dashboard</a>
  <a href="<?php echo url("cars"); ?>" class="button">Automobili</a>
  <?php if ($_SESSION["role"] === "admin"): ?>
    <a href="<?php echo url("users"); ?>" class="button">Korisnici</a>
  <?php endif; ?>
  <a href="<?php echo url("auth/logout"); ?>" class="button">Odjava</a>
</nav>
