<?php

declare(strict_types=1);

require_once __DIR__ . '/../config/database.php';

$conexionOK = false;
try {
  db();
  $conexionOK = true;
} catch (Throwable $e) {
  $conexionOK = false;
}
?>
<!doctype html>
<html lang="es">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Sistema Inventario + Ventas</title>
  <link rel="stylesheet" href="assets/css/styles.css">
</head>

<body>
  <div class="container" style="padding:20px;">
    <div class="nav">
      <div class="brand">
        <b>Sistema Inventario + Ventas</b>
        <span>PHP + MySQL • Estructura por capas • GitHub</span>
      </div>
      <div class="right">
        <span class="pill"><?= $conexionOK ? 'BD Conectada' : 'BD Sin conexión' ?></span>
        <a href="productos.php">Ir a Productos →</a>
      </div>
    </div>

    <div class="grid">
      <div class="card2" style="grid-column: span 7;">
        <h2>Bienvenido</h2>
        <p>Desde aquí puedes gestionar el inventario de productos</p>

        <div class="actions">
          <a class="btn3" href="productos.php">Gestionar Productos</a>
          <a class="btn3 secondary" href="../database/inventario.sql" target="_blank" rel="noopener">Ver Script SQL</a>
        </div>
      </div>
    </div>
  </div>
</body>

</html>