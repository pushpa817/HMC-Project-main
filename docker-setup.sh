#!/bin/bash

# Colors for output
RED='\033[0;31m'
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
NC='\033[0m' # No Color

echo -e "${YELLOW}================================================${NC}"
echo -e "${YELLOW}HMC Project - Docker Setup${NC}"
echo -e "${YELLOW}================================================${NC}"
echo ""

# Check if Docker is installed
if ! command -v docker &> /dev/null; then
    echo -e "${RED}❌ Docker is not installed!${NC}"
    echo "Please install Docker from: https://docs.docker.com/get-docker/"
    exit 1
fi

# Check if Docker Compose is installed
if ! command -v docker-compose &> /dev/null; then
    echo -e "${RED}❌ Docker Compose is not installed!${NC}"
    echo "Please install Docker Compose from: https://docs.docker.com/compose/install/"
    exit 1
fi

echo -e "${GREEN}✓ Docker is installed${NC}"
echo -e "${GREEN}✓ Docker Compose is installed${NC}"
echo ""

# Build images
echo -e "${YELLOW}Building Docker images...${NC}"
docker-compose build

if [ $? -eq 0 ]; then
    echo -e "${GREEN}✓ Build successful${NC}"
else
    echo -e "${RED}❌ Build failed${NC}"
    exit 1
fi

echo ""

# Start services
echo -e "${YELLOW}Starting HMC services...${NC}"
docker-compose up -d

if [ $? -eq 0 ]; then
    echo -e "${GREEN}✓ Services started${NC}"
else
    echo -e "${RED}❌ Failed to start services${NC}"
    exit 1
fi

echo ""
echo -e "${GREEN}================================================${NC}"
echo -e "${GREEN}HMC Project is now running!${NC}"
echo -e "${GREEN}================================================${NC}"
echo ""
echo -e "${YELLOW}Access the application:${NC}"
echo -e "  🌐 Main App: ${GREEN}http://localhost${NC}"
echo -e "  📊 phpMyAdmin: ${GREEN}http://localhost:8081${NC}"
echo ""
echo -e "${YELLOW}Database Credentials:${NC}"
echo -e "  Host: ${GREEN}localhost${NC} (or 'db' from inside containers)"
echo -e "  User: ${GREEN}hmc_user${NC}"
echo -e "  Password: ${GREEN}hmc_password${NC}"
echo -e "  Database: ${GREEN}HMC${NC}"
echo ""
echo -e "${YELLOW}Useful Docker Commands:${NC}"
echo -e "  View logs: ${GREEN}docker-compose logs -f${NC}"
echo -e "  Stop services: ${GREEN}docker-compose down${NC}"
echo -e "  Rebuild: ${GREEN}docker-compose build --no-cache${NC}"
echo -e "  Access MySQL: ${GREEN}docker-compose exec db mysql -u hmc_user -p${NC}"
echo ""
echo -e "${YELLOW}Next Steps:${NC}"
echo -e "  1. Update database.php with Docker credentials (see instructions)"
echo -e "  2. Login with default credentials from README.md"
echo -e "  3. Change passwords after first login"
echo ""
