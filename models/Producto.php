<?php

declare(strict_types=1);

final class Producto
{
    public function __construct(
        public ?int $id,
        public string $nombre,
        public float $precio,
        public int $stock
    ) {
        $this->nombre = trim($this->nombre);
    }
}