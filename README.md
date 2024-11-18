# nexuspro
The project is focused on developing a Research Content Management Web Application (RCMWA) designed to address challenges in managing research data. 
# Complete Setup Instructions

## Prerequisites
- Docker Desktop (for Windows/Mac) or Docker Engine + Docker Compose (for Linux)
- Git (to clone the repository)
- Web browser

## Step-by-Step Setup

1. **Clone and Navigate**
   ```bash
   git clone [repository-url]
   cd [repository-directory]
   ```

2. **Configure Environment**
   ```bash
   # Copy the environment file
   cp .env.example .env
   ```
   The default values in .env.example should work fine for local development.

3. **Build and Launch**
   ```bash
   # Build the containers
   docker compose build
   
   # Start the services
   docker compose up -d
   ```

4. **Initialize Database**
   ```bash
   # Wait 30 seconds for MySQL to be ready
   sleep 30
   
   # Create database schema
   docker compose exec mysql mysql -urcmwa_user -psecret_password rcmwa_db -e "
   CREATE TABLE IF NOT EXISTS users (
       id INT AUTO_INCREMENT PRIMARY KEY,
       name VARCHAR(255) NOT NULL,
       email VARCHAR(255) NOT NULL UNIQUE,
       password VARCHAR(255) NOT NULL,
       created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
   );

   CREATE TABLE IF NOT EXISTS research_projects (
       id INT AUTO_INCREMENT PRIMARY KEY,
       user_id INT NOT NULL,
       title VARCHAR(255) NOT NULL,
       description TEXT,
       metadata JSON,
       created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
       updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
       FOREIGN KEY (user_id) REFERENCES users(id)
   );"
   ```

5. **Verify Installation**
   - Open http://localhost in your browser
   - You should see the login page
   - Register a new account via the "Register" link
   - Try logging in with your new account

6. **Test Core Features**
   - Create a new research project
   - Upload some test content
   - Edit your profile
   - Try searching for content

## Common Issues and Solutions

1. **If the page shows database connection error:**
   ```bash
   # Restart the containers
   docker compose restart
   
   # Check if MySQL is running
   docker compose ps
   ```

2. **If MySQL won't start:**
   ```bash
   # Check the logs
   docker compose logs mysql
   
   # Try resetting the database volume
   docker compose down -v
   docker compose up -d
   ```

3. **If file uploads fail:**
   - Check MAX_UPLOAD_SIZE in .env file
   - Default is 10M, increase if needed
   - Restart containers after changing

4. **Permission Issues:**
   ```bash
   # Fix permissions on the app container
   docker compose exec app chown -R www-data:www-data /var/www/html
   ```

## Commands Reference

1. **View Application Logs**
   ```bash
   # All logs
   docker compose logs
   
   # Just PHP application logs
   docker compose logs app
   
   # Just MySQL logs
   docker compose logs mysql
   ```

2. **Restart Services**
   ```bash
   # Restart everything
   docker compose restart
   
   # Restart just the app
   docker compose restart app
   ```

3. **Reset Everything**
   ```bash
   # Stop and remove containers, networks, volumes
   docker compose down -v
   
   # Rebuild and start fresh
   docker compose up -d --build
   ```

## Default Configuration

- Application URL: http://localhost
- Database:
  - Host: mysql
  - Name: rcmwa_db
  - User: rcmwa_user
  - Password: secret_password
- Upload Limit: 10MB

## Security Notes

1. For production deployment:
   - Change all default passwords in .env file
   - Use strong MySQL root password
   - Enable HTTPS
   - Set appropriate file permissions
   - Configure proper backup strategy

2. Development environment:
   - Default credentials are fine for local testing
   - Don't use default credentials in production
   - Keep your Docker installation updated
