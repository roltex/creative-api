# 📞 Contact Template System - Complete!

## ✅ What Was Created

A complete **Contact template** system that perfectly matches your frontend `/contact` page structure!

## 🎯 Contact Template Structure (Based on Frontend Analysis)

### 1. **Hero Section**
- Page title: "კონტაქტი" / "Contact"
- Subtitle: "დაგვიკავშირდით და ჩვენი გუნდი დაგეხმარებათ"

### 2. **Contact Form Section**
- Form title: "გამოგვიგზავნეთ შეტყობინება" / "Send Us a Message"
- Form fields configuration:
  - Name (required)
  - Email (required)
  - Phone (optional)
  - Subject (select dropdown with 4 options)
  - Message (required textarea)

### 3. **Contact Information Section**
- Section title: "საკონტაქტო ინფორმაცია" / "Contact Information"
- Address (ka/en with HTML support)
- Phone number
- Email address
- Office hours (ka/en with HTML support)

### 4. **Social Media Section**
- Section title: "გამოგვყევით" / "Follow Us"
- Social media links (Facebook, Instagram, LinkedIn, YouTube)

### 5. **Map Section**
- Section title: "ადგილმდებარეობა" / "Location"
- Google Maps embed URL
- Coordinates (latitude/longitude)
- Zoom level

## 📋 Database Fields Added

### New Contact Template Fields:
- `contact_form_title` (JSON ka/en)
- `contact_form_fields` (Array of form configuration)
- `contact_info_title` (JSON ka/en)
- `contact_address` (JSON ka/en)
- `contact_phone` (String)
- `contact_email` (String)
- `office_hours_title` (JSON ka/en)
- `office_hours_text` (JSON ka/en)
- `social_media_title` (JSON ka/en)
- `social_media_links` (Array of social links)
- `map_title` (JSON ka/en)
- `map_embed_url` (String)
- `map_latitude` (Decimal)
- `map_longitude` (Decimal)
- `map_zoom` (Integer)

### Contact Form Field Structure:
```json
{
  "name": "name",
  "label_ka": "სახელი და გვარი",
  "label_en": "Full Name",
  "type": "text",
  "required": true,
  "placeholder_ka": "შეიყვანეთ თქვენი სახელი",
  "placeholder_en": "Enter your name"
}
```

### Social Media Link Structure:
```json
{
  "platform": "facebook",
  "url": "https://facebook.com/creativegeorgia",
  "icon_class": "lucide-facebook"
}
```

## 🎨 Filament Form (Contact Template)

When you select **"Contact Page"** template, the form shows:

### **Basic Information** (Tabs: Georgian/English)
- Page title, subtitle, SEO fields

### **Contact Form Section** (Tabs: Georgian/English)
- Form title

### **Contact Information** (Tabs: Georgian/English)
- Contact info title, address, office hours title/text

### **Contact Details** (No tabs)
- Phone number, email address

### **Social Media Section** (Tabs: Georgian/English)
- Social media section title

### **Social Media Links** (Repeater)
- Platform, URL, Icon class

### **Map Section** (Tabs: Georgian/English)
- Map section title

### **Map Configuration** (No tabs)
- Embed URL, latitude, longitude, zoom level

## 📡 API Response Structure

### Get Contact Page:
```
GET /api/pages/contact
```

### Response:
```json
{
  "success": true,
  "data": {
    "slug": "contact",
    "template": "contact",
    "title": {"ka": "კონტაქტი", "en": "Contact"},
    "subtitle": {"ka": "დაგვიკავშირდით...", "en": "Contact us..."},
    "contact_form_title": {"ka": "გამოგვიგზავნეთ შეტყობინება", "en": "Send Us a Message"},
    "contact_form_fields": [
      {
        "name": "name",
        "label_ka": "სახელი და გვარი",
        "label_en": "Full Name",
        "type": "text",
        "required": true,
        "placeholder_ka": "შეიყვანეთ თქვენი სახელი",
        "placeholder_en": "Enter your name"
      }
    ],
    "contact_info_title": {"ka": "საკონტაქტო ინფორმაცია", "en": "Contact Information"},
    "contact_address": {"ka": "თბილისი, რუსთაველის გამზირი 42<br />საქართველო", "en": "42 Rustaveli Avenue, Tbilisi<br />Georgia"},
    "contact_phone": "+995 32 2 123 456",
    "contact_email": "info@creative-georgia.ge",
    "office_hours_title": {"ka": "სამუშაო საათები", "en": "Office Hours"},
    "office_hours_text": {"ka": "ორშაბათი - პარასკევი: 10:00 - 18:00<br />შაბათი - კვირა: დახურული", "en": "Monday - Friday: 10:00 - 18:00<br />Saturday - Sunday: Closed"},
    "social_media_title": {"ka": "გამოგვყევით", "en": "Follow Us"},
    "social_media_links": [
      {"platform": "facebook", "url": "https://facebook.com/creativegeorgia", "icon_class": "lucide-facebook"}
    ],
    "map_title": {"ka": "ადგილმდებარეობა", "en": "Location"},
    "map_embed_url": "https://maps.google.com/maps?q=42+Rustaveli+Avenue...",
    "map_latitude": 41.6938,
    "map_longitude": 44.8015,
    "map_zoom": 16
  }
}
```

## 🔗 Frontend Integration

### Replace Static Contact Content:
```vue
<script setup>
import { ref, onMounted } from 'vue'
import api from '@/api/axios'

const contactData = ref(null)

onMounted(async () => {
  const response = await api.get('/pages/contact')
  contactData.value = response.data.data
})
</script>

<template>
  <div v-if="contactData">
    <!-- Hero Section -->
    <h1>{{ contactData.title.ka }}</h1>
    <p>{{ contactData.subtitle.ka }}</p>
    
    <!-- Two Column Layout -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-12">
      <!-- Contact Form -->
      <div>
        <h2>{{ contactData.contact_form_title.ka }}</h2>
        <form>
          <div v-for="field in contactData.contact_form_fields" :key="field.name">
            <label>{{ field.label_ka }}</label>
            <input 
              v-if="field.type === 'text' || field.type === 'email' || field.type === 'tel'"
              :type="field.type"
              :placeholder="field.placeholder_ka"
              :required="field.required"
            />
            <select v-else-if="field.type === 'select'" :required="field.required">
              <option v-for="option in field.options" :key="option.value" :value="option.value">
                {{ option.label_ka }}
              </option>
            </select>
            <textarea 
              v-else-if="field.type === 'textarea'"
              :placeholder="field.placeholder_ka"
              :required="field.required"
            ></textarea>
          </div>
        </form>
      </div>
      
      <!-- Contact Information -->
      <div>
        <h2>{{ contactData.contact_info_title.ka }}</h2>
        <div class="space-y-4">
          <div>
            <h3>მისამართი</h3>
            <p v-html="contactData.contact_address.ka"></p>
          </div>
          <div>
            <h3>ტელეფონი</h3>
            <a :href="`tel:${contactData.contact_phone}`">{{ contactData.contact_phone }}</a>
          </div>
          <div>
            <h3>ელ.ფოსტა</h3>
            <a :href="`mailto:${contactData.contact_email}`">{{ contactData.contact_email }}</a>
          </div>
          <div>
            <h3>{{ contactData.office_hours_title.ka }}</h3>
            <p v-html="contactData.office_hours_text.ka"></p>
          </div>
        </div>
        
        <!-- Social Media -->
        <h2>{{ contactData.social_media_title.ka }}</h2>
        <div class="flex gap-4">
          <a v-for="social in contactData.social_media_links" 
             :key="social.platform" 
             :href="social.url" 
             target="_blank">
            {{ social.platform }}
          </a>
        </div>
      </div>
    </div>
    
    <!-- Map Section -->
    <div class="mt-12">
      <h2>{{ contactData.map_title.ka }}</h2>
      <iframe
        :src="contactData.map_embed_url"
        width="100%"
        height="500"
        style="border:0;"
        allowfullscreen
        loading="lazy"
      ></iframe>
    </div>
  </div>
</template>
```

## 📊 Current Data (Seeded)

### Contact Form (5 fields):
1. **სახელი და გვარი** / **Full Name** (text, required)
2. **ელ.ფოსტა** / **Email** (email, required)
3. **ტელეფონი** / **Phone** (tel, optional)
4. **თემა** / **Subject** (select with 4 options):
   - About Competitions
   - About Funding
   - Partnership
   - Other Question
5. **შეტყობინება** / **Message** (textarea, required)

### Contact Information:
- **Address**: თბილისი, რუსთაველის გამზირი 42 / 42 Rustaveli Avenue, Tbilisi
- **Phone**: +995 32 2 123 456
- **Email**: info@creative-georgia.ge
- **Office Hours**: Monday-Friday 10:00-18:00, Weekend closed

### Social Media Links (4 platforms):
- **Facebook**: https://facebook.com/creativegeorgia
- **Instagram**: https://instagram.com/creativegeorgia
- **LinkedIn**: https://linkedin.com/company/creative-georgia
- **YouTube**: https://youtube.com/creativegeorgia

### Map Configuration:
- **Embed URL**: Google Maps iframe
- **Coordinates**: 41.6938, 44.8015 (Rustaveli Avenue)
- **Zoom**: Level 16

## 🚀 How to Use

### 1. **View Existing Contact Page:**
- Go to: http://localhost:8000/admin/pages
- Find: "კონტაქტი" (Contact)
- Edit to see all contact sections populated

### 2. **Create New Contact Page:**
- Click: "შექმნა" (Create)
- Template: Select **"Contact Page"**
- Form shows all contact-specific sections
- Configure form fields, contact info, social media, map

### 3. **Manage Contact Information:**
- Update address, phone, email
- Modify office hours
- Add/remove social media platforms
- Update map location and zoom

## 📁 Template Features

### Dynamic Form Builder:
✅ **Configure contact form fields** dynamically  
✅ **Set field types** (text, email, tel, select, textarea)  
✅ **Manage form labels** in both languages  
✅ **Set required/optional** fields  
✅ **Custom placeholders** for each field  

### Contact Information Management:
✅ **Address** with HTML support (line breaks)  
✅ **Phone/Email** with direct links  
✅ **Office hours** with formatting  
✅ **Full translation** support  

### Social Media Integration:
✅ **Platform selection** (Facebook, Instagram, etc.)  
✅ **URL management** for each platform  
✅ **Icon class** configuration  
✅ **Add/remove** platforms dynamically  

### Map Integration:
✅ **Google Maps embed** URL  
✅ **Coordinates** for precise location  
✅ **Zoom level** control  
✅ **Section title** management  

## 🔧 Template Comparison

| Mission Template | Reports Template | Acts Template | Contact Template |
|------------------|------------------|---------------|------------------|
| Mission section | Annual reports | Legal acts | Contact form |
| Goals list | Strategic plans | Regulations | Contact info |
| Values cards | Financial reports | Additional info | Social media |
| Statistics | Key achievements | Contact CTA | Map section |

## 📊 Complete Template System

### Available Templates (4 total):
1. ✅ **Mission & Goals** - Organization mission, goals, values, stats
2. ✅ **Reports & Strategy** - Annual reports, strategic plans, financial reports
3. ✅ **Acts & Regulations** - Legal acts, regulations, procedures
4. ✅ **Contact Page** ⭐ NEW - Contact form, info, social media, map
5. Default Page - Basic content
6. About Page - Ready for extension

## 🌐 Current Pages (4 Pages)

1. **მისია და მიზნები** (Mission & Goals) - about/mission
2. **ანგარიშგებები და სტრატეგია** (Reports & Strategy) - about/reports
3. **აქტები და დებულებები** (Acts & Regulations) - resources/acts
4. **კონტაქტი** (Contact) - contact ⭐ NEW

## 🚀 Testing

### Test in Admin:
1. **Go to**: http://localhost:8000/admin/pages
2. **You'll see 4 pages** with different template badges:
   - 🔵 mission
   - 🟢 reports
   - 🔴 acts
   - 🟡 contact ⭐ NEW
3. **Edit Contact page** to see all contact sections
4. **Create new page** with "Contact Page" template

### Test API:
```bash
# Get contact page
curl http://localhost:8000/api/pages/contact

# Should return complete page structure with all sections
```

## 📝 Form Structure Summary

### Contact Form Fields (5 fields):
```json
[
  {"name": "name", "type": "text", "required": true},
  {"name": "email", "type": "email", "required": true},
  {"name": "phone", "type": "tel", "required": false},
  {"name": "subject", "type": "select", "options": [...]},
  {"name": "message", "type": "textarea", "required": true}
]
```

### Subject Options (4 options):
- კონკურსების შესახებ / About Competitions
- დაფინანსების შესახებ / About Funding  
- პარტნიორობა / Partnership
- სხვა კითხვა / Other Question

## 📞 Contact Information Structure

```json
{
  "contact_info_title": {"ka": "საკონტაქტო ინფორმაცია", "en": "Contact Information"},
  "contact_address": {"ka": "თბილისი, რუსთაველის გამზირი 42<br />საქართველო", "en": "42 Rustaveli Avenue, Tbilisi<br />Georgia"},
  "contact_phone": "+995 32 2 123 456",
  "contact_email": "info@creative-georgia.ge",
  "office_hours_title": {"ka": "სამუშაო საათები", "en": "Office Hours"},
  "office_hours_text": {"ka": "ორშაბათი - პარასკევი: 10:00 - 18:00<br />შაბათი - კვირა: დახურული", "en": "Monday - Friday: 10:00 - 18:00<br />Saturday - Sunday: Closed"}
}
```

## 📍 Map Configuration

```json
{
  "map_title": {"ka": "ადგილმდებარეობა", "en": "Location"},
  "map_embed_url": "https://maps.google.com/maps?q=42+Rustaveli+Avenue,+Tbilisi,+Georgia&t=&z=16&ie=UTF8&iwloc=&output=embed",
  "map_latitude": 41.6938,
  "map_longitude": 44.8015,
  "map_zoom": 16
}
```

## ✨ Features

### Dynamic Contact Management:
✅ **Form builder** - Add/remove/edit form fields  
✅ **Contact info** - Update address, phone, email  
✅ **Office hours** - Manage business hours  
✅ **Social media** - Add/remove platforms  
✅ **Map integration** - Google Maps embed  
✅ **Full translation** support (Georgian/English)  
✅ **HTML support** in address/hours (line breaks)  

### Professional Contact Page:
✅ **Two-column layout** structure  
✅ **Interactive form** configuration  
✅ **Complete contact information** display  
✅ **Social media integration**  
✅ **Map location** with coordinates  

## 📝 Files Created/Modified

1. ✅ `database/migrations/2025_12_06_221812_add_contact_template_fields_to_pages_table.php`
2. ✅ `app/Models/Page.php` - Added contact fields
3. ✅ `app/Filament/Resources/Pages/PageResource.php` - Added contact form sections
4. ✅ `database/seeders/ContactPageSeeder.php` - Contact page content
5. ✅ Database: Contact page with complete structure

## 🔧 Managing Content

### Update Contact Information:
1. Edit Contact page
2. Modify phone, email, address
3. Update office hours
4. Save changes

### Add Social Media Platform:
1. Find "Social Media Links" section
2. Click "Add Social Link"
3. Select platform, add URL
4. Set icon class
5. Save

### Update Map Location:
1. Get new Google Maps embed URL
2. Update coordinates if needed
3. Adjust zoom level
4. Save changes

## 🎯 Benefits

✅ **Exact match** to frontend structure  
✅ **Complete contact management** system  
✅ **Dynamic form configuration**  
✅ **Social media integration**  
✅ **Map integration** with Google Maps  
✅ **Translation support** throughout  
✅ **Professional organization** of contact content  
✅ **API-ready** for frontend consumption  

## 📊 Complete Template System Summary

You now have **4 powerful page templates**:

1. **Mission & Goals** - Organization details with mission, goals, values, stats
2. **Reports & Strategy** - Document management with reports, plans, achievements  
3. **Acts & Regulations** - Legal document management with acts, regulations, info
4. **Contact Page** ⭐ NEW - Complete contact system with form, info, social, map

## 🎉 Result

You now have a **complete page template system** that covers all your major page types!

✅ **4 Dynamic Templates** (Mission, Reports, Acts, Contact)  
✅ **Structured Content** matching frontend exactly  
✅ **File Management** for documents  
✅ **Form Builder** for contact pages  
✅ **Social Media Integration**  
✅ **Map Integration**  
✅ **Translation Support** Georgian/English  
✅ **API Integration** ready for frontend  
✅ **Professional CMS** for all page types  

---

**Status**: ✅ Complete  
**Templates**: 4 active (Mission, Reports, Acts, Contact)  
**Pages**: 4 seeded and ready  
**API**: All endpoints active  

**🎊 Your complete page template system is ready!** Try editing the Contact page in admin! 📞✨

Go to http://localhost:8000/admin/pages and see all 4 template pages with different badges!
