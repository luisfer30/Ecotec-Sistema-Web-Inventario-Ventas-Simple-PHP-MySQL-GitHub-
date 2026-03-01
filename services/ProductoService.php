<?php
// services/ProductoService.php

declare(strict_types=1);

require_once __DIR__ . '/../config/database.php';

final class ProductoService
{
    private \PDO $pdo;

    public function __construct()
    {
        $this->pdo = db();
    }
    private function validar(string $nombre, mixed $precio, mixed $stock): array
    {
        $errores = [];
        $nombre = trim($nombre);

        if ($nombre === '') {
            $errores[] = 'El nombre no puede estar vacío.';
        }

        if (!is_numeric($precio) || (float)$precio <= 0) {
            $errores[] = 'El precio debe ser mayor a 0.';
        }

        if (!is_numeric($stock) || (int)$stock < 0) {
            $errores[] = 'El stock no puede ser negativo.';
        }

        return $errores;
    }

    public function listar(): array
    {
        $stmt = $this->pdo->query('SELECT * FROM productos ORDER BY id DESC');
        return $stmt->fetchAll();
    }

    public function obtenerPorId(int $id): ?array
    {
        $stmt = $this->pdo->prepare('SELECT * FROM productos WHERE id = ?');
        $stmt->execute([$id]);
        $row = $stmt->fetch();
        return $row ?: null;
    }

    public function crear(string $nombre, mixed $precio, mixed $stock): array
    {
        $errores = $this->validar($nombre, $precio, $stock);
        if ($errores) return ['ok' => false, 'errores' => $errores];

        $stmt = $this->pdo->prepare('INSERT INTO productos (nombre, precio, stock) VALUES (?, ?, ?)');
        $stmt->execute([trim($nombre), (float)$precio, (int)$stock]);

        return ['ok' => true];
    }

    public function actualizar(int $id, string $nombre, mixed $precio, mixed $stock): array
    {
        $errores = $this->validar($nombre, $precio, $stock);
        if ($errores) return ['ok' => false, 'errores' => $errores];

        $stmt = $this->pdo->prepare('UPDATE productos SET nombre = ?, precio = ?, stock = ? WHERE id = ?');
        $stmt->execute([trim($nombre), (float)$precio, (int)$stock, $id]);

        return ['ok' => true];
    }

    public function eliminar(int $id): void
    {
        $stmt = $this->pdo->prepare('DELETE FROM productos WHERE id = ?');
        $stmt->execute([$id]);
    }
}