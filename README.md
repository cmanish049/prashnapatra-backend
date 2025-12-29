# Prashnapatra Backend

A question paper management system backend built with Laravel 12 and Filament v4.

## Tech Stack

- PHP 8.5+
- Laravel 12
- Filament v4 (Admin Panel)
- Livewire v3
- Tailwind CSS v4
- Pest (Testing)

## Data Models

- **Universities** - Educational institutions
- **Programs** - Academic programs (many-to-many with Universities)
- **Subjects** - Course subjects (belongs to University and Program)
- **Question Papers** - Past exam papers (belongs to Subject, University, and Program)

## Requirements

- PHP 8.5 or higher
- Composer
- Node.js & NPM
- SQLite/MySQL/PostgreSQL

## Installation

```bash
# Clone the repository
git clone git@github.com:cmanish049/prashnapatra-backend.git
cd prashnapatra-backend

# Install dependencies and setup
composer setup
```

The `composer setup` command will:
- Install PHP dependencies
- Copy `.env.example` to `.env`
- Generate application key
- Run database migrations
- Install NPM dependencies
- Build frontend assets

## Development

```bash
# Start the development server
composer dev
```

This starts the Laravel server, queue worker, log viewer (Pail), and Vite dev server concurrently.

## Testing

```bash
composer test
```

## Admin Panel

Access the Filament admin panel at `/admin` after starting the development server.

## License

MIT