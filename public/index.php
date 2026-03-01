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
  <title>Sistema Inventario + Ventas </title>
  <link rel="stylesheet" href="assets/css/index_styles.css">
</head>

<body>
  <div class="container" style="padding:20px;">

    <div class="hero">
      <div style="display:flex; align-items:center; gap:12px; margin-bottom:10px;">
        <img src="assets/img/logo-ecotec.png" alt="Logo Universidad" style="height:40px;">
        <div>
          <h1 style="margin:0;">Sistema Inventario + Ventas</h1>
          <small style="color:#64748b;">Proyecto Académico</small>
        </div>
      </div>
      <div class="hero-grid">
        <div>
          <h1>Sistema Inventario + Ventas - Creado por Luis Bustamante</h1>
          <p>
            Administra productos con un CRUD completo, validaciones y estructura por capas.
            Ideal para la entrega: limpio y ordenado.
          </p>

          <div style="display:flex; gap:12px; margin-top:16px;">
            <a class="btn-hero btn-primary" href="productos.php">
              Gestionar Productos
            </a>

            <a class="btn-hero btn-secondary"
              href="../database/inventario.sql"
              target="_blank">
              Ver Script SQL
            </a>
          </div>

          <div class="hero-badges">
            <span class="badge2">
              <!-- Span colocado por temas de pruebas, se debe quitar si fuera ambiente productivo. -->
              <span class="icon-dot <?= $conexionOK ? '' : 'off' ?>"></span>
              <?= $conexionOK ? 'BD Conectada' : 'BD Sin conexión' ?>
            </span>
            <span class="badge2">PHP 8+</span>
            <span class="badge2">MySQL</span>
            <span class="badge2">GitHub</span>
          </div>
        </div>
      </div>
    </div>

  </div>
</body>

</html>