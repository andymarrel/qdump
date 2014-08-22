## Qdump - quora like open-source question services

## Installation guide

1. git clone
2. Configure app/config/app.php, app/config/db.php
3. Install cartalyst/sentry:
3.1 php composer self-update
3.2 php composer install
3.3 Add new provider to app/config/app.php -> 'Cartalyst\Sentry\SentryServiceProvider'
3.4 Add new alias to app/config/app.php -> 'Sentry' => 'Cartalyst\Sentry\Facades\Laravel\Sentry',
3.5 Run migrations php artisan migrate --package=cartalyst/sentry
3.6 Publish configuration files php artisan config:publish cartalyst/sentry
3.7 Change users model to 'User' in app/config/packages/cartalyst/sentry/config.php
4. Configure Sociauth
4.1 Sociauth under workbench directory
4.1.1 cd workbench/andymarrell/sociauth; composer install
4.1.2 Configure Sociauth social providers -> workbench/andymarrell/sociauth/src/config/sociauth.php
4.1.3 Add new provider to app/config/app.php -> 'Andymarrell\Sociauth\SociauthServiceProvider'
4.1.4 Add new alias to app/config/app.php -> 'Sociauth' => 'Andymarrell\Sociauth\Facades\Sociauth'
4.2 Sociauth under vendor directory (coming soon ...)
4.3 php artisan migrate:make
4.4 Seeding social providers php artisan db:seed --class=SocialProvidersTableSeeder

### Contributing To Qdump

**All issues and pull requests should be filed on the [andymarrell/qdump](http://github.com/andymarrell/qdump) repository.**

### License

The Qdump is open-sourced software and licensed under the [MIT license](http://opensource.org/licenses/MIT)
