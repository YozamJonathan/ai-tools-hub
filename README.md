# AI Tools Hub 🤖

A community-driven AI tools discovery and curation platform built with Laravel 12. Discover, save, rate, and learn about hundreds of AI tools in one place.

![Laravel](https://img.shields.io/badge/Laravel-12.0-red?style=flat-square&logo=laravel)
![PHP](https://img.shields.io/badge/PHP-8.2+-blue?style=flat-square&logo=php)
![Tailwind CSS](https://img.shields.io/badge/Tailwind-3.1-38B2AC?style=flat-square&logo=tailwind-css)
![License](https://img.shields.io/badge/License-MIT-green?style=flat-square)

## 🌟 Features

### For Users
- **🔍 Tool Discovery** - Browse, search, and filter AI tools by categories
- **⭐ Community Reviews** - Read and write reviews, rate tools with star ratings
- **👍 Upvote System** - Upvote your favorite tools to help others discover them
- **💾 Collections** - Create custom collections to save and organize your favorite tools
- **🔗 Shareable Lists** - Share your collections with others using public share links
- **💬 Ask Yozee** - Send messages and get support directly within the platform
- **📱 Responsive Design** - Works seamlessly on desktop, tablet, and mobile

### For Premium Users
- **∞ Unlimited Saves** - Save unlimited tools to your collections
- **∞ Multiple Collections** - Create unlimited custom collections
- **⚡ Priority Support** - Get priority replies to your messages
- **📚 Pro Library** - Access premium tutorials and AI engineering resources

### Admin Features
- **🛠️ Tool Management** - Full CRUD operations for tools with approval workflow
- **✅ Moderation Dashboard** - Approve/reject reviews and tool suggestions
- **💬 Message Management** - Reply to user inquiries and support requests
- **📊 Admin Dashboard** - Overview of platform activity and statistics
- **🎯 Featured Tools** - Mark tools as featured or sponsored

## 🛠️ Tech Stack

### Backend
- **Framework**: Laravel 12
- **Language**: PHP 8.2+
- **Database**: MySQL
- **Authentication**: Laravel Breeze (Session-based)
- **ORM**: Eloquent

### Frontend
- **Build Tool**: Vite 7.0
- **CSS**: Tailwind CSS 3.1 + Tailwind Forms
- **JS Framework**: Alpine.js 3.4
- **HTTP Client**: Axios 1.11
- **Templating**: Blade Templates

### Tools & Services
- **PostCSS** - CSS processing
- **Autoprefixer** - Browser compatibility
- **Laravel Tinker** - REPL for debugging
- **PHPUnit** - Testing framework

## 📋 Requirements

- PHP 8.2 or higher
- MySQL 5.7 or higher
- Composer 2.0+
- Node.js 16+ (for frontend assets)
- npm or yarn

## 🚀 Installation

### 1. Clone the Repository
```bash
git clone https://github.com/yourusername/ai-tools-hub.git
cd ai-tools-hub
```

### 2. Install Dependencies
```bash
# Install PHP dependencies
composer install

# Install JavaScript dependencies
npm install
```

### 3. Environment Setup
```bash
# Copy environment file
cp .env.example .env

# Generate application key
php artisan key:generate
```

### 4. Configure Database
Edit `.env` file and set your database credentials:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=ai_tools_hub
DB_USERNAME=root
DB_PASSWORD=
```

### 5. Run Migrations
```bash
php artisan migrate
php artisan db:seed
```

### 6. Build Assets
```bash
# Development
npm run dev

# Production
npm run build
```

### 7. Start Development Server
```bash
php artisan serve
```

Visit `http://localhost:8000` in your browser.

## 📁 Project Structure

```
ai-tools-hub/
├── app/
│   ├── Http/
│   │   ├── Controllers/          # Request handlers
│   │   ├── Middleware/           # HTTP middleware
│   │   └── Requests/             # Form validation classes
│   ├── Models/                   # Eloquent models
│   │   ├── User.php
│   │   ├── Tool.php
│   │   ├── Category.php
│   │   ├── Collection.php
│   │   ├── Review.php
│   │   ├── Rating.php
│   │   ├── Upvote.php
│   │   ├── Message.php
│   │   ├── Suggestion.php
│   │   └── Subscription.php
│   └── Providers/                # Service providers
├── database/
│   ├── migrations/               # Database schemas
│   ├── factories/                # Model factories for testing
│   └── seeders/                  # Database seeders
├── resources/
│   ├── views/                    # Blade templates
│   │   ├── layouts/              # Layout templates
│   │   ├── admin/                # Admin panel views
│   │   ├── auth/                 # Authentication views
│   │   ├── components/           # Blade components
│   │   └── partials/             # Reusable partials
│   ├── css/                      # Stylesheets
│   ├── js/                       # JavaScript files
│   └── images/                   # Images and assets
├── routes/
│   ├── web.php                   # Web routes
│   ├── auth.php                  # Authentication routes (Laravel Breeze)
│   └── console.php               # Console commands
├── config/                       # Configuration files
├── storage/                      # File storage & logs
├── public/                       # Web root
├── tests/                        # Test files
├── .env.example                  # Example environment file
├── composer.json                 # PHP dependencies
├── package.json                  # JavaScript dependencies
├── vite.config.js                # Vite configuration
├── tailwind.config.js            # Tailwind configuration
└── README.md                     # Project documentation
```

## 📊 Database Schema

### Core Tables

| Table | Purpose |
|-------|---------|
| **users** | User accounts with role-based access (admin/user) |
| **categories** | Tool categories for organization |
| **tools** | AI tools database with approval workflow |
| **collections** | User-created collections/favorites |
| **collection_tool** | Many-to-many relationship for tools in collections |
| **ratings** | Star ratings (1-5) for tools |
| **reviews** | User reviews with moderation |
| **upvotes** | Upvote tracking for tools |
| **messages** | Support messages from users ("Ask Yozee") |
| **suggestions** | Community tool suggestions |
| **subscriptions** | Premium subscription records (M-Pesa) |
| **category_follows** | User category follows |
| **tool_notes** | User-specific notes on tools |

## 🔐 User Roles & Permissions

### Admin
- Full access to admin dashboard
- CRUD operations on tools
- Review moderation (approve/reject)
- Message management and replies
- Suggestion approval workflow

### Regular User
- Browse and search tools
- Submit reviews (pending approval)
- Rate tools with stars
- Create and manage collections
- Upvote tools
- Suggest new tools
- Send support messages

### Premium User
- All regular user features
- Unlimited collections (vs. max 2 for free users)
- Unlimited tool saves (vs. max 20 per collection)
- Priority message support
- Access to pro library content

## 🔄 Workflow Examples

### Adding a New Tool
1. User suggests tool via **Suggest** page
2. Admin reviews suggestion in **Admin > Suggestions**
3. Admin can approve or reject the suggestion
4. If approved, tool appears in the directory

### Community Review Process
1. User writes review on tool detail page
2. Review status set to "pending"
3. Admin reviews in **Admin > Reviews**
4. Admin approves or flags the review
5. Approved reviews appear on tool page

### Support Messages
1. User clicks "Ask Yozee" on tool page
2. Message sent with optional tool context
3. Admin replies in **Admin > Messages**
4. User sees reply in their messages inbox

## 🌍 Localization

Currently configured for:
- **Language**: English (en)
- **Timezone**: UTC
- **Currency**: TZS (Tanzanian Shilling) for premium subscriptions

## 💳 Payment Integration

Platform supports M-Pesa payment method for premium subscriptions:
- Premium tier: 5,000 TZS/month
- Subscription tracking with expiration dates
- Active/expired/cancelled status

## 🐛 Troubleshooting

### Database Connection Issues
```bash
# Check database connection
php artisan migrate --dry-run

# Re-run migrations
php artisan migrate:refresh --seed
```

### Asset Build Issues
```bash
# Clear build cache
rm -rf node_modules
npm install
npm run build
```

### Cache Issues
```bash
# Clear all caches
php artisan cache:clear
php artisan config:clear
php artisan view:clear
php artisan route:clear
```

## 🤝 Contributing

Contributions are welcome! Please follow these steps:

1. Fork the repository
2. Create your feature branch (`git checkout -b feature/AmazingFeature`)
3. Commit your changes (`git commit -m 'Add some AmazingFeature'`)
4. Push to the branch (`git push origin feature/AmazingFeature`)
5. Open a Pull Request

## 📝 License

This project is open source and available under the [MIT License](LICENSE).

## 👤 Author

**Yozee**

- GitHub: [@yourusername](https://github.com/yourusername)
- Email: your.email@example.com

## 🙏 Support

If you find this project helpful, please consider:
- ⭐ Starring the repository
- 🐛 Reporting bugs and issues
- 💬 Providing feedback and suggestions
- 🤝 Contributing improvements

## 📚 Additional Resources

- [Laravel Documentation](https://laravel.com/docs)
- [Tailwind CSS Documentation](https://tailwindcss.com/docs)
- [Alpine.js Documentation](https://alpinejs.dev/)
- [Vite Documentation](https://vitejs.dev/)

## 🗺️ Roadmap

- [ ] Email notifications for user messages
- [ ] Tool categorization improvements
- [ ] Advanced search filters
- [ ] User profiles and activity tracking
- [ ] Social sharing features
- [ ] API for third-party integrations
- [ ] Multi-language support
- [ ] Dark mode improvements
- [ ] Mobile app (React Native)
- [ ] Analytics dashboard

---

**Built with ❤️ for the AI community**
