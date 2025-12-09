# 📺 Press System - Complete!

## ✅ What Was Created

A complete **Press system** separate from News, designed for managing press releases and media coverage!

## 🎯 Press Resource Structure

### **Press Fields (Your Requirements):**

1. **Title*** (Georgian/English) - პრეს-რელიზის სათაური
2. **Content*** (Georgian/English) - Rich text editor
3. **Media Name*** (მედიის დასახელება) - e.g., "First Channel", "Imedi TV"
4. **Media Link** (ბმული) - External link to original coverage
5. **Media Logo** (მედიის ლოგო) - Upload media outlet logo
6. **Category*** - Type of coverage (ინტერვიუ, სტატია, etc.)
7. **Is Featured** - Toggle for prominence
8. **Featured Image** - Main image
9. **Auto-Slug** - Georgian title → Latin letters
10. **Tags** - For organization
11. **Publication Date**
12. **View Count** - Auto-tracked

## 📋 Database Structure

### **Presses Table:**
```sql
CREATE TABLE presses (
    id BIGINT PRIMARY KEY,
    slug VARCHAR UNIQUE,
    title JSON,                    -- {ka: '', en: ''}
    content JSON,                  -- {ka: '', en: ''}
    excerpt JSON,                  -- {ka: '', en: ''}
    media_name VARCHAR,            -- მედიის დასახელება
    media_link VARCHAR,            -- ბმული
    media_logo VARCHAR,            -- მედიის ლოგო
    published_at DATE,
    category VARCHAR,
    author_id BIGINT,
    tags JSON,
    view_count INTEGER DEFAULT 0,
    is_featured BOOLEAN DEFAULT FALSE,
    image VARCHAR,                 -- Featured image
    timestamps
);
```

## 🎨 Filament Form

### **Form Structure:**
- **Slug** - Auto-generates from Georgian title
- **Georgian Tab**: Title, Content, Excerpt (rich text)
- **English Tab**: Title, Content, Excerpt (rich text)
- **Media Name** - Required (e.g., "Rustavi 2", "Imedi TV")
- **Media Link** - Optional external URL
- **Media Logo** - File upload for outlet logo
- **Category** - Required (e.g., ინტერვიუ, სტატია, რეპორტაჟი)
- **Featured** - Toggle
- **Publication Date** - Date picker
- **Featured Image** - Image upload
- **Tags** - Tag input

## 📊 Table Display

| Media Logo | Title | Media Name | Category | Published | Featured | Views | Link |
|------------|-------|------------|----------|-----------|----------|-------|------|
| 📺 | შემოქმედებითი... | 🔵 First Channel | 🟡 ანგარიშგება | Dec 20 | ⭐ | 2450 | ↗️ |
| 📺 | დირექტორის... | 🔵 1TV | 🟡 ინტერვიუ | Dec 10 | ⭐ | 1890 | ↗️ |

### Table Features:
✅ **Media logo thumbnails**  
✅ **Media name badges**  
✅ **Category badges**  
✅ **External link indicators**  
✅ **Featured indicators**  
✅ **View count tracking**  

## 📡 API Endpoints

### **Press API:**
```
GET /api/press                    # List all press releases
GET /api/press/{slug}             # Single press release
GET /api/press/media/outlets      # List of media outlets
GET /api/press/categories         # List of categories
```

### **Query Parameters:**
```
?media=First Channel             # Filter by media outlet
?category=ინტერვიუ              # Filter by category  
?featured=true                   # Only featured press
?search=keyword                  # Search in title/content
?per_page=12                     # Pagination
```

### **API Response:**
```json
{
  "success": true,
  "data": {
    "id": 1,
    "slug": "shemoqmedebiti-saqartvelo-2024-wliuri-angarishi",
    "title": {
      "ka": "შემოქმედებითი საქართველო წარმოადგენს 2024 წლის წლიურ ანგარიშს",
      "en": "Creative Georgia Presents 2024 Annual Report"
    },
    "content": {"ka": "<h2>წლიური ანგარიშის ძირითადი მონაცემები</h2>...", "en": "<h2>Annual Report Key Data</h2>..."},
    "media_name": "First Channel",
    "media_link": "https://1tv.ge/news/creative-georgia-annual-report-2024",
    "media_logo": "/storage/press/logos/first-channel.png",
    "category": "ანგარიშგება",
    "is_featured": true,
    "image": "/storage/press/featured-image.jpg",
    "tags": ["annual-report", "achievements", "funding"],
    "published_at": "2024-12-20",
    "view_count": 2450
  }
}
```

## 📊 Current Content (5 Press Releases)

### **Featured Press (2):**
1. **წლიური ანგარიშის პრეზენტაცია** - First Channel (ანგარიშგება)
2. **დირექტორის ინტერვიუ** - 1TV (ინტერვიუ)

### **Regular Press (3):**
3. **ახალი გრანტების პროგრამა** - Imedi TV (გამოცხადება)
4. **კულტურული მემკვიდრეობა** - Radio Tavisupleba (ინტერვიუ)
5. **ახალგაზრდების პროგრამები** - Rezonansi (სტატია)

### **Media Outlets:**
- First Channel (1TV)
- 1TV
- Imedi TV  
- Radio Tavisupleba
- Rezonansi (Newspaper)

### **Categories:**
- ანგარიშგება (Reports)
- ინტერვიუ (Interviews)
- გამოცხადება (Announcements)
- სტატია (Articles)
- რეპორტაჟი (Features)

## 📁 File Storage

### **Storage Directories:**
```
storage/app/public/press/
├── logos/          # Media outlet logos
└── [press-images]  # Press release images
```

### **Upload Features:**
- **Media Logos**: 2MB max, optimized for web
- **Featured Images**: 5MB max, press-specific directory
- **File Types**: JPG, PNG, GIF, WebP

## 🚀 How to Use

### **Create Press Release:**

1. **Go to**: http://localhost:8000/admin (look for "პრესა")
2. **Click**: "შექმნა" (Create)
3. **Fill Form**:
   - **Georgian Title**: "ახალი პრეს-რელიზი 2024"
   - **Slug**: Auto-generates as "axali-pres-relizi-2024"
   - **Rich Content**: Use editor for formatting
   - **Media Name**: "Rustavi 2"
   - **Media Link**: External URL to coverage
   - **Upload Media Logo**: TV channel logo
   - **Category**: "ინტერვიუ" or "სტატია"
   - **Featured Image**: Main image
4. **Save**!

### **Manage Media Coverage:**
- Track all TV interviews
- Manage newspaper articles about organization
- Upload media outlet logos
- Link to external coverage
- Categorize by type of coverage

## 🔗 Frontend Integration

### **Replace Static Press Content:**
```vue
<script setup>
import { ref, onMounted } from 'vue'
import api from '@/api/axios'

const pressData = ref([])
const loading = ref(false)

onMounted(async () => {
  loading.value = true
  const response = await api.get('/press')
  pressData.value = response.data.data
  loading.value = false
})

const getFeaturedPress = async () => {
  const response = await api.get('/press?featured=true')
  return response.data.data
}
</script>

<template>
  <div v-if="!loading">
    <div v-for="press in pressData" :key="press.id" class="press-item">
      <!-- Media Logo -->
      <img v-if="press.media_logo" :src="press.media_logo" :alt="press.media_name" />
      
      <!-- Press Content -->
      <h3>{{ press.title.ka }}</h3>
      <p>{{ press.excerpt.ka }}</p>
      
      <!-- Media Info -->
      <div class="media-info">
        <span class="media-name">{{ press.media_name }}</span>
        <span class="category">{{ press.category }}</span>
        <a v-if="press.media_link" :href="press.media_link" target="_blank">
          Read Original
        </a>
      </div>
      
      <!-- Tags -->
      <div class="tags">
        <span v-for="tag in press.tags" :key="tag" class="tag">{{ tag }}</span>
      </div>
    </div>
  </div>
</template>
```

## ✨ Features Comparison

| News Articles | Press Releases |
|---------------|----------------|
| Internal content | External coverage |
| Categories: grants, events | Categories: interviews, articles |
| No media info | Media name + logo + link |
| Gallery images | Featured image only |
| For website visitors | For media relations |

## 🎯 Use Cases

### **Press System For:**
- ✅ **TV Interviews** - Track TV appearances
- ✅ **Newspaper Articles** - External press coverage  
- ✅ **Radio Mentions** - Radio interview tracking
- ✅ **Press Releases** - Official announcements
- ✅ **Media Relations** - Organize all media interactions

### **News System For:**
- ✅ **Website News** - Internal content creation
- ✅ **Announcements** - Organization updates
- ✅ **Event Coverage** - Internal reporting
- ✅ **Gallery Content** - Photo-rich articles

## 📊 Navigation Update

Your admin now has **both**:
- **სიახლეები** (News Articles) - Internal content
- **პრესა** (Press Releases) - External media coverage

## 🔍 Auto-Slug Testing

### **Test Press Auto-Slugs:**
1. Create new press release
2. Title: "ახალი მედია ინტერვიუ 2024"
3. Expected slug: "axali-media-interviu-2024"
4. Should work perfectly with Press model!

## 📝 Files Created

1. ✅ `app/Models/Press.php` - Press model with auto-slug
2. ✅ `database/migrations/2025_12_06_231844_create_presses_table.php` - Database table
3. ✅ `app/Filament/Resources/Presses/PressResource.php` - Admin interface
4. ✅ `app/Http/Controllers/Api/PressController.php` - API controller
5. ✅ `routes/api.php` - Press API endpoints
6. ✅ `database/seeders/PressSeeder.php` - Sample content
7. ✅ Storage directories: `press/`, `press/logos/`

## 🎉 Result

You now have **2 separate systems**:

### **📰 News Articles:**
- Internal content creation
- Gallery images
- Homepage features
- Website visitors

### **📺 Press Releases:**
- External media coverage  
- Media outlet tracking
- Logo management
- Media relations

## 🚀 Try It Now!

**1. Go to Admin:**
```
http://localhost:8000/admin
```

**2. You'll see both:**
- **სიახლეები** (News Articles) - Internal news
- **პრესა** (Press Releases) - Media coverage ⭐ NEW

**3. Create Press Release:**
- Click "პრესა" → "შექმნა"
- See all your requested fields!
- Test auto-slug generation

### **Expected Georgian → Latin Slugs:**
```
"შემოქმედებითი საქართველოს ანგარიში" → "shemoqmedebiti-saqartvelos-angarishi"
"ახალი პრეს-რელიზი" → "axali-pres-relizi" 
"მედია ინტერვიუ 2024" → "media-interviu-2024"
```

---

**Status**: ✅ Complete  
**Press Releases**: 5 seeded  
**Auto-Slug**: Georgian → Latin  
**Media Management**: Logos + links  
**API**: 4 endpoints active  

**🎊 Your Press system with Georgian auto-slugs is ready!** Try creating a press release! 📺✨
