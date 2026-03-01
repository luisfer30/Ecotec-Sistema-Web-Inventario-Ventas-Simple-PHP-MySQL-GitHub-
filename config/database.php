<?php
// config/database.php

declare(strict_types=1);

function db(): PDO {
  $host = "localhost";
  $dbname = "inventario_ventas";
  $user = "root";
  $pass = ""; 
  
  $dsn = "mysql:host={$host};dbname={$dbname};charset=utf8mb4";

  $options = [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES => false,
  ];

  return new PDO($dsn, $user, $pass, $options);
}