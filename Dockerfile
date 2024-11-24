FROM php:8.1-apache
# Install MySQL and required tools
RUN apt-get update && apt-get install -y \
    mysql-server \
    vim \
    curl && \
    rm -rf /var/lib/apt/lists/*

# Set up MySQL (this is a simplified setup, you may need to adjust for your needs)
RUN service mysql start

# Expose MySQL port
EXPOSE 3306

CMD ["mysqld"]

# Install system dependencies
RUN apt-get update && apt-get install -y \
    libzip-dev \
    zip \
    unzip

# Install PHP extensions
RUN docker-php-ext-install pdo pdo_mysql zip

# Enable Apache mod_rewrite
RUN a2enmod rewrite

# Set working directory
WORKDIR /var/www/html

# Copy application files
COPY . /var/www/html/

COPY my-custom.conf /etc/apache2/conf-available/my-custom.conf
RUN a2enconf my-custom.conf


# Set permissions
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html