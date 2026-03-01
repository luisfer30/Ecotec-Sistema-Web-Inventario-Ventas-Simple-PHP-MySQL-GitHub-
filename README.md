# Sistema Web: Inventario + Ventas (PHP + MySQL + GitHub)

Proyecto académico desarrollado en **PHP 8+** y **MySQL/MariaDB** que permite gestionar productos mediante un **CRUD completo** (crear, listar, editar y eliminar), aplicando **estructura por capas**, **validaciones**, **seguridad básica** y **control de versiones con GitHub**.

---

## Funcionalidades

### Módulo 1: Productos (CRUD)
- Crear producto
- Listar productos
- Editar producto
- Eliminar producto *(con confirmación SweetAlert + eliminación por POST)*

### Validaciones obligatorias
- Nombre **no vacío**
- Stock **>= 0** *(no permite stock negativo)*
- Precio **> 0**

### Buenas prácticas aplicadas
- Estructura por capas: **config / models / services / controllers / public**
- Consultas con **PDO + prepared statements**
- Escape de salida con `htmlspecialchars()` (seguridad XSS básica)
- Patrón **Post/Redirect/Get (PRG)** para evitar reenvío al refrescar (Ctrl+R)

---


##  Estructura del proyecto

```bash
/inventario-ventas
  /config
    database.php
  /models
    Producto.php
  /controllers
    ProductoController.php
  /services
    ProductoService.php
  /public
    index.php
    productos.php
    /assets
      /css
        styles.css
        index_styles.css
      /js
        app.js
      /img
        logo-ecotec.png 
  /database
    inventario.sql
  README.md
```

###  requisitos

- XAMPP (Apache + MySQL/MariaDB)
- PHP 8+
- Navegador web (Chrome/Edge/Firefox)
- Git instalado (para commits/ramas)

###  Instalacion y ejecución

- Git Clone https://github.com/luisfer30/-Sistema-Web-Inventario-Ventas-Simple-PHP-MySQL-GitHub-.git
- Clonar dentro de la ruta C:\xampp\htdocs\Sistema_Inventario
- Iniciar servicios en XAMPP
- Crear la base de datos e importar el script SQL
- Configurar conexión de BD, usar usuario y contraseña en caso de ser necesario: config/database.php
- El script se encuentra en la ruta: database/inventario.sql
- Este proyecto no requiere login, pero queda abierta a futuras mejoras

### Uso de IA
Se declara el uso de la IA para resolver problemas como validaciones de la recarga y escoger un diseño no tan básico para la visualización del sistema