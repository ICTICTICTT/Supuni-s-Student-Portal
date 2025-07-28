# StudentPortal Web Application

A comprehensive web application for student registration, login, and contact management built with HTML, CSS, JavaScript, and PHP.

## Features

### Frontend Features
- **Responsive Design**: Mobile-first approach with CSS Grid and Flexbox
- **Dark/Light Theme**: Toggle between themes with persistent storage
- **Form Validation**: Client-side validation with real-time feedback
- **Password Security**: Show/hide toggle, strength indicator, and match validation
- **Interactive Elements**: Star rating system, modal confirmations, smooth animations
- **Professional UI**: Clean design with dark blue color scheme and white background

### Backend Features
- **User Registration**: Secure user account creation with validation
- **User Authentication**: Login system with session management
- **Contact Form**: Message submission with rating system
- **Database Integration**: MySQL database with proper schema design
- **Security**: Password hashing, SQL injection prevention, input sanitization

## File Structure

```
studentportal/
├── index.html          # Home page
├── register.html       # Registration form
├── login.html         # Login form
├── profile.html       # User profile page
├── contact.html       # Contact form
├── styles.css         # Main stylesheet
├── script.js          # JavaScript functionality
├── register.php       # Registration backend
├── login.php          # Login backend
├── contact.php        # Contact form backend
├── database.sql       # Database schema
└── README.md          # This file
```

## Setup Instructions

### 1. Database Setup
1. Create a MySQL database named `studentportal`
2. Import the `database.sql` file to create the required tables
3. Update database credentials in PHP files if needed

### 2. Web Server Setup
1. Place all files in your web server directory (e.g., `htdocs` for XAMPP)
2. Ensure PHP and MySQL are running
3. Access the application through your web server (e.g., `http://localhost/studentportal/`)

### 3. Configuration
Update database connection settings in PHP files:
```php
$host = 'localhost';
$dbname = 'studentportal';
$username = 'root';
$password = '';
```

## Pages Overview

### Home Page (index.html)
- Welcome section with call-to-action buttons
- Features showcase with icons and descriptions
- Responsive navigation with theme toggle
- Professional hero section and footer

### Registration Page (register.html)
- Comprehensive registration form with validation
- Password strength indicator
- Real-time password matching
- Email format validation
- Required field validation

### Login Page (login.html)
- Simple login form with email and password
- Remember me functionality
- Password visibility toggle
- Error handling and feedback

### Profile Page (profile.html)
- User information display
- Academic information cards
- Recent activities timeline
- Edit profile functionality

### Contact Page (contact.html)
- Contact form with subject selection
- Star rating system (1-5 stars)
- Contact information display
- Message submission with validation

## JavaScript Features

### Form Validation
- Real-time validation feedback
- Email format checking
- Password strength assessment
- Required field validation
- Custom error messages

### Interactive Elements
- Password show/hide toggle
- Star rating system
- Modal dialogs
- Theme switching
- Smooth scrolling
- Mobile navigation

### Data Management
- Local storage for client-side data (fallback)
- Session management
- Form data persistence
- User authentication state

## CSS Features

### Responsive Design
- Mobile-first approach
- CSS Grid and Flexbox layouts
- Breakpoints for tablet and desktop
- Scalable typography

### Theme System
- CSS custom properties (variables)
- Dark/light theme support
- Smooth transitions
- Consistent color scheme

### Professional Styling
- Dark blue (#1e40af) primary color
- White background with subtle shadows
- Hover effects and micro-interactions
- Form styling with focus states
- Card-based layouts

## PHP Backend

### Security Features
- Password hashing with `password_hash()`
- SQL injection prevention with prepared statements
- Input sanitization and validation
- Session management
- CSRF protection ready

### Database Operations
- User registration and authentication
- Contact form submissions
- Session tracking
- Remember me functionality

### Error Handling
- Comprehensive validation
- User-friendly error messages
- Database error handling
- Graceful fallbacks

## Browser Compatibility

- Modern browsers (Chrome, Firefox, Safari, Edge)
- Mobile browsers (iOS Safari, Chrome Mobile)
- Progressive enhancement approach
- Fallbacks for older browsers

## Development Notes

### Client-Side Fallback
The application includes JavaScript-based local storage functionality as a fallback when PHP/MySQL is not available, making it suitable for both development and production environments.

### Extensibility
The codebase is structured for easy extension:
- Modular CSS with custom properties
- Reusable JavaScript functions
- Clean PHP class structure ready
- Database schema designed for growth

### Performance
- Optimized CSS with minimal redundancy
- Efficient JavaScript with event delegation
- Proper database indexing
- Compressed assets ready

## License

This project is created for educational purposes as part of a web development assignment.