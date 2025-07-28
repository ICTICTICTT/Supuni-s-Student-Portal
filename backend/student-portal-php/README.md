# Student Portal PHP Project

## Overview
The Student Portal PHP project is a web application designed to facilitate student registration, login, profile management, and contact form submissions. It provides a user-friendly interface for students to create accounts, manage their profiles, and communicate with the administration.

## Features
- **User Registration**: Students can create an account by filling out a registration form. The data is securely processed and stored.
- **User Login**: Students can log in to their accounts using their credentials. The application manages sessions and cookies for user authentication.
- **Profile Management**: After logging in, students can view and update their profile information.
- **Contact Form**: A contact form allows users to submit inquiries or feedback, which is saved for administrative review.
- **Session Management**: The application ensures that only logged-in users can access certain pages, enhancing security.

## Project Structure
```
student-portal-php
├── public
│   ├── index.php
│   ├── register.php
│   ├── login.php
│   ├── profile.php
│   ├── contact.php
│   ├── logout.php
│   ├── assets
│   │   ├── styles.css
│   │   └── script.js
│   └── uploads
├── src
│   ├── config.php
│   ├── db.php
│   ├── auth.php
│   ├── user.php
│   ├── contact.php
│   └── helpers.php
├── templates
│   ├── header.php
│   ├── footer.php
│   └── modal.php
├── data
│   └── contacts.json
├── .env
├── README.md
```

## Setup Instructions
1. **Clone the Repository**: Download or clone the project repository to your local machine.
2. **Install Dependencies**: Ensure you have a web server (like Apache or Nginx) and PHP installed. You may also need to set up a database (MySQL or SQLite).
3. **Configure Environment Variables**: Update the `.env` file with your database credentials and other sensitive information.
4. **Database Setup**: If using a database, create the necessary tables as defined in the `src/db.php` file.
5. **Run the Application**: Access the application through your web server by navigating to the `public/index.php` file in your browser.

## Additional Notes
- Ensure that file permissions are set correctly for the `uploads` directory to allow file uploads.
- Regularly back up the `data/contacts.json` file to prevent data loss.
- Consider implementing additional security measures, such as input validation and sanitization, to protect against common web vulnerabilities.

## License
This project is open-source and available for modification and distribution under the MIT License.