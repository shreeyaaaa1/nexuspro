# Quick Setup Guide

1. **Prerequisites**
   - Docker
   - Docker Compose

2. **Initial Setup**
   ```bash
   # Copy environment file
   cp .env.example .env
   
   # Build and start containers
   docker compose build
   docker compose up -d
   
   # Wait ~30 seconds for MySQL to initialize
   # Then set up database schema
   docker compose exec mysql mysql -urcmwa_user -psecret_password rcmwa_db < init.sql
   ```

3. **Access the Application**
   - Open http://localhost in your browser
   - Click "Register" to create an account
   - Log in with your new credentials

4. **Test the Application**
   - Create a research project
   - View your profile
   - Try uploading content

5. **Troubleshooting**
   - View logs: `docker compose logs`
   - Restart services: `docker compose restart`
   - Reset everything: `docker compose down -v`