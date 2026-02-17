# Docker Deployment Guide

This guide helps you run the HMC Project using Docker and Docker Compose.

## Prerequisites

- **Docker** (Download from https://docs.docker.com/get-docker/)
- **Docker Compose** (Included with Docker Desktop)
- At least 2GB free disk space
- Ports 80, 3306, and 8081 available on your machine

## Quick Start

### Option A: Automated Setup (Recommended for Linux/Mac)

```bash
# Make script executable
chmod +x docker-setup.sh

# Run the setup script
./docker-setup.sh
```

### Option B: Manual Setup

```bash
# Build and start all services
docker-compose up -d

# This will start:
# - PHP/Apache web server (port 80)
# - MySQL database (port 3306)
# - phpMyAdmin (port 8081)
```

## Accessing the Application

| Service | URL | Purpose |
|---------|-----|---------|
| **HMC App** | http://localhost | Main application |
| **phpMyAdmin** | http://localhost:8081 | Database management |

## Database Credentials (Docker)

```
Host: db (or localhost from host machine)
User: hmc_user
Password: hmc_password
Database: HMC
Root Password: root_password
```

## Updating PHP Configuration

The Docker container automatically loads the database credentials. However, if you want to customize, update `database.php`:

```php
<?php
$servername = "db";           // Use 'db' inside containers
$username = "hmc_user";       // Match docker-compose.yml
$password = "hmc_password";   // Match docker-compose.yml
$dbname = "HMC";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
```

## Common Docker Commands

### View Logs
```bash
# All services
docker-compose logs -f

# Specific service
docker-compose logs -f web
docker-compose logs -f db
```

### Access MySQL CLI
```bash
docker-compose exec db mysql -u hmc_user -p HMC
# Password: hmc_password
```

### Stop Services
```bash
docker-compose down
```

### Stop and Remove Volumes (Clean Reset)
```bash
docker-compose down -v
```

### Rebuild Images
```bash
docker-compose build --no-cache
docker-compose up -d
```

### View Running Containers
```bash
docker-compose ps
```

## Deploying to Cloud Platforms

### AWS ECS
```bash
# Build and push to ECR
aws ecr get-login-password --region us-east-1 | docker login --username AWS --password-stdin YOUR_ACCOUNT.dkr.ecr.us-east-1.amazonaws.com

docker build -t hmc-project .
docker tag hmc-project:latest YOUR_ACCOUNT.dkr.ecr.us-east-1.amazonaws.com/hmc-project:latest
docker push YOUR_ACCOUNT.dkr.ecr.us-east-1.amazonaws.com/hmc-project:latest
```

### Google Cloud Run
```bash
# Build and deploy
gcloud run deploy hmc-project --source . --region us-central1 --allow-unauthenticated
```

### Azure Container Instances
```bash
# Build and push to ACR
az acr build --registry myregistry --image hmc-project:latest .

# Deploy
az container create --resource-group mygroup --name hmc-project \
  --image myregistry.azurecr.io/hmc-project:latest \
  --ports 80 --environment-variables DB_HOST=db DB_USER=hmc_user
```

### DigitalOcean App Platform
```bash
# Push to Docker Hub first
docker tag hmc-project:latest yourusername/hmc-project:latest
docker push yourusername/hmc-project:latest

# Then deploy via DigitalOcean console or CLI
doctl apps create --spec app.yaml
```

## Docker Compose File Structure

```yaml
Services:
  - web: PHP 8.1 + Apache container
  - db: MySQL 8.0 database
  - phpmyadmin: Database management UI
  
Volumes:
  - db_data: Persistent database storage
  
Networks:
  - hmc-network: Internal communication between services
```

## Troubleshooting

### Port Already in Use
```bash
# Find what's using port 80
lsof -i :80

# Use different port in docker-compose.yml
# Change "80:80" to "8080:80"
```

### Database Connection Error
```bash
# Ensure database is running
docker-compose logs db

# Restart database
docker-compose restart db
```

### Permission Denied
```bash
# Grant execute permission to setup script
chmod +x docker-setup.sh

# If Docker requires sudo
sudo docker-compose up -d
```

### Container Won't Start
```bash
# Check logs
docker-compose logs

# Rebuild from scratch
docker-compose down -v
docker-compose build --no-cache
docker-compose up -d
```

## Production Deployment Checklist

- [ ] Use environment variables for sensitive data
- [ ] Enable HTTPS/SSL certificates
- [ ] Set up proper backup strategy for database
- [ ] Configure logging and monitoring
- [ ] Implement health checks
- [ ] Set resource limits for containers
- [ ] Use secrets management (Docker Secrets or external vault)
- [ ] Regular security updates for base images

## Performance Optimization

### Increase Docker Resources
Edit Docker Desktop preferences:
- **CPU**: Allocate more cores (at least 2)
- **Memory**: Allocate 4GB or more
- **Disk**: Ensure 20GB available space

### Database Optimization
```bash
# Connect to MySQL and run optimization
docker-compose exec db mysql -u hmc_user -p HMC
> OPTIMIZE TABLE StudentPersonalDetails;
> OPTIMIZE TABLE Complaints;
> ANALYZE TABLE StudentHallDetails;
```

## Security Best Practices

1. **Change Default Passwords**
   - Update `docker-compose.yml` with strong passwords
   - Change application passwords after first login

2. **Use Environment Variables**
   ```bash
   # Create .env file
   DB_PASSWORD=your_secure_password
   
   # Reference in docker-compose.yml
   environment:
     MYSQL_PASSWORD: ${DB_PASSWORD}
   ```

3. **Network Security**
   - Don't expose MySQL directly to internet
   - Use private networks for services
   - Enable firewall rules

4. **Image Security**
   ```bash
   # Scan images for vulnerabilities
   docker scan hmc-project:latest
   
   # Keep base images updated
   docker pull php:8.1-apache
   docker pull mysql:8.0
   ```

## Next Steps

1. Access the application at http://localhost
2. Login with credentials from README.md
3. Change default passwords
4. Configure email for password reset
5. Deploy to your chosen cloud platform

## Support

For issues:
- Check Docker logs: `docker-compose logs -f`
- Review [Docker documentation](https://docs.docker.com)
- Check [Docker Compose documentation](https://docs.docker.com/compose/)
- Open an issue on GitHub: https://github.com/pushpa817/HMC-Project-main/issues

---

**Happy Deploying! 🚀**
