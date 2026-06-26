<!DOCTYPE html>
<html lang="hr">
<head>
  <meta charset="UTF-8">
  <title>MP | Korisnici</title>
  <link rel="icon" href="<?php echo BASE_URL; ?>assets/images/favicon.svg" type="image/svg+xml">
  <link rel="stylesheet" href="<?php echo BASE_URL; ?>assets/css/style.css">
  
</head>
<body>
  <?php require APP_PATH . "/Views/layouts/nav.php"; ?>
  <main>
    <div class="page-header">
      <h1>Korisnici</h1>
      <a href="<?php echo url("users/create"); ?>" class="button">Dodaj</a>
    </div>
    <table>
      <thead>
        <tr>
          <th>ID</th>
          <th>Korisničko ime</th>
          <th>Uloga</th>
          <th>Akcije</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($users as $user): ?>
          <tr>
            <td><?php echo $user["id"]; ?></td>
            <td><?php echo htmlspecialchars($user["username"]); ?></td>
            <td><?php echo htmlspecialchars($user["role"]); ?></td>
            <td class="actions">
              <a href="<?php echo url("users/edit?id=" . $user["id"]); ?>" class="button">Uredi</a>
              <a href="<?php echo url("users/delete?id=" . $user["id"]); ?>" class="button" onclick="return confirm('Obrisati ovog korisnika?');">Obriši</a>
            </td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </main>
</body>
</html>
