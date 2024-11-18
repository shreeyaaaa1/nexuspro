# Running the Project

Follow these steps to run the Research Content Management Web Application:

## Step 1: Environment Setup
1. Ensure Docker and Docker Compose are installed on your system
2. Clone the repository to your local machine
3. Navigate to the project directory

## Step 2: Configuration
1. Copy the environment file:
   ```bash
   cp .env.example .env
   ```
   (The default credentials should work fine for local development)

## Step 3: Build and Start Containers
1. Build the Docker images:
   ```bash
   docker compose build
   ```

2. Start the containers:
   ```bash
   docker compose up -d
   ```

## Step 4: Database Setup
1. Wait a few moments for MySQL to initialize (about 30 seconds)
2. Initialize the database schema:
   ```bash
   docker compose exec mysql mysql -urcmwa_user -psecret_password rcmwa_db < init.sql
   ```

## Step 5: Access the Application
1. Open your web browser
2. Visit http://localhost
3. You should see the login page

## Step 6: Create an Account
1. Click on the "Register" link
2. Fill in your details:
   - Name
   - Email
   - Password
3. Submit the registration form
4. Log in with your new credentials

## Step 7: Verify Everything Works
1. After logging in, you should see the dashboard
2. Try creating a new research project
3. Verify you can view and edit your profile

## Troubleshooting

If you encounter any issues:

1. Check container status:
   ```bash
   docker compose ps
   ```

2. View container logs:
   ```bash
   docker compose logs
   ```

3. Common issues:
   - If the database connection fails, ensure MySQL is fully initialized
   - If pages don't load, check Apache logs:
     ```bash
     docker compose logs app
     ```
   - For permission issues:
     ```bash
     docker compose exec app chown -R www-data:www-data /var/www/html
     ```

4. Restart containers:
   ```bash
   docker compose down
   docker compose up -d
   ```

## Stopping the Application

When you're done:
```bash
docker compose down
```

To completely reset (including database):
```bash
docker compose down -v
```