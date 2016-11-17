# Configuration

## Service Providers
Add the following service providers to ``configs/app.php``.

```
    'JumpGate\Core\Providers\ViewServiceProvider',
```
     
## Configs/Migrations/Seeds
Once that is done, you can publish the configs and migrations.

`php artisan vendor:publish --provider="JumpGate\Core\Providers\ViewServiceProvider"`

This will create a `jumpgate/view-routing.php` in your config folder.
