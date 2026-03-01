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

        $data = [
            'mensaje' => '',
            'errores' => [],
            'editando' => null,
            'productos' => []
        ];

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
                    $data['mensaje'] = 'Producto creado correctamente.';
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
                } else {
                    $data['mensaje'] = 'Producto actualizado correctamente.';
                }
            }

            if ($accion === 'eliminar') {
                $id = (int)($_GET['id'] ?? 0);
                $this->service->eliminar($id);
                $data['mensaje'] = 'Producto eliminado correctamente.';
            }

            // Siempre listamos productos al final
            $data['productos'] = $this->service->listar();

            return $data;

        } catch (Throwable $e) {
            $data['errores'][] = 'Error interno del sistema.';
            $data['productos'] = $this->service->listar();
            return $data;
        }
    }
}