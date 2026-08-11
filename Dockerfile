FROM php:8.4-cli

# Install system dependencies
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    sqlite3 \
    libsqlite3-dev \
    nodejs \
    npm

# Clear cache
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# Install PHP extensions
RUN docker-php-ext-install pdo pdo_sqlite mbstring exbc bcmath

# Get latest Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /var/www

# Copy application files
COPY . .

# Environment setup
ENV PORT=10000
ENV DB_CONNECTION=sqlite

# Install Composer dependencies
RUN composer install --no-dev --optimize-autoloader

# Install NPM dependencies and build Vite frontend assets
RUN npm install
RUN npm run build

# Setup SQLite database file
RUN touch database/database.sqlite
RUN chmod -R 777 database/ storage/

# Run database migrations and seeding
RUN php artisan migrate:force --seed

EXPOSE 10000

# Start Laravel server on port 10000
CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=10000"]
