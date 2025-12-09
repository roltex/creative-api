# 🚀 Creative Georgia CMS - Quick Reference

## Essential Commands

### Start Backend Server
```bash
cd creative-georgia-backend
php artisan serve
```
Access at: **http://localhost:8000**

### Start Frontend
```bash
cd creative-georgia
npm run dev
```
Access at: **http://localhost:5173**

### Admin Panel
**URL:** http://localhost:8000/admin  
**Email:** roland.esakia@gmail.com  
**Password:** (your chosen password)

## Common Tasks

### Seed Database
```bash
php artisan db:seed
```

### Create Admin User
```bash
php artisan make:filament-user
```

### Clear Cache
```bash
php artisan cache:clear
php artisan config:clear
php artisan view:clear
```

### Run Migrations
```bash
php artisan migrate
```

### Reset Database
```bash
php artisan migrate:fresh --seed
```

## API Testing

### Test Competitions Endpoint
```bash
curl http://localhost:8000/api/competitions
```

### Test News Endpoint
```bash
curl http://localhost:8000/api/news
```

### Test Settings
```bash
curl http://localhost:8000/api/settings
```

## File Locations

### Database
```
creative-georgia-backend/database/database.sqlite
```

### Uploaded Files
```
creative-georgia-backend/storage/app/public/
```

### Logs
```
creative-georgia-backend/storage/logs/laravel.log
```

## Key URLs

| Service | URL |
|---------|-----|
| Backend API | http://localhost:8000/api |
| Admin Panel | http://localhost:8000/admin |
| Frontend | http://localhost:5173 |

## Admin Panel Navigation

### Content Management
- Dashboard → Competitions
- Dashboard → News Articles
- Dashboard → Events
- Dashboard → Success Stories
- Dashboard → Sliders
- Dashboard → FAQs
- Dashboard → Pages

### Structure
- Dashboard → Menus
- Dashboard → Partners
- Dashboard → Resources

### Users & Access
- Dashboard → Users
- Dashboard → Roles
- Dashboard → Applications

### Configuration
- Dashboard → Settings
- Dashboard → Social Links

## File Structure

```
creative-georgia-backend/
├── app/
│   ├── Models/              # Data models
│   ├── Http/Controllers/    # API logic
│   └── Filament/           # Admin panel
├── database/
│   ├── migrations/         # Database schema
│   └── seeders/           # Sample data
├── routes/
│   ├── api.php            # API routes
│   └── web.php            # Web routes
└── README-CMS.md          # Full docs
```

## Troubleshooting

### Backend won't start
```bash
php artisan key:generate
php artisan config:clear
php artisan serve
```

### Frontend shows errors
```bash
# Check backend is running
# Verify .env.local has correct API URL
# Check browser console for details
```

### Cannot login to admin
```bash
# Reset admin password
php artisan make:filament-user
```

### Database issues
```bash
# Fresh start
php artisan migrate:fresh --seed
```

## Support

📖 **Full Documentation:** README-CMS.md  
📋 **Setup Guide:** SETUP-GUIDE.md  
🎉 **Summary:** FINAL-SUMMARY.md  

---

**Quick Start:** Start backend → Login to admin → Start frontend → Done! ✅

