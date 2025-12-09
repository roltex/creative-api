# Creative Georgia CMS Backend

## Overview
Complete Laravel backend with Filament admin panel for managing the Creative Georgia website content.

## Installation & Setup

### Requirements
- PHP 8.2+
- Composer
- SQLite (included)

### Installation Steps

1. **Install Dependencies**
```bash
composer install
```

2. **Environment Configuration**
The `.env` file is already configured with:
- SQLite database
- CORS settings for frontend
- Sanctum configuration

3. **Run Migrations**
```bash
php artisan migrate
```

4. **Start Development Server**
```bash
php artisan serve
```

The backend will be available at: `http://localhost:8000`

## Admin Panel Access

**URL:** `http://localhost:8000/admin`

**Default Admin Credentials:**
- Email: `roland.esakia@gmail.com`
- Password: `password` (set during installation)

## Database Structure

### Content Tables
- **competitions** - All competitions (current/archive)
- **news_articles** - News and press articles  
- **events** - Events calendar
- **success_stories** - Success story showcases
- **sliders** - Homepage hero slider content
- **faqs** - FAQ items with categories
- **pages** - Dynamic pages
- **resources** - Documents and files

### Configuration Tables
- **settings** - Site-wide settings (key-value pairs)
- **social_links** - Social media links
- **menus** / **menu_items** - Navigation menus
- **partners** - Partners/sponsors

### User Tables
- **users** - Frontend and admin users
- **applications** - User application submissions
- **roles** / **permissions** - Access control (Spatie Permission)

## API Endpoints

### Public Endpoints (No Authentication)

```
GET /api/settings                    - Get all settings
GET /api/sliders/home                - Get homepage slider
GET /api/competitions                - List competitions
GET /api/competitions/{slug}         - Get competition details  
GET /api/news                        - List news articles
GET /api/news/{slug}                 - Get news article
GET /api/press                       - List press articles
GET /api/events                      - List events
GET /api/events/{slug}               - Get event details
GET /api/success-stories             - List success stories
GET /api/success-stories/{slug}      - Get success story
GET /api/faqs                        - List FAQs
GET /api/pages/{slug}                - Get page content
GET /api/menus/{location}            - Get menu (header/footer)
GET /api/social-links                - Get social media links
GET /api/partners                    - List partners
```

### Authenticated Endpoints

```
POST /api/auth/register              - User registration
POST /api/auth/login                 - User login
POST /api/auth/logout                - User logout
GET /api/user                        - Get current user
POST /api/applications               - Submit application
GET /api/user/applications           - Get user's applications
GET /api/user/applications/{id}      - Get application details
```

## Content Management Features

### Multi-language Support
All content models support Georgian (ka) and English (en) translations using Spatie Translatable:
- Competitions
- News/Press articles
- Events
- Success Stories
- Sliders
- FAQs
- Pages
- Menus

### File Uploads
The system supports file uploads for:
- Images (competitions, news, events, sliders)
- Galleries (news articles, success stories)
- Documents (resources, application attachments)

Files are stored in: `storage/app/public/`

### User Roles & Permissions

**Available Roles:**
- **Super Admin** - Full access to everything
- **Admin** - Content management access
- **Editor** - Edit content only (no delete)
- **Manager** - View applications and reports

## Filament Resources

All content types have full CRUD interfaces in the admin panel:

1. **CompetitionResource** - Manage competitions
2. **NewsArticleResource** - Manage news/press
3. **EventResource** - Manage events
4. **SuccessStoryResource** - Manage success stories
5. **SliderResource** - Manage homepage slider
6. **FaqResource** - Manage FAQs
7. **PageResource** - Manage dynamic pages
8. **ApplicationResource** - View/manage applications
9. **MenuResource** - Manage navigation menus
10. **PartnerResource** - Manage partners
11. **ResourceResource** - Manage documents/files
12. **SocialLinkResource** - Manage social media links
13. **Settings Page** - Global site settings

## Frontend Integration

### Update Frontend API Configuration

Update `creative-georgia/src/api/axios.ts`:

```typescript
import axios from 'axios'

const api = axios.create({
  baseURL: 'http://localhost:8000/api',
  headers: {
    'Content-Type': 'application/json',
    'Accept': 'application/json',
  },
  withCredentials: true
})

export default api
```

### Example Store Update

Update Vue stores to fetch from Laravel API. Example for competitions store:

```typescript
// creative-georgia/src/stores/competitions.ts
import { defineStore } from 'pinia'
import { ref } from 'vue'
import api from '../api/axios'

export const useCompetitionsStore = defineStore('competitions', () => {
  const competitions = ref([])
  const loading = ref(false)
  
  async function fetchCompetitions() {
    loading.value = true
    try {
      const response = await api.get('/competitions')
      competitions.value = response.data.data
    } catch (error) {
      console.error('Error fetching competitions:', error)
    } finally {
      loading.value = false
    }
  }
  
  return { competitions, loading, fetchCompetitions }
})
```

## Development Workflow

### Adding New Content

1. Log in to admin panel at `/admin`
2. Navigate to desired resource (e.g., Competitions)
3. Click "Create" button
4. Fill in content in both Georgian and English
5. Upload images if needed
6. Set status and publish

### Managing Menus

1. Go to Menus in admin panel
2. Select menu location (header/footer/mobile)
3. Add/edit menu items
4. Drag to reorder
5. Save changes

### Settings Configuration

1. Navigate to Settings page
2. Configure by tab:
   - **General**: Site name, logo, colors
   - **Contact**: Email, phone, address  
   - **Social**: All social media links
   - **SEO**: Meta tags, analytics
   - **API**: API configuration

## Seeding Sample Data

To populate the database with sample data from the frontend:

```bash
php artisan db:seed
```

This will import:
- 18 Competitions (12 current, 6 archived)
- 14 News Articles
- Homepage slider content
- FAQ items
- Default settings

## API Response Format

All API responses follow this structure:

```json
{
  "success": true,
  "data": {
    // Response data here
  },
  "message": "Success message",
  "meta": {
    "current_page": 1,
    "total": 50,
    "per_page": 12
  }
}
```

## Error Handling

API errors return:

```json
{
  "success": false,
  "message": "Error message",
  "errors": {
    "field": ["Validation error"]
  }
}
```

## Security Features

- CORS configured for frontend domain
- Sanctum authentication for API
- CSRF protection
- Input validation
- SQL injection protection
- XSS protection
- Role-based access control

## Performance

- Database indexing on slug fields
- Eager loading relationships
- Response caching (optional)
- Image optimization (via Intervention Image)

## Backup & Maintenance

### Database Backup
```bash
cp database/database.sqlite database/backups/database_backup_$(date +%Y%m%d).sqlite
```

### Clear Cache
```bash
php artisan cache:clear
php artisan config:clear
php artisan view:clear
```

## Support

For issues or questions, contact the development team.

## License

Proprietary - Creative Georgia

---

**Version:** 1.0.0  
**Last Updated:** December 2025

