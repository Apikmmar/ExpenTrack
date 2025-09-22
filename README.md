# ExpenTrack

A modern expense tracking application built with Laravel and Tailwind CSS. Track your income and expenses with an intuitive interface, categorization, and filtering capabilities.

## Features

### 💰 Expense Management
- Add income and expense entries with amount, category, date, and description
- Edit and delete existing entries with confirmation dialogs
- Automatic category creation and management
- Categories are automatically formatted in title case

### 📊 Dashboard Overview
- **Total Income**: View your total earnings
- **Total Expenses**: Track your spending
- **Balance**: See your remaining money (Income - Expenses)
- Color-coded summary cards with dynamic balance indicators

### 🔍 Advanced Filtering
- Filter by date range (from/to dates)
- Filter by category using dropdown selection
- Filtered totals update automatically
- Clear filters with one click

### 🎨 Modern UI/UX
- Clean, responsive design with Tailwind CSS
- Dark/Light mode toggle with persistent preferences
- Mobile-friendly interface
- Smooth animations and hover effects

### 🔐 User Authentication
- Secure user registration and login (Laravel Breeze)
- User-specific data isolation
- Profile management

## Tech Stack

- **Backend**: Laravel 12.30.1
- **Frontend**: Tailwind CSS, Alpine.js
- **Database**: MySQL
- **Authentication**: Laravel Breeze
- **PHP**: 8.2.4

## Installation

1. **Clone the repository**
   ```bash
   git clone <repository-url>
   cd ExpenTrack
   ```

2. **Install dependencies**
   ```bash
   composer install
   npm install
   ```

3. **Environment setup**
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

4. **Database configuration**
   - Update `.env` with your database credentials
   ```env
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=expentrack
   DB_USERNAME=your_username
   DB_PASSWORD=your_password
   ```

5. **Run migrations**
   ```bash
   php artisan migrate
   ```

6. **Build assets**
   ```bash
   npm run build
   ```

7. **Start the application**
   ```bash
   php artisan serve
   ```

## Database Structure

### Tables
- **users**: User authentication and profile data
- **categories**: Expense categories (user-specific)
- **expenses**: Income and expense entries with category relationships

### Relationships
- User has many Categories
- User has many Expenses
- Category has many Expenses
- Expense belongs to User and Category

## Usage

1. **Register/Login**: Create an account or sign in
2. **Add Expenses**: Use the form to add income or expense entries
3. **Categorize**: Enter category names (auto-created and formatted)
4. **Filter**: Use date range and category filters to analyze spending
5. **Manage**: Edit or delete entries as needed
6. **Track Balance**: Monitor your financial status with the balance card

## Features in Detail

### Category Management
- Categories are automatically created when adding expenses
- Duplicate categories are prevented (case-insensitive)
- All category names are stored in Title Case format
- Categories are user-specific for privacy

### Filtering System
- **Date Range**: Filter expenses between specific dates
- **Category Filter**: Select from existing categories
- **Combined Filters**: Use multiple filters simultaneously
- **Persistent URLs**: Filters maintain state in URL parameters

### Dark Mode
- Toggle between light and dark themes
- Preference saved in browser localStorage
- Consistent theming across all components

## Contributing

Contributions are welcome! Please feel free to submit a Pull Request.

## License

This project is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
