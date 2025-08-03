# KOPPEE Coffee Shop Website

A modern, responsive website for a coffee shop built with HTML, CSS, JavaScript, and PHP. Features a beautiful design inspired by coffee culture with a warm brown color scheme.

## Features

- **Responsive Design**: Fully responsive layout that works on all devices
- **Modern UI/UX**: Clean, modern design with smooth animations
- **Interactive Navigation**: Smooth scrolling navigation with mobile hamburger menu
- **About Us Page**: Dedicated page with company story and vision
- **Newsletter Subscription**: PHP-powered newsletter signup with database integration
- **Contact Information**: Complete contact details and social media links
- **Service Showcase**: Display of coffee shop services
- **Menu Display**: Dynamic menu items with pricing
- **PHP Backend**: Database integration for newsletter and contact forms

## File Structure

```
koppee-website/
├── index.html          # Homepage
├── about.html          # About Us page
├── style.css           # Main stylesheet
├── script.js           # JavaScript functionality
├── config.php          # PHP configuration and database functions
├── newsletter.php      # Newsletter subscription handler
└── README.md          # This file
```

## Technologies Used

- **HTML5**: Semantic markup
- **CSS3**: Modern styling with Flexbox and Grid
- **JavaScript**: Interactive functionality and animations
- **PHP**: Server-side functionality
- **MySQL**: Database for storing newsletter subscriptions and contact messages
- **Font Awesome**: Icons
- **Google Fonts**: Poppins font family

## Setup Instructions

### 1. Web Server Setup
- Place all files in your web server directory (e.g., `htdocs` for XAMPP, `www` for WAMP)
- Ensure PHP and MySQL are installed and running

### 2. Database Configuration
- Update the database credentials in `config.php`:
  ```php
  define('DB_HOST', 'localhost');
  define('DB_NAME', 'koppee_db');
  define('DB_USER', 'your_username');
  define('DB_PASS', 'your_password');
  ```

### 3. Database Setup
- Create a MySQL database named `koppee_db`
- The PHP script will automatically create the required tables:
  - `newsletter_subscribers`
  - `contact_messages`
  - `menu_items`
  - `activity_log`

### 4. Configuration
- Update the site URL in `config.php`:
  ```php
  define('SITE_URL', 'http://yourdomain.com/koppee');
  ```
- Update the admin email for contact form notifications:
  ```php
  define('ADMIN_EMAIL', 'your-email@domain.com');
  ```

## Color Scheme

The website uses a warm, coffee-inspired color palette:

- **Primary Brown**: `#8B4513` (Saddle Brown)
- **Secondary Brown**: `#D2B48C` (Tan)
- **Accent Color**: `#F4A460` (Sandy Brown)
- **Background**: `#F5F5DC` (Beige)
- **Text**: `#333333` (Dark Gray)

## Key Features Explained

### Navigation
- Fixed navigation bar with smooth transitions
- Responsive hamburger menu for mobile devices
- Active link highlighting based on scroll position

### About Us Page
- Three-column layout showcasing "Our Story", coffee image, and "Our Vision"
- Responsive design that stacks on mobile devices
- Beautiful coffee splash image as centerpiece

### PHP Functionality
- Newsletter subscription with email validation
- Database integration for storing subscriber information
- Contact form handling (extensible)
- Activity logging for admin purposes
- CSRF protection for forms

### Responsive Design
- Mobile-first approach
- Breakpoints at 768px and 480px
- Flexible grid layouts
- Optimized typography for all screen sizes

## Browser Support

- Chrome (latest)
- Firefox (latest)
- Safari (latest)
- Edge (latest)
- Internet Explorer 11+ (with graceful degradation)

## Performance Features

- Optimized images with proper sizing
- Efficient CSS with minimal redundancy
- JavaScript event optimization
- Lazy loading potential for future images

## Future Enhancements

- Online ordering system
- User authentication
- Admin panel for menu management
- Blog/news section
- Gallery with coffee shop photos
- Location map integration
- Reservation system

## License

This project is open source and available under the MIT License.

## Contact

For questions or support, please contact the development team.

---

**Note**: This website is designed to be easily customizable. Feel free to modify colors, content, and functionality to match your specific coffee shop's branding and requirements.
