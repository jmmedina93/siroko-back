# Siroko - Carrito y Checkout API

## Descripción

Este proyecto implementa la API backend para la gestión del carrito de compra y el proceso de checkout con generación de orden para la plataforma Siroko.

La solución está desarrollada en PHP con Symfony, siguiendo principios de arquitectura hexagonal, DDD y CQRS para un código limpio, desacoplado y escalable.

---

## Tecnologías utilizadas

- PHP 8.2  
- Symfony 6
- Doctrine ORM con PostgreSQL  
- Docker y Docker Compose  
- PHPUnit para testing  

---

## Arquitectura y diseño

- Dominio desacoplado del framework.  
- Contextos de carrito (CartContext) y orden (OrderContext) separados.  
- Uso de Command y Query (CQRS).  
- Uso de Value Objects, Entidades y Repositorios.  
- API REST desacoplada de cualquier interfaz de usuario (no incluye frontend).  

---

## Cómo levantar el entorno

### 1. Clonar el repositorio
```bash
git clone https://github.com/tu-usuario/siroko-carrito-checkout.git
cd siroko-carrito-checkout
```
### 2. Construir y levantar los contenedores Docker
```bash
docker compose up -d --build
```
O
```bash
make up
```
### 3. Ejecutar migraciones en la base de datos
```bash
docker compose exec php php bin/console doctrine:migrations:migrate
```
O
```bash
make migrations
```

---

## Cómo ejecutar tests

Para lanzar todos los tests unitarios y funcionales:
```bash
docker compose exec php php bin/phpunit
```
O
```bash
make test
```

---

## Endpoints principales

### Carrito

- POST /api/cart/add - Añadir producto al carrito  
- PUT /api/cart/update - Actualizar cantidad de producto  
- DELETE /api/cart/remove - Eliminar producto del carrito  
- GET /api/cart/{cartId} - Obtener carrito  

### Orden

- POST /api/order/checkout - Procesar pago y generar orden  
- GET /api/order/{orderId} - Obtener detalles de orden  

---

## Documentación OpenAPI

Incluye especificación OpenAPI para importar en Postman o Swagger.  
(Archivo openapi.yaml en la raíz)

---

### Notas

- La base de datos para entorno de desarrollo está configurada en .env  
- Para tests se usa .env.test con base de datos independiente  

---

### Cosas a mejorar en una v2

- Añadir mas cobertura de test
- Una interfaz grafica (desacoplada al proyecto)
- Introducir NelmioApiDoc para tener swagger directamente incluido en nuestro proyecto
- Gestion de usuarios
- Reemplazo de productos simulados por catálogo real en base de datos
- Guardado automático del carrito en sesión o token temporal
- Análisis estático para mejorar calidad de código como puede ser PhpStan y CSFixer

---

### Autor

Juan Martínez  
https://github.com/jmmedina93
