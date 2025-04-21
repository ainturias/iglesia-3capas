# Iglesia - Sistema de Gestión (Arquitectura 3 Capas)

Este proyecto es una aplicación web desarrollada en **PHP puro** utilizando la arquitectura de **3 capas** (Presentación, Negocio, Datos). Está diseñado para gestionar la información de una iglesia, incluyendo miembros, ministerios, sacramentos, cursos, y más.

## 📂 Estructura del Proyecto

- `presentacion/` → Vistas (formularios, HTML)
- `negocio/` → Lógica de negocio (gestores)
- `datos/` → Acceso a datos (DAOs)
- `index.php` → Página de inicio

## ⚙️ Funcionalidades principales

- CRUD de Miembros
- Gestión de Ministerios
- Registro de Sacramentos
- Escuela de líderes (cursos y notas)
- Registro de Membresía

## 🧠 Arquitectura usada

- **Capa de Presentación**: interfaces web simples en HTML + PHP
- **Capa de Negocio**: validaciones y control de flujo de datos
- **Capa de Datos**: conexión y manipulación directa con MySQL (PDO)

## 📦 Requisitos

- [XAMPP](https://www.apachefriends.org/es/index.html) o [Laragon](https://laragon.org/)
- PHP 7.4 o superior
- MySQL
- Git (opcional para clonarlo)

## 🚀 Instalación rápida

1. Cloná el repositorio:
   ```bash
   git clone https://github.com/ainturias/iglesia-3capas.git
