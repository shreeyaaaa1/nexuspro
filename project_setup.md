# Project Setup Guide

This guide will help you get the project up and running. Based on the project structure, this appears to be a PHP web application using Docker for containerization.

## Prerequisites

1. Make sure you have the following installed on your system:
   - Docker
   - Docker Compose

## Setup Steps

1. Clone the project repository to your local machine

2. Navigate to the project directory in your terminal

3. Start the application using Docker Compose:
   ```bash
   docker compose up -d
   ```

4. The application should now be running. Access it through your web browser:
   - Main application: `http://localhost` (default port)
   - You may need to visit the login page first at: `http://localhost/pages/login.php`

## Project Structure

The project is structured as follows:
- `/assets`: Contains CSS and JavaScript files
- `/config`: Contains configuration files
- `/includes`: Core PHP functions and components
- `/pages`: Application pages and features
  - Main pages: login, register, dashboard, profile
  - Research section: create, list, and view research items

## Initial Setup

1. Make sure all database migrations are run (check `init.php` for database initialization)
2. Register a new user account through the registration page
3. Log in with your credentials
4. You should now have access to all features including the research section

## Troubleshooting

If you encounter any issues:
1. Check Docker logs: `docker compose logs`
2. Ensure all required services are running: `docker compose ps`
3. Verify database connectivity through the configuration
4. Check file permissions in the project directory

## Note
The application uses PHP 8.1 with Apache and MySQL 8.0. Docker Compose will handle setting up all required services and dependencies.

## Environment Setup

1. Copy the `.env.example` file to `.env`:
   ```bash
   cp .env.example .env
   ```

2. Update the `.env` file with your preferred database credentials (default values are already set)

3. Build and start the containers:
   ```bash
   docker compose build
   docker compose up -d
   ```

4. Wait a few moments for MySQL to initialize, then create the database schema:
   ```bash
   docker compose exec mysql mysql -u${MYSQL_USER} -p${MYSQL_PASSWORD} ${MYSQL_DATABASE} < init.sql
   ```

5. The application should now be running at http://localhost

## Default Credentials
The application uses environment-based configuration. Default database credentials are:
- Database User: rcmwa_user
- Database Password: secret_password
- Database Name: rcmwa_db

You can modify these in the .env file before building the containers.