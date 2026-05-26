# Declaración de Uso de Inteligencia Artificial

Este documento detalla el uso de herramientas basadas en Inteligencia Artificial (IA) durante el desarrollo y construcción de este proyecto (Portfolio Personal y Panel de Administración).

## 1. Herramientas Utilizadas

Durante el ciclo de vida del desarrollo de este proyecto, se utilizaron asistentes de programación basados en Modelos de Lenguaje Grande (LLMs), específicamente **Gemini / Antigravity IDE**, operando como un asistente avanzado de codificación e integrado en el entorno de desarrollo.

## 2. Áreas de Aplicación

La Inteligencia Artificial se empleó activamente en las siguientes áreas del proyecto:

- **Desarrollo Backend (PHP & MySQL):** 
  - Asistencia en la creación de una arquitectura basada en APIs RESTful (`api/projects_api.php`, `api/messages_api.php`, `api/contact_api.php`).
  - Implementación de buenas prácticas de seguridad, como el uso de PDO (PHP Data Objects) para consultas preparadas y prevención de inyección SQL, así como el uso de `password_hash` y `password_verify` para la gestión de usuarios.

- **Desarrollo Frontend (HTML, CSS, Vanilla JS):** 
  - Generación rápida de plantillas y estructuras con **Bootstrap 5**, asegurando un diseño responsivo (Mobile-First).
  - Ayuda en la redacción de scripts de JavaScript para realizar peticiones asíncronas utilizando la **Fetch API**, actualizando el DOM dinámicamente (por ejemplo, el intercambio de pestañas entre "Proyectos" y "Mensajes" en el Dashboard).

- **Estructuración y Gestión de Base de Datos:** 
  - Diseño inicial del esquema relacional en el archivo `database.sql`, incluyendo la definición de claves primarias, tipos de datos y generación de datos semilla (mock data) para pruebas.

- **Refactorización y Depuración de Código:** 
  - Identificación de errores de sintaxis o de lógica, resolución de problemas de enrutamiento y refactorización de código para mantener un estándar limpio y modular.

## 3. Metodología de Trabajo

La IA se utilizó bajo el paradigma de **Pair Programming (Programación por pares)**. Las decisiones de diseño, la lógica de negocio y la arquitectura general fueron dirigidas por el desarrollador. La IA actuó como un copiloto para:
1. **Acelerar el desarrollo (Boilerplate):** Escribir estructuras repetitivas o configuraciones iniciales.
2. **Consultas técnicas:** Responder dudas sobre la sintaxis de PHP o JavaScript.
3. **Resolución de problemas:** Analizar mensajes de error o comportamientos inesperados en el código y sugerir soluciones específicas para el contexto del proyecto.

El código generado por la IA siempre fue revisado, comprendido, testeado y adaptado manualmente a las necesidades exactas del entorno de desarrollo local (XAMPP).

## 4. Impacto en el Proyecto

El uso de estas herramientas resultó en:
- Una reducción significativa en el tiempo dedicado a la búsqueda de documentación y resolución de errores (debugging).
- Un aumento en la calidad general del código mediante la adopción sugerida de buenas prácticas estándar de la industria.
- La facilitación del aprendizaje continuo y la experimentación de nuevas formas de implementar soluciones lógicas.
