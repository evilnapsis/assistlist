# AssistList Lite v4

> **Sistema de Control de Asistencias desarrollado con PHP y MySQL**

[![Version](https://img.shields.io/badge/Version-4.0%20(2026)-9333ea)](https://github.com/)
[![PHP Version](https://img.shields.io/badge/PHP-8.2%2B-777BB4?logo=php&logoColor=white)](https://www.php.net/)
[![MySQL](https://img.shields.io/badge/MySQL-8.0%2B%20%2F%20MariaDB-4479A1?logo=mysql&logoColor=white)](https://www.mysql.com/)
[![Twig Engine](https://img.shields.io/badge/Twig-3.x-8FBA2C?logo=twig&logoColor=white)](https://twig.symfony.com/)
[![CoreUI](https://img.shields.io/badge/CoreUI-v5-321FDB?logo=coreui&logoColor=white)](https://coreui.io/)
[![Architecture](https://img.shields.io/badge/Architecture-MVC%20%2B%20FastRoute-blue)](#-arquitectura-del-proyecto)

**AssistList Lite v4** es la cuarta evolución integral del popular sistema de control de asistencias creado originalmente por **Evilnapsis**. Esta nueva versión sustituye el antiguo enfoque escolar por una arquitectura corporativa moderna basada en **Colaboradores (`person`)**, **Departamentos (`department`)** y un motor configurable de **Estados de Asistencia (`assistance_status`)**.

Desarrollado bajo el patrón de arquitectura **MVC**, con enrutamiento de alto rendimiento mediante **FastRoute**, motor de plantillas **Twig 3**, interfaz responsiva empresarial con **CoreUI v5** (tema morado oscuro y modo Sidebar Mini / Narrow), y capa de persistencia **PDO con Prepared Statements** y protección estricta contra ataques **CSRF**.

---

## 📦 Módulos

* **Dashboard**
  * Widgets contadores KPI con bordes de color perimetrales destacados.
  * Gráfica de línea de tendencia de asistencia de los últimos 30 días (asistencias presentes).
  * Gráfica de barras comparativas por departamento (presentes vs faltas y tardanzas).
  * Gráfica de dona de empleados con asistencia vs sin registrar (NULL).
  * Resumen de marcaciones y nómina del día en tiempo real.
* **Personas**
  * **Empleados**: Directorio de colaboradores con código laboral, cargo, salario, correo y ficha técnica individual con historial de puntualidad.
  * **Departamentos**: Estructura departamental, código de área, jefes responsables y conteo en tiempo real de colaboradores asignados.
* **Asistencias**
  * **Pase de Asistencia**: Toma de lista diaria por departamento con estado por defecto `NULL` (sin registrar), notas u observaciones, hora de entrada y botón masivo **"Marcar todos presentes"**.
  * **Vista Mensual**: Matriz de 1 a 31 días por mes/año, sombreado de fines de semana y porcentaje mensual de puntualidad por colaborador.
  * **Estados de asistencia**: Catálogo dinámico para crear y personalizar estados, colores hexadecimales, iconos y ponderación de asistencia.
* **Reportes**
  * Filtrado multi-criterio por rango libre de fechas y departamento.
  * Widgets de métricas totales del periodo (Asistencias, Faltas, Tardanzas, Marcaciones).
  * Desglose dinámico de totales acumulados por cada estado configurado.
  * Matriz de asistencia del periodo e imprimible de firmas.
  * Exportación instantánea a **CSV / Excel** con codificación UTF-8 con firma BOM.
* **Usuarios**
  * Control de usuarios del sistema con roles diferenciados (*Administrador* y *Supervisor / Operador*).
  * Cifrado seguro de contraseñas mediante algoritmo Bcrypt (`password_hash`).

---

## 📜 Historial de Versiones

### **v4.0 - 2026**
* **Arquitectura Empresarial**: Transición completa del esquema escolar al entorno corporativo con tablas `person`, `department` y `assistance_status`.
* **Pase de Asistencia con Valor Inicial NULL**: Por defecto los empleados inician sin definir (NULL / sin asistencia) y se incluye el botón *"Marcar todos presentes"* para agilizar la toma de lista.
* **Dashboard Analítico Avanzado**:
  * Widgets KPI perimetrales con bordes de color diferenciados.
  * Gráfica de línea de asistencia de los últimos 30 días (solo presentes).
  * Gráfica de barras comparativas por departamento (presentes, faltas, tardanzas).
  * Gráfica de dona de empleados con asistencia vs sin definir (NULL).
* **Modernización del Diseño**:
  * Sidebar con paleta morada oscura (`#1b0e33`) y estados activo/hover con resplandor púrpura suave.
  * Modo Sidebar Mini / Narrow con soporte de iconos centrados y memoria en `localStorage`.
  * Cabecera alineada a la altura estándar (60px) del header superior.
* **Compatibilidad Total PHP 8.2+**:
  * Tipado estricto, atributos de clase explícitos y soporte completo para PHP 8.2+.
  * Motor de plantillas Twig 3.x y enrutamiento con FastRoute.
  * Prevención de inyecciones SQL mediante PDO Prepared Statements.
  * Protección CSRF en todas las peticiones POST.
  * Corrección de codificación global en UTF-8 / `utf8mb4_unicode_ci` (tildes y caracteres especiales).

### **v3.0 - 2026**
* Update PHP 8
* Template Core UI 4

### **v2.0 - 2019**
* Actualizacion del nucleo a LbMin v2
* Actualizacion del diseño a AdminLte v2

> **Más Información**: [http://evilnapsis.com/2016/08/21/assistlist-sistema-de-control-de-asistencias-con-php-y-mysql/](http://evilnapsis.com/2016/08/21/assistlist-sistema-de-control-de-asistencias-con-php-y-mysql/)

---

## 🛠️ Requisitos del Sistema

* **PHP 8.2** o superior (con extensiones `pdo`, `pdo_mysql`, `mbstring`, `openssl`).
* **MySQL 8.0+** o **MariaDB 10.4+**.
* **Apache** con módulo `mod_rewrite` habilitado (incluido en XAMPP).
* **Composer** (incluido dentro de la carpeta `vendor/`).

---

## 🚀 Instalación y Puesta en Marcha

### 1. Ubicación del Proyecto
Ubica la carpeta del proyecto en la raíz web de tu servidor local (ej. en XAMPP para Windows):
```text
C:\xampp\htdocs\update_mv_2026\assistlist2\
```

### 2. Creación e Importación de la Base de Datos
Abre tu cliente de MySQL (phpMyAdmin o consola) e importa el archivo [schema.sql](file:///c:/xampp/htdocs/update_mv_2026/assistlist2/schema.sql):

```bash
# Vía línea de comandos:
mysql -u root -p < schema.sql
```

Esto creará la base de datos `assistlist2` con las tablas:
* `user` (Usuarios administradores y operadores)
* `department` (Departamentos empresariales)
* `assistance_status` (Catálogo dinámico de estados con colores e iconos)
* `person` (Colaboradores / empleados)
* `assistance` (Marcaciones de asistencia diarias)

### 3. Configuración de Base de Datos
Verifica los parámetros de conexión en [`core/controller/Database.php`](file:///c:/xampp/htdocs/update_mv_2026/assistlist2/core/controller/Database.php):

```php
$this->user = "root";
$this->pass = "";
$this->host = "localhost";
$this->ddbb = "assistlist2";
```

### 4. Acceso al Sistema
Abre tu navegador web en la siguiente URL:
```text
http://localhost/update_mv_2026/assistlist2/
```

---

## 🔐 Credenciales de Acceso por Defecto

| Rol | Usuario / Correo | Contraseña |
| :--- | :--- | :--- |
| **Administrador** | `admin` o `admin@empresa.com` | `admin` (o `admin123`) |
| **Supervisor RRHH** | `rrhh` o `rrhh@empresa.com` | `admin123` |

---

## 📁 Arquitectura del Proyecto

```text
assistlist2/
├── assets/                    # Hojas de estilo, CoreUI v5 y librerías frontend
│   └── coreui/
├── core/
│   ├── app/
│   │   ├── autoload.php       # Autoloader PSR-4 para controladores y servicios
│   │   ├── routes.php         # Mapeo de rutas FastRoute
│   │   ├── controller/        # Controladores MVC
│   │   │   ├── AttendanceController.php
│   │   │   ├── AuthController.php
│   │   │   ├── DepartmentController.php
│   │   │   ├── HomeController.php
│   │   │   ├── PersonController.php
│   │   │   ├── ReportController.php
│   │   │   ├── StatusController.php
│   │   │   └── UserController.php
│   │   ├── model/             # Modelos Active Record (PHP 8.2+)
│   │   │   ├── AssistanceData.php
│   │   │   ├── AssistanceStatusData.php
│   │   │   ├── DepartmentData.php
│   │   │   ├── PersonData.php
│   │   │   └── UserData.php
│   │   └── service/           # Capa de Servicios de Dominio
│   │       ├── AttendanceService.php
│   │       └── AuthService.php
│   ├── controller/            # Núcleo y herramientas base (LegoBox Engine)
│   │   ├── Database.php       # Conexión PDO con utf8mb4
│   │   ├── LbModel.php        # Mini-ORM con filtrado de columnas
│   │   ├── Request.php        # Manejador de parámetros HTTP
│   │   ├── Response.php       # Respuestas JSON / Headers
│   │   ├── Session.php        # Gestión de sesión, flashes y tokens CSRF
│   │   └── ViewEngine.php     # Inicializador y renderizador de Twig 3
│   └── autoload.php           # Autoloader base
├── public/                    # Vistas y plantillas Twig 3
│   ├── attendance/            # Vista de pase de lista diario
│   ├── auth/                  # Pantalla de inicio de sesión
│   ├── departments/           # Vistas CRUD de departamentos
│   ├── home/                  # Dashboard principal con Chart.js
│   ├── layouts/               # Plantilla maestra (main.html.twig)
│   ├── persons/               # Vistas CRUD y perfil de empleados
│   ├── reports/               # Reportes por rango y vista mensual
│   ├── status/                # Gestión de estados de asistencia
│   ├── users/                 # Gestión de usuarios del sistema
│   └── 404.html.twig          # Página de error 404 amigable
├── vendor/                    # Dependencias de Composer (Twig, FastRoute)
├── .htaccess                  # Reescritura de URLs para FastRoute
├── index.php                  # Front Controller único
├── schema.sql                 # Script DDL y datos semilla iniciales
└── README.md                  # Documentación del proyecto
```

---

## 🧭 Mapa de Navegación del Menú

* **Dashboard** (`/`) — Métricas clave, gráficas comparativas y lista del día.
* **Asistencia** (`/attendance/take`) — Pase de lista diario y marcado masivo.
* **Vista Mensual** (`/reports/monthly`) — Cuadrícula mensual de control de asistencia.
* **Departamentos** (`/departments`) — Administración de áreas y centros de trabajo.
* **Empleados** (`/employees`) — Directorio de colaboradores y ficha laboral.
* **Estados de asistencia** (`/status`) — Catálogo personalizable de estados, colores e iconos.
* **Reportes** (`/reports`) — Reporte por rango de fechas, widgets y exportación CSV.
* **Usuarios** (`/users`) — Control de accesos y administradores de la plataforma.

---

## 🔒 Buenas Prácticas y Seguridad Implementadas

1. **Prepared Statements**: Todas las consultas SQL utilizan sentencias preparadas con parámetros vinculados para neutralizar riesgos de inyección SQL.
2. **Protección CSRF**: Formularios protegidos mediante token secreto temporal inyectado a través del helper `{{ csrf_field() }}`.
3. **Compatibilidad Estricta PHP 8.2+**: Modelos con atributos explícitos y anotación `#[\AllowDynamicProperties]` para eliminar advertencias de deprecación.
4. **Codificación UTF-8**: Conexión y tablas configuradas en `utf8mb4_unicode_ci` garantizando la visualización correcta de tildes, acentos y caracteres especiales.
5. **Autofiltrado de Columnas en ORM**: `LbModel` inspecciona y almacena en caché las columnas reales de cada tabla, evitando errores al calcular propiedades dinámicas o campos derivados de `JOIN`.

---

## 📄 Licencia

Este proyecto ha sido desarrollado como una modernización integral de código abierto con propósitos profesionales y educativos.
Libre de uso y modificación bajo la licencia **MIT**.
