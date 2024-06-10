# HOPE GIVERS - Blood Donation System

HOPE GIVERS is a comprehensive platform designed to connect blood donors and recipients. It features user login, blood inventory management, and donor-patient matching to encourage participation in blood donation.

## Table of Contents
- Features
- Installation
- Usage
- File Structure
- Technologies Used

## Features

- User Authentication: Secure login and registration for users.
- Blood Inventory Management: Easy management and tracking of blood inventory.
- Donor-Patient Matching: Efficient matching of donors and recipients.
- Appointment Scheduling: Users can set appointments or donation dates based on their role (patient or donor).
- Profile Management: Users can view and manage their profiles, including personal information and contact details.

## Installation

1. **Clone the repository:**
   ```bash
   git clone https://github.com/your-username/hope-givers.git
   cd hope-givers
   ```

2. **Install Dependencies:**
   ```bash
   composer install
   ```

3. **Database Setup:**
   - Import the SQL file provided (`database.sql`) to set up the necessary tables.
   - Update the `db.php` file with your database credentials.

4. **Run the Server:**
   You can use built-in PHP server for local development:
   ```bash
   php -S localhost:8000
   ```

## Usage

1. Home Page: The landing page provides an overview of the platform with options to log in or register, manage blood inventory, and find matches.

2. User Login: Users can log in using their credentials. Patients can set appointments, while donors can set donation dates.

3. Profile Page: Users can view their profile details. Depending on their role, they will see options to set appointments or donation dates.

hope-givers/
│
├── includes/           # Includes headers and footers
│   ├── header.php
│   └── footer.php
│
├── images.png
│
├── scripts.js
│
├── styles.css      # Main stylesheet
│
├── db.php              # Database connection file
│
├── index.php           # Home page
│
├── inventory_management.php # Blood inventory management page
│
├── login.php           # Login page
│
├── match.php           # Donor-patient matching page
│
├── process_appointments.php # Processing appointments page
│
├── process_donation_dates.php # Processing donation dates page
│
├── profile.php         # User profile page
│
├── register.php        # Registration page
│
└── README.md           # This file


## Technologies Used
- Frontend:
  - HTML5
  - CSS3
  - JavaScript

- Backend:
  - PHP
  - MySQL


