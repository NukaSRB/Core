# Service Commands

- [Make a Service](#make)
- [List all Services](#list)

<a name="make"></a>
## Make

`php artisan make:service <name> --no-folders`

This will create a service for you and add it to the config.  If you do not pass the `--no-folders` option it will create 
a common service set up for you.

```
app/Services/<NAME>/Http/Controllers
app/Services/<NAME>/Http/Routes
app/Services/<NAME>/Models
```

> No matter whar you select it will create `app/Services/<name>`

<a name="list"></a>
## List

`php artisan service:list`

This will list all currently registered services.

```
> php artisan service:list
+----------+-----------------------+-----------------------+
| Name     | Namespace             | Path                  |
+----------+-----------------------+-----------------------+
| root     | App                   | app                   |
| TestCase | App\Services\TestCase | app/Services/TestCase |
+----------+-----------------------+-----------------------+
```

> All apps start with the `root` service being set up.

## Scaffold

`php artisan service:scaffold <service name> <controller name> --crud --single-action`

The scaffold command aims to get you up and running with a new page quickly.  It creates a controller and a route file with 
the name supplied.  If you don't add any options, it will create the files without any methods or routes predefined.

The `--crud` option will add the 7 common CRUD methods to your controller and the 7 routes to your route file.

The `--single-action` option will create a controller with only the `__invoke` method and a single route in the route file.
