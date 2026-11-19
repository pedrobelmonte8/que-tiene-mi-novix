# 🎁 WishVault — Gestor de Listas de Regalos e Ideas

WishVault es una aplicación web para guardar, organizar y gestionar ideas de regalos para tu persona favorita, amigos o familiares. Permite crear múltiples listas, añadir artículos por categorías (moda, belleza, skincare, gourmet, hobbies, etc.), establecer precios, tiendas, etiquetas de prioridad, notas y cambiar entre modo claro y oscuro.

---

## ✨ Funcionalidades

- 🔐 **Autenticación completa** — Registro, inicio de sesión y cierre de sesión con control de acceso por usuario.
- 📋 **Múltiples listas personalizadas** — Crea listas independientes (para tu pareja, amigos, cumpleaños, etc.), cámbialas fácilmente pulsando sobre el título y elimina las que ya no necesites.
- 🗂️ **Categorías organizadas** — Cards apiladas en acordeón: Ropa y Calzado, Maquillaje & Belleza, Cremas & Skincare, Comida & Gourmet, Juguetes & Hobbies, y Otros detalles.
- ✏️ **Gestión de artículos (CRUD)** — Añade artículos indicando precio orientativo, tienda dónde comprarlo, notas con detalles/tallas y etiquetas de prioridad (ej. `⭐ Top Deseo`). Modifica o elimina en cualquier momento.
- 🌙 **Modo Noche / Día (Dark Mode)** — Conmutador integrado en la cabecera, guardado en `localStorage` y sin parpadeo al recargar la página.
- ⚡ **Notificaciones interactivas** — Mensajes de estado flotantes que desaparecen solos tras 5 segundos o al hacer clic sobre ellos.
- 📱 **Diseño moderno y adaptable** — Interfaz minimalista con Tailwind CSS compatible con ordenadores y dispositivos móviles.

---

## 🛠️ Stack tecnológico

- **Backend**: Laravel 13 & PHP 8.4
- **Frontend**: Blade + Tailwind CSS v4 + Vite
- **Base de datos**: SQLite (por defecto, compatible con MySQL/PostgreSQL)
- **Servidor local recomendado**: [Laravel Herd](https://herd.laravel.com/) (Windows / macOS) o PHP CLI Server

---

## 🚀 Instalación y uso en cualquier PC

Sigue estos sencillos pasos para poner el proyecto en marcha en cualquier ordenador:

### 1. Requisitos previos
Asegúrate de tener instalados:
- [PHP](https://www.php.net/) (versión 8.2 o superior, recomendado PHP 8.4)
- [Composer](https://getcomposer.org/)
- [Node.js](https://nodejs.org/) (versión 20 o superior) y npm
- [Git](https://git-scm.com/)

---

### 2. Clonar el repositorio
Abre una terminal y clona el proyecto en tu máquina:
```bash
git clone https://github.com/tu-usuario/wishvault.git
cd wishvault
```

---

### 3. Instalar dependencias

**Dependencias de PHP:**
```bash
composer install
```

**Dependencias de JavaScript / Frontend:**
```bash
npm install
```

---

### 4. Configurar el entorno

Copia el archivo de ejemplo para crear tu archivo `.env`:
```bash
# En Windows (PowerShell):
copy .env.example .env

# En Linux / macOS / Git Bash:
cp .env.example .env
```

Genera la clave de aplicación de Laravel:
```bash
php artisan key:generate
```

---

### 5. Configurar la base de datos (SQLite)

Crea el archivo vacío para SQLite en la carpeta `database/`:
```bash
# En Windows (PowerShell):
New-Item -ItemType File -Path database/database.sqlite -Force

# En Linux / macOS / Git Bash:
touch database/database.sqlite
```

Ejecuta las migraciones para crear las tablas necesarias:
```bash
php artisan migrate
```

---

### 6. Compilar los assets del frontend

Para compilar en producción:
```bash
npm run build
```

O si vas a desarrollar y quieres recarga en directo:
```bash
npm run dev
```

---

### 7. Iniciar la aplicación

Si estás utilizando **Laravel Herd**, el sitio ya estará disponible en tu navegador en `http://wishvault.test` o el nombre asignado por Herd.

Si prefieres el servidor integrado de Laravel:
```bash
php artisan serve
```
Abre tu navegador en: **[http://127.0.0.1:8000](http://127.0.0.1:8000)**

---

## 🧪 Pruebas automatizadas

Puedes verificar que todo funcione correctamente ejecutando la suite de pruebas:
```bash
php artisan test
```

---

## 📂 Estructura principal

```text
app/
├── Http/Controllers/
│   ├── AuthController.php        # Registro, login y sesión
│   ├── GiftController.php        # Listado y gestión de artículos
│   └── GiftListController.php    # Creación y borrado de listas
└── Models/
    ├── Gift.php                  # Modelo de regalo y categorías
    ├── GiftList.php              # Modelo de listas de regalos
    └── User.php                  # Modelo de usuario

resources/views/
├── index.blade.php               # Plantilla y layout principal
├── components/
│   ├── navbar.blade.php          # Barra de navegación con logo y modo oscuro
│   ├── gift-list.blade.php       # Acordeón de categorías y selector de listas
│   ├── gift-modal.blade.php      # Modal para crear/editar regalos
│   ├── login.blade.php           # Formulario de inicio de sesión
│   └── register.blade.php        # Formulario de registro de usuario
└── auth/                         # Vistas de autenticación
```

---

## 📄 Licencia

Este proyecto está bajo la licencia MIT.
