## Description

This is a code challenge for Prodooh company

Code challenge description (Spanish version): public/code_challange_description_spanish.pdf


## Installation

To install and set up the project, follow the steps below:

1. Clone the repository:

```shell
git clone git@github.com:ftrucco01/prodooh_challenge.git
```

2. Navigate to the project directory:

```shell
cd prodooh_challenge/laravel
```

3. Install the dependencies using Composer:

```shell
composer install
```

4. Copy the `.env.example` file and rename it to `.env`:

```shell
cp .env.example .env
```

5. Generate an application key:

```shell
php artisan key:generate
```


6. Run the database migrations:

```shell
php artisan migrate
```

7. (Optional) Seed the database with dummy data:

```shell
php artisan db:seed
```

8. Start the development server:

```shell
php artisan serve
```


9. Access the application in your browser at `http://localhost:8000`.

Make sure you have PHP 8.1 or later installed on your system before proceeding with the installation.

Additionally, the following packages will be installed as dependencies:

- `barryvdh/laravel-snappy` for image generation.
- `guzzlehttp/guzzle` for making HTTP requests.
- `h4cc/wkhtmltoimage-amd64` for generating images.
- `h4cc/wkhtmltopdf-amd64` for PDF generation.
- `laravel/framework` as the Laravel framework.
- `laravel/sanctum` for API authentication.
- `laravel/tinker` for interactive shell.

Please refer to the official Laravel documentation for more information on Laravel installation and usage.