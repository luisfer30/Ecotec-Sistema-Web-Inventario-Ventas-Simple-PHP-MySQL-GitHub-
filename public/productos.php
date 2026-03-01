<?php

declare(strict_types=1);

require_once __DIR__ . '/../controllers/ProductoController.php';

$controller = new ProductoController();
$data = $controller->handle();

function h(mixed $value): string
{
  return htmlspecialchars((string)$value, ENT_QUOTES, 'UTF-8');
}

$edit = $data['editando'] ?? null;

$totalProductos = isset($data['productos']) ? count($data['productos']) : 0;
$stockTotal = 0;
$valorInventario = 0.0;

if (!empty($data['productos'])) {
  foreach ($data['productos'] as $p) {
    $s = (int)($p['stock'] ?? 0);
    $pr = (float)($p['precio'] ?? 0);
    $stockTotal += $s;
    $valorInventario += ($s * $pr);
  }
}
?>
<!doctype html>
<html lang="es">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Módulo Productos</title>

  <link rel="stylesheet" href="assets/css/styles.css">
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

  <script defer src="assets/js/app.js"></script>
</head>

<body>
  <div class="container" style="padding:20px;">

    <div class="nav">
      <div class="brand">
        <b>Módulo Productos</b>
      </div>
      <div class="right">
        <a href="index.php">← Inicio</a>
        <span class="pill">Total: <?= h($totalProductos) ?></span>
      </div>
    </div>
    <?php if (!empty($data['mensaje'])): ?>
      <div data-flash="success" data-text="<?= h($data['mensaje']) ?>"></div>
    <?php endif; ?>

    <!-- Errores -->
    <?php if (!empty($data['errores'])): ?>
      <div class="err">
        <b>Errores:</b>
        <ul>
          <?php foreach ($data['errores'] as $e): ?>
            <li><?= h($e) ?></li>
          <?php endforeach; ?>
        </ul>
      </div>
    <?php endif; ?>

    <div class="grid">
      <!-- KPIs -->
      <div class="card2 kpi" style="grid-column: span 4;">
        <div class="value"><?= h($totalProductos) ?></div>
        <div class="label">Productos registrados</div>
      </div>

      <div class="card2 kpi" style="grid-column: span 4;">
        <div class="value"><?= h($stockTotal) ?></div>
        <div class="label">Stock total</div>
      </div>

      <div class="card2 kpi" style="grid-column: span 4;">
        <div class="value">$<?= h(number_format($valorInventario, 2)) ?></div>
        <div class="label">Valor del inventario (stock × precio)</div>
      </div>

      <!-- Form -->
      <div class="card2" style="grid-column: span 12;">
        <h2><?= $edit ? 'Editar producto' : 'Crear producto' ?></h2>
        <form method="post" action="productos.php" autocomplete="off">
          <input type="hidden" name="accion" value="<?= $edit ? 'actualizar' : 'crear' ?>">
          <?php if ($edit): ?>
            <input type="hidden" name="id" value="<?= h($edit['id'] ?? '') ?>">
          <?php endif; ?>

          <div class="form-grid">
            <div>
              <label>Nombre</label>
              <input class="input" name="nombre" value="<?= h($edit['nombre'] ?? '') ?>" placeholder="Ej: Arroz 1kg" required>
              <div class="help">No puede estar vacío.</div>
            </div>

            <div>
              <label>Precio</label>
              <input class="input" name="precio" type="number" step="0.01" min="0.01"
                value="<?= h($edit['precio'] ?? '') ?>" placeholder="0.00" required>
              <div class="help">Debe ser mayor a 0.</div>
            </div>

            <div>
              <label>Stock</label>
              <input class="input" name="stock" type="number" step="1" min="0"
                value="<?= h($edit['stock'] ?? 0) ?>" required>
              <div class="help">No permite negativos.</div>
            </div>
          </div>

          <div class="actions" style="margin-top:12px;">
            <button class="btn3" type="submit"><?= $edit ? 'Actualizar' : 'Crear' ?></button>
            <?php if ($edit): ?>
              <a class="btn3 secondary" href="productos.php">Cancelar</a>
            <?php endif; ?>
          </div>
        </form>
      </div>

      <!-- Listado -->
      <div class="card2" style="grid-column: span 12;">
        <div class="top">
          <div>
            <h2>Listado</h2>
            <p>Usa el buscador para filtrar por nombre (sin recargar).</p>
          </div>
        </div>

        <div class="toolbar">
          <input id="searchProductos" class="search" placeholder="Buscar por nombre..." />
          <span class="badge" id="countVisible"></span>
        </div>

        <div class="table-wrap">
          <table>
            <thead>
              <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Precio</th>
                <th>Stock</th>
                <th style="width:200px;">Acciones</th>
              </tr>
            </thead>
            <tbody>
              <?php if (empty($data['productos'])): ?>
                <tr>
                  <td colspan="5">No hay productos registrados.</td>
                </tr>
              <?php else: ?>
                <?php foreach ($data['productos'] as $p): ?>
                  <tr>
                    <td><?= h($p['id']) ?></td>
                    <td><?= h($p['nombre']) ?></td>
                    <td class="price">$<?= h(number_format((float)$p['precio'], 2)) ?></td>
                    <td><?= h($p['stock']) ?></td>
                    <td>
                      <div class="actions-cell">
                        <a class="link" href="productos.php?accion=editar&id=<?= h($p['id']) ?>">Editar</a>
                        <form method="post" action="productos.php" data-confirm="delete" style="margin:0;">
                          <input type="hidden" name="accion" value="eliminar">
                          <input type="hidden" name="id" value="<?= h($p['id']) ?>">
                          <button type="submit" class="btn-danger">Eliminar</button>
                        </form>
                      </div>
                    </td>
                  </tr>
                <?php endforeach; ?>
              <?php endif; ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</body>

</html>