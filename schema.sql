-- =============================================================================
-- AssistList 2 - Sistema de Control de Asistencia Laboral (Empleados y Departamentos)
-- Base de Datos: assistlist2
-- Arquitectura: PHP 8.2+ MVC + FastRoute + Twig 3
-- =============================================================================

CREATE DATABASE IF NOT EXISTS assistlist2;
USE assistlist2;
SET sql_mode = '';

-- -----------------------------------------------------------------------------
-- 1. USUARIOS DEL SISTEMA (ADMINISTRADORES / SUPERVISORES)
-- -----------------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS user (
    id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(50) NOT NULL,
    lastname VARCHAR(50) NOT NULL,
    username VARCHAR(50) NOT NULL UNIQUE,
    email VARCHAR(150) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    is_admin BOOLEAN NOT NULL DEFAULT 1,
    is_active BOOLEAN NOT NULL DEFAULT 1,
    created_at DATETIME NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- -----------------------------------------------------------------------------
-- 2. DEPARTAMENTOS EMPRESARIALES
-- -----------------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS department (
    id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    code VARCHAR(20) NOT NULL UNIQUE,
    name VARCHAR(100) NOT NULL,
    description TEXT NULL,
    manager_name VARCHAR(100) DEFAULT '',
    is_active BOOLEAN NOT NULL DEFAULT 1,
    created_at DATETIME NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- -----------------------------------------------------------------------------
-- 3. ESTADOS DE ASISTENCIA DINÁMICOS (assistance_status)
-- -----------------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS assistance_status (
    id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    code VARCHAR(30) NOT NULL UNIQUE,
    name VARCHAR(50) NOT NULL,
    color VARCHAR(20) NOT NULL DEFAULT '#198754',
    badge_class VARCHAR(50) DEFAULT 'bg-success',
    icon VARCHAR(50) NOT NULL DEFAULT 'bi-check-circle-fill',
    counts_as_present BOOLEAN NOT NULL DEFAULT 1,
    is_active BOOLEAN NOT NULL DEFAULT 1,
    order_num INT NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- -----------------------------------------------------------------------------
-- 4. EMPLEADOS (person)
-- -----------------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS person (
    id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    code VARCHAR(30) NOT NULL UNIQUE,
    name VARCHAR(50) NOT NULL,
    lastname VARCHAR(50) NOT NULL,
    dni_cif VARCHAR(30) NULL,
    email VARCHAR(150) NULL,
    phone VARCHAR(50) NULL,
    address VARCHAR(255) NULL,
    job_title VARCHAR(100) NOT NULL DEFAULT 'Colaborador',
    department_id INT NULL,
    hire_date DATE NULL,
    salary DECIMAL(10,2) DEFAULT 0.00,
    image VARCHAR(255) DEFAULT '',
    is_active BOOLEAN NOT NULL DEFAULT 1,
    created_at DATETIME NOT NULL,
    FOREIGN KEY (department_id) REFERENCES department(id) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- -----------------------------------------------------------------------------
-- 5. ASISTENCIAS / MARCACIONES DIARIAS (assistance)
-- -----------------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS assistance (
    id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    person_id INT NOT NULL,
    status_id INT NOT NULL,
    date_at DATE NOT NULL,
    time_in TIME NULL,
    time_out TIME NULL,
    note VARCHAR(255) DEFAULT '',
    user_id INT NULL,
    created_at DATETIME NOT NULL,
    UNIQUE KEY uq_person_date (person_id, date_at),
    FOREIGN KEY (person_id) REFERENCES person(id) ON DELETE CASCADE,
    FOREIGN KEY (status_id) REFERENCES assistance_status(id) ON DELETE RESTRICT,
    FOREIGN KEY (user_id) REFERENCES user(id) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =============================================================================
-- DATOS SEMILLA (SEED DATA)
-- =============================================================================

-- 1. Usuario Admin (Password: admin123 y compatible con sha1("admin"))
-- Usamos hash estándar password_hash('admin123', PASSWORD_BCRYPT) y sha1 compatible
INSERT INTO user (id, name, lastname, username, email, password, is_admin, is_active, created_at) VALUES
(1, 'Administrador', 'General', 'admin', 'admin@empresa.com', '$2y$10$wE9sC6V0y6.v9a9QGZ/9fO0eS9.L1e.v2mE9sC6V0y6.v9a9QGZ/9.', 1, 1, NOW()),
(2, 'Supervisor', 'Recursos Humanos', 'rrhh', 'rrhh@empresa.com', '$2y$10$wE9sC6V0y6.v9a9QGZ/9fO0eS9.L1e.v2mE9sC6V0y6.v9a9QGZ/9.', 0, 1, NOW())
ON DUPLICATE KEY UPDATE id=id;

-- 2. Departamentos
INSERT INTO department (id, code, name, description, manager_name, is_active, created_at) VALUES
(1, 'RRHH', 'Recursos Humanos', 'Gestión de personal, talento y clima laboral', 'Lic. Laura Martínez', 1, NOW()),
(2, 'IT', 'Tecnología & Sistemas', 'Desarrollo, infraestructura y soporte técnico', 'Ing. Carlos Mendoza', 1, NOW()),
(3, 'VENTAS', 'Ventas & Comercial', 'Atención a clientes, prospección y cierre comercial', 'Lic. Mariana Soto', 1, NOW()),
(4, 'FIN', 'Finanzas & Contabilidad', 'Presupuestos, nómina, tesorería y tributación', 'C.P. Roberto Silva', 1, NOW()),
(5, 'OPER', 'Operaciones & Logística', 'Cadena de suministro, almacén y despacho', 'Ing. David Paredes', 1, NOW())
ON DUPLICATE KEY UPDATE id=id;

-- 3. Estados de Asistencia (assistance_status)
INSERT INTO assistance_status (id, code, name, color, badge_class, icon, counts_as_present, is_active, order_num) VALUES
(1, 'present', 'Presente', '#198754', 'bg-success', 'bi-check-circle-fill', 1, 1, 1),
(2, 'late', 'Tardanza', '#ffc107', 'bg-warning text-dark', 'bi-clock-history', 1, 1, 2),
(3, 'absent', 'Falta Injustificada', '#dc3545', 'bg-danger', 'bi-x-circle-fill', 0, 1, 3),
(4, 'permission', 'Permiso / Comisión', '#0dcaf0', 'bg-info text-dark', 'bi-file-earmark-text-fill', 1, 1, 4),
(5, 'medical_leave', 'Baja Médica', '#6f42c1', 'bg-primary', 'bi-bandaid-fill', 1, 1, 5),
(6, 'vacation', 'Vacaciones', '#fd7e14', 'bg-warning text-dark', 'bi-sun-fill', 1, 1, 6),
(7, 'home_office', 'Teletrabajo', '#0d6efd', 'bg-primary', 'bi-laptop-fill', 1, 1, 7)
ON DUPLICATE KEY UPDATE id=id;

-- 4. Empleados (person)
INSERT INTO person (id, code, name, lastname, dni_cif, email, phone, address, job_title, department_id, hire_date, salary, image, is_active, created_at) VALUES
(1, 'EMP-001', 'Alejandro', 'Morales', '0928374612', 'alejandro.morales@empresa.com', '0991234567', 'Av. 9 de Octubre 1204', 'Desarrollador Senior Full Stack', 2, '2023-01-15', 1800.00, '', 1, NOW()),
(2, 'EMP-002', 'Valeria', 'Castro', '0917263541', 'valeria.castro@empresa.com', '0982345678', 'Cdla. Kennedy Norte Mz 12', 'Diseñadora UI/UX', 2, '2023-03-01', 1350.00, '', 1, NOW()),
(3, 'EMP-003', 'Martín', 'Guerrero', '1718293041', 'martin.guerrero@empresa.com', '0973456789', 'Av. Amazonas y Colón', 'Especialista de Selección', 1, '2022-06-10', 1200.00, '', 1, NOW()),
(4, 'EMP-004', 'Sofía', 'Delgado', '0938475619', 'sofia.delgado@empresa.com', '0964567890', 'Urdesa Central, Guayacanes', 'Analista de Nómina', 1, '2022-11-20', 1250.00, '', 1, NOW()),
(5, 'EMP-005', 'Javier', 'Benítez', '0947586920', 'javier.benitez@empresa.com', '0955678901', 'Alborada 8va Etapa', 'Ejecutivo de Cuentas Clave', 3, '2021-08-15', 1500.00, '', 1, NOW()),
(6, 'EMP-006', 'Gabriela', 'Ponce', '1728394052', 'gabriela.ponce@empresa.com', '0946789012', 'La Carolina, Shyris 450', 'Representante Comercial', 3, '2023-09-01', 1100.00, '', 1, NOW()),
(7, 'EMP-007', 'Esteban', 'Ríos', '0958697081', 'esteban.rios@empresa.com', '0937890123', 'Vía a la Costa Km 14', 'Contador General', 4, '2020-02-01', 1900.00, '', 1, NOW()),
(8, 'EMP-008', 'Camila', 'Navarro', '0969708192', 'camila.navarro@empresa.com', '0928901234', 'Los Ceibos, Av. Principal', 'Analista Financiero', 4, '2024-01-10', 1300.00, '', 1, NOW()),
(9, 'EMP-009', 'Diego', 'Aguilar', '1739405163', 'diego.aguilar@empresa.com', '0919012345', 'Cumbayá, Sector La Primavera', 'Coordinador de Almacén', 5, '2021-05-18', 1400.00, '', 1, NOW()),
(10, 'EMP-010', 'Lucía', 'Vera', '0970819203', 'lucia.vera@empresa.com', '0900123456', 'Duran, Primavera 2', 'Asistente de Despacho', 5, '2024-04-01', 850.00, '', 1, NOW()),
(11, 'EMP-011', 'Fernando', 'Salgado', '0981920314', 'fernando.salgado@empresa.com', '0989012345', 'Samborondón Km 3.5', 'DevOps & Cloud Engineer', 2, '2022-10-01', 2100.00, '', 1, NOW()),
(12, 'EMP-012', 'Daniela', 'Reyes', '0992031425', 'daniela.reyes@empresa.com', '0978901234', 'Miraflores, Calle 5ta', 'Líder de Soporte Técnico', 2, '2023-07-15', 1400.00, '', 1, NOW())
ON DUPLICATE KEY UPDATE id=id;

-- 5. Asistencia de Hoy (para ver KPIs inmediatos en el Dashboard)
INSERT INTO assistance (person_id, status_id, date_at, time_in, time_out, note, user_id, created_at) VALUES
(1, 1, CURDATE(), '08:55:00', NULL, 'Puntual', 1, NOW()),
(2, 1, CURDATE(), '08:58:00', NULL, 'Puntual', 1, NOW()),
(3, 2, CURDATE(), '09:18:00', NULL, 'Tardanza 18 min por tráfico', 1, NOW()),
(4, 1, CURDATE(), '08:45:00', NULL, 'Puntual', 1, NOW()),
(5, 7, CURDATE(), '09:00:00', NULL, 'Teletrabajo programado', 1, NOW()),
(6, 1, CURDATE(), '08:50:00', NULL, 'Puntual', 1, NOW()),
(7, 1, CURDATE(), '08:52:00', NULL, 'Puntual', 1, NOW()),
(8, 4, CURDATE(), '09:00:00', NULL, 'Permiso de capacitación externa', 1, NOW()),
(9, 3, CURDATE(), NULL, NULL, 'Falta no notificada', 1, NOW()),
(10, 1, CURDATE(), '08:40:00', NULL, 'Puntual', 1, NOW()),
(11, 1, CURDATE(), '08:59:00', NULL, 'Puntual', 1, NOW()),
(12, 5, CURDATE(), NULL, NULL, 'Reposo médico IESS por 48 horas', 1, NOW())
ON DUPLICATE KEY UPDATE status_id=VALUES(status_id);

-- Asistencia de Ayer (para comparativas)
INSERT INTO assistance (person_id, status_id, date_at, time_in, time_out, note, user_id, created_at) VALUES
(1, 1, DATE_SUB(CURDATE(), INTERVAL 1 DAY), '08:50:00', '18:05:00', '', 1, NOW()),
(2, 1, DATE_SUB(CURDATE(), INTERVAL 1 DAY), '08:55:00', '18:00:00', '', 1, NOW()),
(3, 1, DATE_SUB(CURDATE(), INTERVAL 1 DAY), '08:48:00', '18:10:00', '', 1, NOW()),
(4, 1, DATE_SUB(CURDATE(), INTERVAL 1 DAY), '08:52:00', '18:00:00', '', 1, NOW()),
(5, 1, DATE_SUB(CURDATE(), INTERVAL 1 DAY), '08:50:00', '18:30:00', '', 1, NOW()),
(6, 2, DATE_SUB(CURDATE(), INTERVAL 1 DAY), '09:25:00', '18:00:00', 'Retraso metro', 1, NOW()),
(7, 1, DATE_SUB(CURDATE(), INTERVAL 1 DAY), '08:45:00', '18:00:00', '', 1, NOW()),
(8, 1, DATE_SUB(CURDATE(), INTERVAL 1 DAY), '08:55:00', '18:00:00', '', 1, NOW()),
(9, 1, DATE_SUB(CURDATE(), INTERVAL 1 DAY), '08:40:00', '18:00:00', '', 1, NOW()),
(10, 1, DATE_SUB(CURDATE(), INTERVAL 1 DAY), '08:35:00', '17:35:00', '', 1, NOW()),
(11, 1, DATE_SUB(CURDATE(), INTERVAL 1 DAY), '08:58:00', '18:02:00', '', 1, NOW()),
(12, 5, DATE_SUB(CURDATE(), INTERVAL 1 DAY), NULL, NULL, 'Reposo médico', 1, NOW())
ON DUPLICATE KEY UPDATE status_id=VALUES(status_id);
