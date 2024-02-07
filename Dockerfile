# Start from a base image of Ubuntu 18.04
FROM ubuntu:18.04

# Set environment variable to noninteractive
ENV DEBIAN_FRONTEND=noninteractive

# Update the package lists
RUN apt-get update

# Install Apache2
RUN apt-get install -y apache2

# Enable mod_rewrite
RUN a2enmod rewrite

# Update the Apache configuration
RUN sed -i 's/AllowOverride None/AllowOverride All/' /etc/apache2/apache2.conf

# Add ondrej/php PPA
RUN apt-get install -y software-properties-common
RUN add-apt-repository -y ppa:ondrej/php

# Update the package lists
RUN apt-get update

# Install PHP 7.2
RUN apt-get install -y php7.2

# Install PHP extensions
RUN apt-get install -y php7.2-cli php7.2-zip php7.2-mbstring php7.2-xml php7.2-curl php7.2-mysql

# Install Composer
RUN apt-get install -y curl
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Install Git, Zip, and Unzip
RUN apt-get install -y git zip unzip

# Expose port 80
EXPOSE 80

WORKDIR /var/www/html/app

# Start Apache in the foreground and run composer update
CMD /usr/sbin/apache2ctl -D FOREGROUND
#CMD composer update && /usr/sbin/apache2ctl -D FOREGROUND

