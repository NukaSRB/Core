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
