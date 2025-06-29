# SQL_DATABASES

A comprehensive web application for movie management built with PHP and MySQL, featuring a complete CRUD system with database administration tools, containerized with Docker for streamlined deployment.

## Description

This project implements a robust movie management system using traditional SQL technologies. The application provides full CRUD operations for movies management across two distinct modules: directors and movies. It includes database administration capabilities through phpMyAdmin and features comprehensive movie and director management functionality.

## Technologies Used

- **Backend**: PHP with Apache HTTP Server
- **Database**: MySQL 8.0
- **Database Administration**: phpMyAdmin
- **Containerization**: Docker & Docker Compose
- **Web Server**: Apache HTTP Server

## Project Structure

```
SQL_DATABASES/
├── apache-php/                 # Apache and PHP configuration
│   └── Dockerfile             # PHP/Apache container configuration
├── app/                       # Main application directory
│   ├── actores/              # Actors management module
│   │   ├── create.php        # Create actor logic
│   │   ├── delete.php        # Delete actor logic
│   │   ├── lista.php         # Actors listing
│   │   ├── update_form.php   # Actor update form
│   │   └── update.php        # Update actor logic
│   ├── directores/           # Directors management module
│   │   ├── create_form.php   # Director creation form
│   │   ├── create.php        # Create director logic
│   │   ├── delete.php        # Delete director logic
│   │   ├── lista.php         # Directors listing
│   │   ├── update_form.php   # Director update form
│   │   └── update.php        # Update director logic
│   ├── peliculas/            # Movies management module
│   │   ├── create.php        # Create movie logic
│   │   ├── delete.php        # Delete movie logic
│   │   ├── lista.php         # Movies listing
│   │   ├── update_form.php   # Movie update form
│   │   └── update.php        # Update movie logic
│   ├── db.php                # Database connection configuration
│   ├── index.php             # Main application page
│   ├── init.sql              # Database initialization script
│   └── test.php              # Testing utilities
└── docker-compose.yml        # Container orchestration
```

## Features

- **Movies Management**: Complete CRUD operations for movie records
- **Directors Management**: Full director information management
- **Actors Management**: Comprehensive actor data handling
- **Database Administration**: Integrated phpMyAdmin interface
- **Relational Data**: Proper relationships between movies, directors, and actors
- **Containerized Environment**: Isolated and portable deployment
- **Automatic Database Setup**: Pre-configured database initialization

## Prerequisites

- Docker
- Docker Compose
- Git

## Installation and Configuration

1. **Clone the repository**
   ```bash
   git clone https://github.com/your-username/SQL_DATABASES.git
   cd SQL_DATABASES
   ```

2. **Build and run containers**
   ```bash
   docker-compose up -d
   ```

3. **Access the services**
   - Web application: `http://localhost:8088`
   - phpMyAdmin: `http://localhost:8081`
   - MySQL database: `localhost:3306`

## Services Configuration

The application consists of three main services:

### MySQL Database Service
- **Container**: mysql_db
- **Image**: mysql:8.0
- **Port**: 3306
- **Database**: crud_db
- **Credentials**: 
  - Root password: root
  - User: user
  - Password: password
- **Initialization**: `init.sql` script executed on first run
- **Persistent Storage**: Named volume `db_data`

### PHP/Apache Service
- **Container**: apache_php
- **Port**: 8088 (mapped to container port 80)
- **Volume Mount**: Application code from `./app` to `/var/www/html`
- **Dependencies**: Waits for database service to be ready

### phpMyAdmin Service
- **Container**: myadmin
- **Image**: phpmyadmin/phpmyadmin
- **Port**: 8081
- **Database Host**: Connects to `db` service
- **Access**: Web-based MySQL administration

## Database Schema

The application manages three main entities:

- **Movies (peliculas)**: Core movie information
- **Directors (directores)**: Director details and information
- **Actors (actores)**: Actor profiles and data

The database structure is automatically created through the `init.sql` script during container initialization.

## Usage

### Web Application Access
Navigate to `http://localhost:8088` to access the main application interface.

### Available Modules

1. **Movies Management** (`/peliculas/`)
   - View movie listings
   - Add new movies
   - Edit existing movies
   - Delete movies

2. **Directors Management** (`/directores/`)
   - Browse directors database
   - Create director profiles
   - Update director information
   - Remove directors

3. **Actors Management** (`/actores/`)
   - Access actors catalog
   - Register new actors
   - Modify actor details
   - Delete actor records

### Database Administration
Access phpMyAdmin at `http://localhost:8081` using:
- **Server**: db
- **Username**: root
- **Password**: root

## Development

### Local Development Setup

1. Ensure Docker and Docker Compose are installed
2. Clone the repository
3. Run `docker-compose up -d` to start all services
4. The application will be available at `http://localhost:8088`
5. Database administration at `http://localhost:8081`

### Database Management

- **Connection Details**: Configure in `db.php`
- **Schema Changes**: Modify `init.sql` for database structure updates
- **Data Persistence**: Database data is stored in Docker volume `db_data`

### Port Configuration

Default ports can be modified in `docker-compose.yml`:
- Web application: Port 8088 (host) → 80 (container)
- phpMyAdmin: Port 8081 (host) → 80 (container)
- MySQL: Port 3306 (host) → 3306 (container)

## Architecture

The application follows a traditional three-tier architecture:

- **Presentation Layer**: PHP pages with HTML forms
- **Business Logic Layer**: PHP scripts for CRUD operations
- **Data Layer**: MySQL database with relational structure
- **Infrastructure Layer**: Docker containers for service isolation

## Security Considerations

- Database credentials management through environment variables
- Input validation and sanitization in PHP scripts
- Container network isolation
- Persistent volume encryption capability
- phpMyAdmin access control
