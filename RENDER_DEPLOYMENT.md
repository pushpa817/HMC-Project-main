# Render.com Deployment Guide

This guide walks you through deploying the HMC Project to Render.com for a live demo.

## Prerequisites

- GitHub account with HMC-Project-main repository (already done ✓)
- Render.com account (free signup required)

## Step-by-Step Deployment

### Step 1: Sign Up on Render

1. Go to [Render.com](https://render.com)
2. Click **"Sign up with GitHub"**
3. Authorize Render to access your GitHub account
4. Complete the signup process

### Step 2: Create a New Web Service

1. From Render dashboard, click **"New +"**
2. Select **"Web Service"**
3. Search and select **"HMC-Project-main"** repository
4. Click **"Connect"**

### Step 3: Configure the Service

Fill in the following details:

| Field | Value |
|-------|-------|
| **Name** | hmc-demo |
| **Environment** | Docker |
| **Branch** | main |
| **Build Command** | (leave default) |
| **Start Command** | (leave default) |
| **Plan** | Free |

### Step 4: Add Environment Variables

Click **"Add Environment Variable"** and add:

```
DB_HOST=localhost
DB_USER=hmc_user
DB_PASSWORD=your_strong_password_here
DB_NAME=HMC
```

### Step 5: Create Database

1. Click **"Create Database"**
2. Name: `hmc-db`
3. Database: `HMC`
4. Username: `hmc_user`
5. Password: (same as above)
6. Plan: **Free tier**

### Step 6: Deploy

1. Click **"Deploy"**
2. Wait for build to complete (3-5 minutes)
3. Once deployed, you'll get a URL like: `https://hmc-demo.onrender.com`

---

## Manual Deployment (Alternative)

### Using Render Dashboard

1. **Go to Render Dashboard**
2. **Click "New"** → **"Web Service"**
3. **Connect GitHub repository**
4. **Configure settings:**
   - Runtime: Docker
   - Build: `docker build -t hmc-project .`
   - Start: Auto-detected from Dockerfile

### Database Setup

After deployment:

1. Go to Service Dashboard
2. Click **"Databases"**
3. Create MySQL database
4. Copy connection credentials
5. Update `database.php` with credentials

---

## Accessing Your Live Demo

### URLs After Deployment

| Service | URL |
|---------|-----|
| **HMC Application** | `https://hmc-demo.onrender.com` |
| **Database Panel** | In Render dashboard |

### Default Credentials

Use credentials from README.md:

| Role | ID | Password |
|------|----|----|
| **Chairman** | CH999999 | ravi9999 |
| **Mess Manager** | MM999918 | virat1818 |
| **Staff Manager** | SM999991 | dravid9999 |
| **Warden** | WD999991 | (check database) |
| **Student** | ST220001 | (check database) |

---

## Database Configuration for Render

Update `database.php` to read Render environment variables:

```php
<?php
$servername = getenv('DB_HOST') ?: 'localhost';
$username = getenv('DB_USER') ?: 'root';
$password = getenv('DB_PASSWORD') ?: '';
$dbname = getenv('DB_NAME') ?: 'HMC';

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Set charset
$conn->set_charset("utf8mb4");
?>
```

---

## Troubleshooting

### Deploy Failed - Build Error

```bash
Check build logs in Render dashboard:
1. Services → hmc-demo
2. Click "Logs"
3. Review error messages
4. Fix issues locally
5. Push to GitHub (auto-redeploys)
```

### Database Connection Error

```bash
# Verify environment variables
1. Go to Service Dashboard
2. Click "Environment" tab
3. Check all DB_* variables are set
4. Restart service

# Or use Render PostgreSQL (easier):
DB_DRIVER=pgsql
DB_HOST=<render-provided-host>
DB_USER=hmc_user
DB_PASSWORD=<your-password>
DB_NAME=hmc
```

### Service Won't Start

1. Check build logs for errors
2. Verify Dockerfile is valid
3. Ensure `docker-compose.yml` is not being used (Render uses Dockerfile)
4. Check PHP extensions are included

### Slow Performance

- Upgrade to paid Render plan for faster resources
- Add caching headers in PHP
- Optimize database queries
- Enable gzip compression

---

## Continuous Deployment

### Auto-Deploy on GitHub Push

Render automatically redeploys when you push to main branch:

```bash
# Make changes locally
git add .
git commit -m "Update feature"
git push origin main

# Render will automatically:
# 1. Detect changes
# 2. Rebuild image
# 3. Redeploy service
```

To disable auto-deploy:
1. Service Settings → Repo Connection
2. Disable "Auto-deploy"

---

## Security Considerations

### Before Going Public

- [ ] Change all default passwords
- [ ] Enable HTTPS (Render does this automatically)
- [ ] Update database credentials
- [ ] Set strong environment variables
- [ ] Add rate limiting to login page
- [ ] Enable logging and monitoring
- [ ] Review security group settings

### Environment Variables

**Never commit sensitive data!** Use Render's environment variables:

```bash
# Good (use environment variables)
$password = getenv('DB_PASSWORD');

# Bad (hardcoded)
$password = 'my_secret_password';
```

---

## Performance Optimization

### Caching

Add to top of PHP files:

```php
header("Cache-Control: public, max-age=3600");
```

### Database Optimization

```sql
-- Add indexes for frequently queried columns
CREATE INDEX idx_student_id ON StudentPersonalDetails(student_id);
CREATE INDEX idx_complaint_status ON Complaints(status);
```

### Image Optimization

- Compress images in `images/` folder
- Use WebP format where possible
- Lazy load images

---

## Monitoring & Logs

### View Logs

1. Service Dashboard → **Logs**
2. Filter by:
   - Build logs
   - Runtime logs
   - Error logs

### Set Up Alerts

1. Service Settings → **Notifications**
2. Add email for:
   - Deploy failures
   - Service down
   - Memory/CPU limits

---

## Scaling for Production

For production use:

1. **Upgrade Plan**
   - Free → Starter ($7/month)
   - Starter → Standard ($25/month+)

2. **Use PostgreSQL** instead of MySQL
   - Better performance
   - Easier Render integration

3. **Add Redis Cache**
   - Speed up sessions
   - Reduce database load

4. **Enable Auto-scaling**
   - Handle traffic spikes
   - Available on paid plans

5. **Use CDN**
   - Faster static asset delivery
   - Cloudflare integration

---

## Custom Domain

1. In Render Dashboard → Service Settings
2. Click **"Custom Domain"**
3. Add your domain (e.g., `hmc-demo.yourdomain.com`)
4. Update DNS records at your domain registrar
5. SSL certificate auto-generated by Render

---

## Rollback to Previous Deploy

1. Service Dashboard → **Deploys**
2. Find previous successful deploy
3. Click **"Redeploy"**
4. Confirm rollback

---

## Cost Estimate

| Service | Free Tier | Cost |
|---------|-----------|------|
| Web Service | Yes | $0 (spins down after 15 min inactivity) |
| MySQL Database | Limited | $0 (1GB limit) |
| Total | Yes | **$0/month** |

**Note:** Free tier services spin down after 15 minutes of inactivity (cold start on next request).

For production: **~$15-30/month** for reliable hosting.

---

## Next Steps

1. ✅ Deploy on Render
2. Test with live credentials
3. Share live URL in GitHub README
4. Gather user feedback
5. Monitor logs and performance
6. Plan production deployment if needed

---

## Support

- Render Help: https://render.com/docs
- GitHub Issues: https://github.com/pushpa817/HMC-Project-main/issues
- Render Support: support@render.com

---

**Happy Deploying! 🚀**
