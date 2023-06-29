# 05: Versioning and defining routes

At this point, a folder was created at the path `app\Http\Controllers\Api\V1`. This folder will contain all the **REST Controllers** present in version 1 of the API. A possible second version of the API would be located at `app\Http\Controllers\Api\V2`.

In the controllers, only the `index` methods were modified to return a list of all their respective data in the database.

`CustomerController.php`
```php
public function index()
{
    return Customer::all();
}
```

---

Then, the routes were defined in the `routes\api.php` file.

`Route::group()` defines a group of routes within a context. In this case, it's the version 1 of the API. So the prefix `v1` will be automatically added to all the routes. And `App\Http\Controllers\Api\V1` will be the base namespace for all the controllers in this group.

```php
Route::group(['prefix' => 'v1', 'namespace' => 'App\Http\Controllers\Api\V1'], function(){
    Route::apiResource('costumers', CustomerController::class);
    Route::apiResource('invoices', InvoiceController::class);
});
```

`Route::apiResource()` generates **RESTful** routes for a specific resource, in this case, `Customer` and `Invoice`, which will be mapped to the routes `/api/v1/customers` and `/api/v1/invoices`, respectively.

When a request is made to these routes, their respective controllers will be called with the `index()` method.

---

At this point, the API can be executed and tested through **HTTP requests** to the defined routes.

```
php artisan serve
```

The command runs a server on the port configured in the `.env` file, which is typically `8000`. And now a request can be made to the following route:

```
http://localhost:8000/api/v1/costumers
```

The result will be a `.json` file containing the registered `Customers` in the database.

```json
[
  {
    "id": 1,
    "name": "Schuppe and Sons",
    "type": "B",
    "email": "alycia.borer@zulauf.com",
    "address": "5492 Nick Court Apt. 880",
    "city": "Bartellborough",
    "state": "Utah",
    "postal_code": "97882",
    "created_at": "2023-06-28T22:42:39.000000Z",
    "updated_at": "2023-06-28T22:42:39.000000Z"
  },
  {
    "id": 2,
    "name": "Frami-Mayert",
    "type": "B",
...
```

---

- :arrow_left: [Previous](04-seeding-the-database.md)
- :arrow_right: [Next](/README.md)