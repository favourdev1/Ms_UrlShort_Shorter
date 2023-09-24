# URL Shortener Microservice

![Build Status](https://img.shields.io/badge/build-passing-brightgreen)
![License](https://img.shields.io/badge/license-MIT-blue)

URL Shortener is a microservice that makes long web addresses short and easy to share. This microservice is part of a larger system for handling URL shortening and authentication. It follows a microservice architecture, allowing you to create, update, and delete short URLs.


## Note 
This project repo responsible for shortening long web addresses, managing short URLs, and handling redirections to the original web addresses. This microservice works in conjunction with the authentication microservice [MS_Urlshort_Auth](https:github.com/ms_urlshort_auth)  to ensure secure URL management.
## Features

-   Create short URLs from long web addresses.
-   Manage your short URLs with authentication (handled by [MS_Urlshort_Auth](https:github.com/ms_urlshort_auth) ).
-   Retrieve and update short URL details.
-   Redirect to the original URL when accessing the short URL.

## Table of Contents

-   [Getting Started](#getting-started)
-   [API Endpoints](#api-endpoints)
-   [Authentication](#authentication)
-   [License](#license)

## Getting Started

To get started with the URL Shortener microservice, follow these steps:

1. Clone this repository:

    ```bash
    git clone https://github.com/favourdev1/Ms_UrlShort_shortener.git
    cd Ms_UrlShort_shortener
    ```

2. Install the required dependencies:

    ```bash
    composer install
    ```

3. Set up your database and configure the database connection in your .env file.

4. Run the migrations and seed the database:

    ```bash
    php artisan migrate --seed
    ```

5. Start the Laravel development server:
    ```bash
    php artisan serve 
    ```
    or
      ```bash
    php artisan serve --port=8001
    ```
6. You can now access the URL Shortener microservice API at http://localhost:8000 or localhost:8001 depending on the port number you provided.

## API Endpoints

The URL Shortener microservice provides the following API endpoints:

- GET /api/shorten - Retrieve a list of your short URLs.

- POST /api/shorten - Create a new short URL.

- GET /api/shorten/{id} - Retrieve details of a specific short URL.

- PUT /api/shorten/{id} - Update a short URL.

- DELETE /api/shorten/{id} - Delete a short URL.

- GET /{shortUrl} - Redirect to the original URL.


## AUTHENTICATION
Authentication for this microservice is handled by the [MS_Urlshort_Auth](https:github.com/ms_urlshort_auth) repository. Ensure you have the authentication service set up and running to secure your short URLs.