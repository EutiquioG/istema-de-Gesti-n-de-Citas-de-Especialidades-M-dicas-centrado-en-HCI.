# Sistema de Gestión de Citas de Especialidades Médicas centrado en HCI

##  Descripción del proyecto

El **Sistema de Gestión de Citas de Especialidades Médicas centrado en HCI** es un prototipo de alta fidelidad funcional desarrollado como proyecto académico de la **Maestría en Ingeniería de Software de Broward International University (BIU)**.

El sistema tiene como propósito facilitar la gestión de citas médicas mediante una interfaz intuitiva, minimalista y centrada en las necesidades de los usuarios.

El proyecto aplica principios de **Interacción Humano-Computador (HCI)** durante el diseño y desarrollo de la interfaz, buscando que las tareas principales puedan realizarse de forma clara, consistente y eficiente.

El sistema permite gestionar usuarios, pacientes, médicos, especialidades y citas médicas.

---

#  Objetivo general

Desarrollar un prototipo de alta fidelidad funcional para la gestión de citas de especialidades médicas, aplicando principios de HCI que permitan ofrecer una interacción intuitiva, consistente, accesible y orientada a las necesidades de los usuarios.

---

#  Objetivos específicos

* Diseñar una interfaz centrada en el usuario.
* Aplicar principios de HCI durante el diseño de las interfaces.
* Implementar la gestión de pacientes.
* Implementar la gestión de médicos.
* Implementar la gestión de especialidades.
* Implementar la programación y gestión de citas médicas.
* Implementar diferentes roles de usuario.
* Validar la información ingresada mediante formularios.
* Evitar conflictos en la programación de citas.
* Implementar una arquitectura MVC utilizando Laravel.
* Implementar una API REST.
* Preparar el sistema para su despliegue en infraestructura AWS.

---

# 👥 Roles del sistema

El sistema contempla tres roles principales:

## Administrador

Puede gestionar la información general del sistema:

* Pacientes.
* Médicos.
* Especialidades.
* Citas.
* Usuarios.

## Médico

Puede consultar la información relacionada con sus citas y pacientes según los permisos definidos para el sistema.

## Paciente

Puede consultar y gestionar la información relacionada con sus citas médicas.

---

#  Enfoque HCI

La Interacción Humano-Computador constituye uno de los ejes principales del proyecto.

El sistema no se desarrolla únicamente desde una perspectiva técnica, sino considerando también cómo los usuarios interactúan con la aplicación.

Durante el diseño se consideran principios como:

* Visibilidad del estado del sistema.
* Consistencia.
* Correspondencia con el mundo real.
* Prevención de errores.
* Reconocimiento antes que recuerdo.
* Control y libertad del usuario.
* Diseño minimalista.
* Retroalimentación inmediata.
* Recuperación ante errores.
* Facilidad de aprendizaje.

---

# Diseño de interfaz

La interfaz utiliza un enfoque:

* Minimalista.
* Limpio.
* Consistente.
* Intuitivo.
* Centrado en tareas.
* Orientado a formularios claros.
* Con retroalimentación visual.
* Con componentes reutilizables.

Una característica importante del prototipo es el uso de **ventanas modales** para consultar, crear y editar información.

Esto permite mantener al usuario dentro del contexto de la pantalla principal y reducir navegaciones innecesarias.

---

# 🖥️ Prototipo de alta fidelidad funcional

El proyecto corresponde a un **prototipo de alta fidelidad funcional**.

Esto significa que no se trata solamente de diseños estáticos o wireframes.

La interfaz está conectada con funcionalidades reales del sistema:

```text
Usuario
   ↓
Interfaz
   ↓
Formulario
   ↓
Validación
   ↓
Controlador
   ↓
Servicio
   ↓
Modelo
   ↓
Base de datos
   ↓
Respuesta
   ↓
Retroalimentación al usuario
```

Por esta razón, las operaciones realizadas desde la interfaz interactúan con la base de datos y generan respuestas reales.

---

#  Arquitectura del sistema

El proyecto utiliza el patrón arquitectónico **MVC (Model-View-Controller)** proporcionado por Laravel.

```text
                    USUARIO
                       │
                       ▼
                  VISTA BLADE
                       │
                       ▼
                  CONTROLADOR
                       │
                       ▼
                    SERVICIO
                       │
                       ▼
                     MODELO
                       │
                       ▼
                  BASE DE DATOS
                       │
                       ▼
                    RESPUESTA
                       │
                       ▼
                  VISTA BLADE
```

### Modelo

Representa la información y las relaciones con la base de datos.

Ejemplos:

* User
* Patient
* Doctor
* Specialty
* Appointment

### Vista

Construida utilizando Blade, HTML5, CSS3 y JavaScript.

Las vistas contienen la interfaz que utiliza el usuario.

### Controlador

Gestiona las solicitudes provenientes de las vistas y coordina las operaciones necesarias.

---

# Tecnologías utilizadas

## Backend

* PHP
* Laravel
* Eloquent ORM
* Laravel Breeze
* Laravel Sanctum

## Frontend

* Blade
* HTML5
* CSS3
* JavaScript
* Bootstrap / estilos CSS propios según componente

## Base de datos

* MySQL

## Arquitectura

* MVC
* REST API

## Control de versiones

* Git
* GitHub

## Entorno de desarrollo

* Visual Studio Code
* Windows 11
* Composer
* Node.js/NPM para las dependencias de frontend de Laravel cuando sean requeridas por el proyecto

## Infraestructura

* Amazon Web Services (AWS)
* Amazon EC2

---

# 📂 Estructura general del proyecto

```text
sistema-citas-medicas/
│
├── app/
│   ├── Http/
│   │   └── Controllers/
│   │       ├── API/
│   │       └── Web/
│   │
│   ├── Models/
│   │   ├── Appointment.php
│   │   ├── Doctor.php
│   │   ├── Patient.php
│   │   ├── Specialty.php
│   │   └── User.php
│   │
│   └── Services/
│       └── AppointmentService.php
│
├── database/
│   ├── factories/
│   ├── migrations/
│   └── seeders/
│
├── resources/
│   ├── css/
│   ├── js/
│   └── views/
│       ├── appointments/
│       ├── doctors/
│       ├── patients/
│       ├── specialties/
│       └── layouts/
│
├── routes/
│   ├── api.php
│   └── web.php
│
├── public/
│
├── storage/
│
├── tests/
│
├── .env.example
├── artisan
├── composer.json
├── package.json
└── README.md
```

---

# 🗄️ Modelo de datos

El sistema utiliza una base de datos relacional.

Las principales entidades son:

```text
USERS
   │
   ├──────── PATIENTS
   │
   └──────── DOCTORS
                │
                ▼
           SPECIALTIES
                │
                ▼
            APPOINTMENTS
           /            \
          /              \
     PATIENT            DOCTOR
```

## Entidades principales

### Users

Gestiona la autenticación y los roles del sistema.

### Patients

Contiene la información de los pacientes.

### Doctors

Contiene la información de los médicos.

### Specialties

Contiene las especialidades médicas disponibles.

### Appointments

Contiene la información de las citas médicas.

---

# 📋 Estados principales

## Pacientes

```text
activo
inactivo
```

## Médicos

```text
activo
inactivo
```

## Especialidades

```text
activo
inactivo
```

## Citas

```text
pendiente
confirmada
atendida
cancelada
```

---

#  Gestión de citas

La programación de citas considera:

* Paciente.
* Médico.
* Especialidad.
* Fecha.
* Hora.
* Motivo de consulta.
* Estado.

El sistema evita que un médico tenga dos citas en la misma fecha y hora.

La combinación:

```text
doctor_id
+
fecha
+
hora
```

se maneja como una combinación única para prevenir conflictos.

Las citas canceladas no bloquean nuevamente el horario.

---

#  Autenticación y autorización

El sistema utiliza Laravel Breeze para la autenticación.

Los roles principales son:

```text
admin
medico
paciente
```

El modelo `User` permite determinar el rol del usuario mediante métodos como:

```php
isAdmin()
isMedico()
isPaciente()
```

Esto permite controlar el acceso a las diferentes funcionalidades.

---

#  API REST

El proyecto también cuenta con una API REST protegida mediante autenticación.

Se utilizan recursos para:

```text
/api/patients
/api/doctors
/api/specialties
/api/appointments
```

También se dispone de funcionalidades relacionadas con:

```text
doctors/by-specialty/{specialty}
appointments/horas-ocupadas
```

La API permite separar las funcionalidades del backend de la interfaz y facilita futuras integraciones.

---

# 🚀 Instalación local

## 1. Requisitos

Antes de instalar el proyecto se recomienda contar con:

* PHP compatible con la versión de Laravel utilizada.
* Composer.
* MySQL.
* Git.
* Node.js y NPM.
* Servidor web o PHP Artisan.
* Visual Studio Code.

---

## 2. Clonar el repositorio

```bash
git clone URL_DEL_REPOSITORIO
```

Ingresar al proyecto:

```bash
cd sistema-citas-medicas
```

---

#  3. Instalar dependencias PHP

Ejecutar:

```bash
composer install
```

---

#  4. Crear archivo .env

Copiar el archivo de configuración:

```bash
cp .env.example .env
```

En Windows también puede utilizarse:

```bash
copy .env.example .env
```

---

#  5. Generar clave de Laravel

```bash
php artisan key:generate
```

---

#  6. Configurar MySQL

Crear una base de datos, por ejemplo:

```text
citas_medicas
```

Posteriormente configurar el archivo `.env`:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=citas_medicas
DB_USERNAME=root
DB_PASSWORD=
```

Los valores deben adaptarse a la configuración local de MySQL.

---

#  7. Ejecutar migraciones

```bash
php artisan migrate
```

Si el proyecto contiene seeders:

```bash
php artisan db:seed
```

O:

```bash
php artisan migrate --seed
```

---

#  8. Instalar dependencias frontend

```bash
npm install
```

Para desarrollo:

```bash
npm run dev
```

---

#  9. Ejecutar Laravel

En otra terminal:

```bash
php artisan serve
```

El sistema estará disponible normalmente en:

```text
http://127.0.0.1:8000
```

---

#  Comandos útiles

Limpiar cachés:

```bash
php artisan optimize:clear
```

Ver rutas:

```bash
php artisan route:list
```

Ver estado de migraciones:

```bash
php artisan migrate:status
```

Crear migración:

```bash
php artisan make:migration nombre_migracion
```

Crear modelo:

```bash
php artisan make:model NombreModelo
```

Crear controlador:

```bash
php artisan make:controller NombreController
```

---

# Git y GitHub

Para guardar los cambios:

```bash
git status
```

Agregar archivos:

```bash
git add .
```

Crear commit:

```bash
git commit -m "Actualización sistema de citas médicas"
```

Enviar a GitHub:

```bash
git push origin main
```

---

#  Despliegue en AWS

El proyecto se prepara para ser desplegado utilizando infraestructura de **Amazon Web Services (AWS)**.

Para el servidor se utilizará:

```text
AWS
 │
 └── EC2
      │
      ├── Linux
      ├── Git
      ├── PHP
      ├── Composer
      ├── Laravel
      └── MySQL
```

---

# ☁️ Arquitectura de despliegue

La arquitectura propuesta es:

```text
                 INTERNET
                    │
                    ▼
              AMAZON EC2
                    │
              ┌─────┴─────┐
              │           │
           WEB SERVER   LARAVEL
              │           │
              └─────┬─────┘
                    │
                    ▼
                  MYSQL
```

El código fuente será obtenido desde GitHub:

```text
GITHUB
   │
   │ git clone
   ▼
AMAZON EC2
   │
   ▼
LARAVEL
   │
   ▼
MYSQL
```

---

#  Proceso de despliegue en AWS EC2

El proceso de despliegue seguirá las siguientes etapas:

## 1. Crear o utilizar una instancia EC2

Se seleccionará una configuración compatible con los beneficios gratuitos/créditos disponibles en la cuenta AWS.

## 2. Configurar acceso al servidor

Se utilizará SSH para conectarse a la instancia.

## 3. Actualizar Linux

```bash
sudo apt update
sudo apt upgrade -y
```

## 4. Instalar Git

```bash
sudo apt install git -y
```

## 5. Instalar PHP

Se instalarán PHP y las extensiones necesarias para ejecutar Laravel.

## 6. Instalar Composer

Composer permitirá instalar las dependencias PHP del proyecto.

## 7. Clonar el proyecto

```bash
git clone URL_DEL_REPOSITORIO
```

## 8. Configurar Laravel

```bash
composer install
```

Crear `.env`:

```bash
cp .env.example .env
```

Generar la clave:

```bash
php artisan key:generate
```

## 9. Configurar MySQL

Se creará y configurará la base de datos utilizada por Laravel.

## 10. Ejecutar migraciones

```bash
php artisan migrate --seed
```

## 11. Configurar servidor web

Posteriormente se configurará Apache o Nginx para servir Laravel correctamente.

## 12. Configurar acceso mediante navegador

Una vez configurado el servidor:

```text
http://IP_DEL_SERVIDOR
```

permitirá acceder al sistema.

---

#  Consideraciones de seguridad

El archivo `.env` contiene información sensible y **no debe subirse al repositorio público**.

El repositorio debe utilizar:

```text
.env.example
```

como plantilla.

El archivo:

```text
.env
```

debe permanecer fuera de Git.

También se recomienda no almacenar:

* Contraseñas.
* Claves privadas.
* Tokens.
* Credenciales AWS.
* Información sensible de usuarios.

---

# Fase de Diseño

Dentro del repositorio se documentará una carpeta:

```text
Fase de Diseño/
```

con los siguientes elementos:

```text
Fase de Diseño/
│
├── 01_Diseño_Conceptual/
│
├── 02_Modelo_Relacional/
│
├── 03_Diagrama_Casos_de_Uso/
│
├── 04_Arquitectura_de_Software/
│
├── 05_Mapa_de_Navegacion/
│
└── README.md
```

Esta fase documenta las decisiones de diseño tomadas antes y durante la implementación.

---

#  Proceso de diseño HCI

El proceso general utilizado en el proyecto puede representarse así:

```text
Identificación de usuarios
          ↓
Identificación de necesidades
          ↓
Definición de tareas
          ↓
Arquitectura de información
          ↓
Diseño de interacción
          ↓
Prototipado
          ↓
Implementación
          ↓
Evaluación y mejora
```

---

#  Flujo general del sistema

```text
                    INICIO
                      │
                      ▼
                  LOGIN
                      │
                      ▼
                 AUTENTICACIÓN
                      │
             ┌────────┼────────┐
             │        │        │
             ▼        ▼        ▼
           ADMIN    MÉDICO   PACIENTE
             │        │        │
             ▼        ▼        ▼
        GESTIÓN    CITAS    MIS CITAS
        GENERAL
             │
      ┌──────┼──────────┐
      │      │          │
      ▼      ▼          ▼
 PACIENTES MÉDICOS ESPECIALIDADES
             │
             ▼
            CITAS
```

---

# 🧪 Estado del proyecto

Actualmente el proyecto cuenta con:

* [x] Laravel configurado.
* [x] Autenticación.
* [x] Roles de usuario.
* [x] Modelo de pacientes.
* [x] Modelo de médicos.
* [x] Modelo de especialidades.
* [x] Modelo de citas.
* [x] Migraciones.
* [x] Relaciones Eloquent.
* [x] CRUD de pacientes.
* [x] CRUD de médicos.
* [x] CRUD de especialidades.
* [x] Gestión de citas.
* [x] Validaciones.
* [x] Modales de interacción.
* [x] Diseño minimalista.
* [x] Aplicación de principios HCI.
* [x] API REST.
* [ ] Despliegue completo en AWS.
* [ ] Configuración final del servidor web.
* [ ] Configuración de dominio/HTTPS, si aplica.

---

# 📚 Propósito académico

Este proyecto forma parte del proceso académico de la **Maestría en Ingeniería de Software** y busca integrar conocimientos de:

* Ingeniería de software.
* Desarrollo web.
* Arquitectura de software.
* Bases de datos.
* Desarrollo backend.
* Desarrollo frontend.
* Interacción Humano-Computador.
* Diseño de interfaces.
* APIs REST.
* Control de versiones.
* Computación en la nube.

---

# 👨‍💻 Autor

**Eutiquio González Leivaz**

Estudiante de la Maestría en Ingeniería de Software
Broward International University — BIU

---

# 📄 Licencia

Este proyecto ha sido desarrollado con fines principalmente académicos.

El uso, modificación y distribución del código deberá respetar las condiciones establecidas por el autor y las dependencias utilizadas por el proyecto.

---

#  Nota

Este README se actualizará conforme avance el proyecto, especialmente durante la etapa de despliegue en AWS y la documentación de la Fase de Diseño.
