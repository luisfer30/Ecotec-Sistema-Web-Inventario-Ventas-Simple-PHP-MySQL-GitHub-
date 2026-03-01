<?php
declare(strict_types=1);

require_once __DIR__ . '/../controllers/ProductoController.php';

$controller = new ProductoController();
$data = $controller->handle();

function h(mixed $value): string {
    return htmlspecialchars((string)$value, ENT_QUOTES, 'UTF-8');
}

$edit = $data['editando'];
?>
<!doctype html>
<html lang="es">
<head>
  <meta charset="utf-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1"/>
  <title>CRUD Productos Por Luis Bustamante</title>
  <style>
    body{font-family:Arial; background:#f6f7fb; margin:0; padding:20px;}
    .card{background:#fff; padding:16px; border-radius:12px; max-width:980px; margin:auto; box-shadow:0 10px 25px rgba(0,0,0,.08);}
    h1{margin-top:0;}
    .row{display:flex; gap:10px; flex-wrap:wrap;}
    .col{flex:1; min-width:200px;}
    input{padding:10px; border:1px solid #ccc; border-radius:10px; width:100%; box-sizing:border-box;}
    button{padding:10px 14px; border:0; border-radius:10px; cursor:pointer;}
    .btn{background:#0d47a1; color:#fff;}
    .btn2{background:#546e7a; color:#fff; text-decoration:none; display:inline-block;}
    table{width:100%; border-collapse:collapse; margin-top:12px;}
    th,td{padding:10px; border-bottom:1px solid #eee; text-align:left;}
    .msg{padding:10px; background:#e8f5e9; border:1px solid #a5d6a7; border-radius:10px; margin:10px 0;}
    .err{padding:10px; background:#ffebee; border:1px solid #ef9a9a; border-radius:10px; margin:10px 0;}
    a{color:#0d47a1; text-decoration:none;}
    .top{display:flex; justify-content:space-between; align-items:center; gap:12px; flex-wrap:wrap;}
    .small{color:#607d8b; font-size:13px;}
  </style>
</head>
<body>
  <div class="card">
    <div class="top">
      <div>
        <h1>CRUD Productos</h1>
        <div class="small">Crear • Listar • Editar • Eliminar</div>
      </div>
      <div>
        <a class="btn2" href="index.php" style="padding:10px 14px; border-radius:10px;">Inicio</a>
      </div>
    </div>

    <?php if (!empty($data['mensaje'])): ?>
      <div class="msg"><?= h($data['mensaje']) ?></div>
    <?php endif; ?>

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

    <h2><?= $edit ? 'Editar producto' : 'Crear producto' ?></h2>

    <form method="post" action="productos.php" autocomplete="off">
      <input type="hidden" name="accion" value="<?= $edit ? 'actualizar' : 'crear' ?>">

      <?php if ($edit): ?>
        <input type="hidden" name="id" value="<?= h($edit['id']) ?>">
      <?php endif; ?>

      <div class="row">
        <div class="col">
          <label>Nombre</label>
          <input name="nombre" value="<?= h($edit['nombre'] ?? '') ?>" required>
        </div>

        <div class="col">
          <label>Precio</label>
          <input name="precio" type="number" step="0.01" min="0.01" value="<?= h($edit['precio'] ?? '') ?>" required>
        </div>

        <div class="col">
          <label>Stock</label>
          <input name="stock" type="number" step="1" min="0" value="<?= h($edit['stock'] ?? 0) ?>" required>
        </div>
      </div>

      <div style="margin-top:12px; display:flex; gap:10px; align-items:center;">
        <button class="btn" type="submit"><?= $edit ? 'Actualizar' : 'Crear' ?></button>

        <?php if ($edit): ?>
          <a class="btn2" href="productos.php" style="padding:10px 14px;">Cancelar</a>
        <?php endif; ?>
      </div>
    </form>

    <h2>Listado</h2>

    <table>
      <thead>
        <tr>
          <th>ID</th>
          <th>Nombre</th>
          <th>Precio</th>
          <th>Stock</th>
          <th style="width:160px;">Acciones</th>
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
              <td>$<?= h($p['precio']) ?></td>
              <td><?= h($p['stock']) ?></td>
              <td>
                <a href="productos.php?accion=editar&id=<?= h($p['id']) ?>">Editar</a>
                |
                <a href="productos.php?accion=eliminar&id=<?= h($p['id']) ?>"
                   onclick="return confirm('¿Eliminar este producto?');">Eliminar</a>
              </td>
            </tr>
          <?php endforeach; ?>
        <?php endif; ?>
      </tbody>
    </table>

  </div>
</body>
</html>