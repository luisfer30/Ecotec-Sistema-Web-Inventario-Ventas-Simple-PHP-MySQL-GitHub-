<?php

declare(strict_types=1);

require_once __DIR__ . '/../services/ProductoService.php';

final class ProductoController
{
    private ProductoService $service;

    public function __construct()
    {
        $this->service = new ProductoService();
    }

    public function handle(): array
    {
        $accion = $_POST['accion'] ?? $_GET['accion'] ?? 'listar';
        $isPost = ($_SERVER['REQUEST_METHOD'] ?? 'GET') === 'POST';

        $msg = $_GET['msg'] ?? '';

        $data = [
            'mensaje' => '',
            'errores' => [],
            'editando' => null,
            'productos' => []
        ];


        $flashMap = [
            'creado' => 'Producto creado correctamente.',
            'actualizado' => 'Producto actualizado correctamente.',
            'eliminado' => 'Producto eliminado correctamente.',
        ];
        if ($msg && isset($flashMap[$msg])) {
            $data['mensaje'] = $flashMap[$msg];
        }

        try {

            if ($accion === 'crear') {
                $res = $this->service->crear(
                    $_POST['nombre'] ?? '',
                    $_POST['precio'] ?? '',
                    $_POST['stock'] ?? ''
                );

                if (!$res['ok']) {
                    $data['errores'] = $res['errores'];
                } else {
                    // PRG redirect
                    if ($isPost) {
                        header('Location: productos.php?msg=creado');
                        exit;
                    }
                    $data['mensaje'] = $flashMap['creado'];
                }
            }

            if ($accion === 'editar') {
                $id = (int)($_GET['id'] ?? 0);
                $data['editando'] = $this->service->obtenerPorId($id);

                if (!$data['editando']) {
                    $data['errores'][] = 'Producto no encontrado.';
                }
            }

            if ($accion === 'actualizar') {
                $id = (int)($_POST['id'] ?? 0);

                $res = $this->service->actualizar(
                    $id,
                    $_POST['nombre'] ?? '',
                    $_POST['precio'] ?? '',
                    $_POST['stock'] ?? ''
                );

                if (!$res['ok']) {
                    $data['errores'] = $res['errores'];
                    $data['editando'] = $this->service->obtenerPorId($id);
                } else {
                    if ($isPost) {
                        header('Location: productos.php?msg=actualizado');
                        exit;
                    }
                    $data['mensaje'] = $flashMap['actualizado'];
                }
            }

            if ($accion === 'eliminar') {
                $id = (int)($_POST['id'] ?? 0);
                $this->service->eliminar($id);

                if ($isPost) {
                    header('Location: productos.php?msg=eliminado');
                    exit;
                }
                $data['mensaje'] = $flashMap['eliminado'];
            }

            // Siempre listamos al final
            $data['productos'] = $this->service->listar();
            return $data;
        } catch (Throwable $e) {
            $data['errores'][] = 'Error interno del sistema.';
            $data['productos'] = $this->service->listar();
            return $data;
        }
    }
}
