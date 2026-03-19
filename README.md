# Laravel Starter Docker

A batteries-included Laravel 13 starter template with Docker, Vue 3, Inertia.js, and a full local dev stack pre-configured.

## What's Included

- **Laravel 13** with Inertia.js + Vue 3 + TypeScript
- **PHP 8.4 FPM** (Alpine)
- **Nginx** reverse proxy
- **MariaDB 11** database
- **Redis** for cache, queues, and broadcasting
- **Laravel Horizon** for queue management and monitoring
- **Laravel Reverb** WebSocket server for real-time broadcasting
- **Laravel Echo** frontend WebSocket client
- **Vite** dev server with HMR
- **Mailpit** for local email testing
- **Scheduler** container for cron-like scheduled tasks
- **Fortify** authentication with 2FA support

## Requirements

- Docker & Docker Compose

## Getting Started

```bash
# Build and start all containers
docker compose up -d --build

# Install PHP dependencies
docker compose exec app composer install

# Install frontend dependencies
docker compose exec app npm install

# Generate app key
docker compose exec app php artisan key:generate

# Run migrations
docker compose exec app php artisan migrate

# (Optional) Seed the database
docker compose exec app php artisan db:seed
```

## Services

| Service    | URL / Port             | Description                                  |
|------------|------------------------|----------------------------------------------|
| Nginx      | http://localhost:9005   | Web server                                   |
| Horizon    | http://localhost:9005/horizon | Queue dashboard                        |
| Reverb     | ws://localhost:8080     | WebSocket server                             |
| Vite HMR   | http://localhost:5173  | Frontend hot reload                          |
| MariaDB    | localhost:3306          | Database (user: `laravel` / pass: `secret`)  |
| Redis      | localhost:6379          | Cache / queues / broadcasting                |
| Mailpit    | http://localhost:8025   | Email testing UI                             |
| Mailpit SMTP | localhost:1025        | SMTP inbox                                   |

## Docker Containers

| Container   | Purpose                                      |
|-------------|----------------------------------------------|
| `app`       | PHP-FPM process (serves the Laravel app)     |
| `nginx`     | Web server, proxies to PHP-FPM               |
| `node`      | Vite dev server with HMR                     |
| `mariadb`   | MariaDB 11 database                          |
| `redis`     | Redis for cache, queues, broadcasting        |
| `horizon`   | Laravel Horizon queue worker                 |
| `reverb`    | Laravel Reverb WebSocket server              |
| `scheduler` | Runs `php artisan schedule:work`             |
| `mailpit`   | Catches all outgoing email                   |

## Common Commands

```bash
# Start / stop
docker compose up -d
docker compose down

# Rebuild (after Dockerfile changes)
docker compose up -d --build

# View logs
docker compose logs -f              # all services
docker compose logs -f app          # php-fpm
docker compose logs -f horizon      # queue worker
docker compose logs -f reverb       # websocket server
docker compose logs -f scheduler    # scheduled tasks

# Artisan
docker compose exec app php artisan migrate
docker compose exec app php artisan migrate:fresh --seed
docker compose exec app php artisan tinker

# Composer
docker compose exec app composer install
docker compose exec app composer require some/package

# npm
docker compose exec app npm install
docker compose exec app npm run build

# Database shell
docker compose exec mariadb mysql -ularavel -psecret laravel
```

## Real-Time Broadcasting

This template includes a working Reverb + Echo setup with a demo event. A `DemoNotification` event broadcasts on a public `demo` channel every 10 seconds via the scheduler, and a toast notification component on the Welcome page listens for it.

To use broadcasting in your own code:

1. Create an event implementing `ShouldBroadcast`
2. Define channels in `routes/channels.php`
3. Listen with `window.Echo.channel('name').listen('.event', callback)` on the frontend

## Stopping & Cleanup

```bash
# Stop containers (preserves data)
docker compose down

# Stop and remove volumes (destroys database data)
docker compose down -v
```
