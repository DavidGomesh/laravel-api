# Laravel API

## Objective

The objective of this project is to study the creation of APIs using the **PHP** language, more specifically with the **Laravel** 9 framework.

## Study Material

For the study of this tool, the video from the **Envato Tuts+** channel was used, which can be found at this YouTube link.

https://youtu.be/YGqCZjdgJJk

## Step-by-Step

The following step-by-step process was used for creating the API.

### Summary
- [01: Creating the Project](#01-creating-the-project)
- [02: Designing the Database](#02-designing-the-database)
- [03: Creating models factories](#03-creating-models-factories)
- [04: Seeding the Database](#04-seeding-the-database)
- [05: Versioning and defining routes](#05-versioning-and-defining-routes)

### 01: Creating the Project

To run **PHP**, I used **XAMPP** version 3.3.0, which includes **PHP** version 8 and **MySQL** version 8. I also used **Composer** version 2.5.8 to download the Laravel framework using the command:

```bash
compose global require laravel/installer
```

Then the project named **"laravel-api"** was created using the following command:

```
laravel new laravel-api
```

Then, a folder named after the project was created in the directory `C:\xampp\htdocs\laravel-api`.

### 02: Designing the Database

Firstly, a database was created on the MySQL server.

```sql
CREATE DATABASE IF NOT EXISTS `laravel_api` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
```

Then, using the `php artisan` command, the `Customer` and `Invoice` models were created.

```
php artisan make:model Customer --all
php artisan make:model Invoice --all
```

The `--all` parameter was used to generate all the files and resources in addition to the basic model.

- **Migration**: used to define the structure of tables in the database. It creates, modifies, or deletes tables in a controlled manner.

- **Factory**: used to generate fake test data.

- **Seeder**: used to populate the database with initial data.

- **Controller**: a basic controller.

After that, the structure of the tables can be defined in the migration files.

`..._create_customers_table.php`
```php
public function up(): void
{
    Schema::create('customers', function (Blueprint $table) {
        $table->id();
        $table->string('name');
        $table->string('type');
        $table->string('email');
        $table->string('address');
        $table->string('city');
        $table->string('state');
        $table->string('postal_code');
        $table->timestamps();
    });
}
```

---

In the invoices migration file, a column named `customer_id` of type `integer` was added. It is through this column that the relationship between `Customer` and its `Invoices` will be established.

`..._create_invoices_table.php`
```php
public function up(): void
{
    Schema::create('invoices', function (Blueprint $table) {
        $table->id();
        $table->integer('customer_id');
        $table->integer('amount');
        $table->string('status');
        $table->dateTime('billed_date');
        $table->dateTime('paid_date')->nullable();
        $table->timestamps();
    });
}
```

To ensure the relationship, changes were also made to the model files.

A `Customer` has multiple `Invoices`.

`Customer.php`
```php
class Customer extends Model
{
    use HasFactory;

    public function invoices(){
        return $this->hasMany(Invoice::class);
    }
}
```

---

And an `Invoice` belongs to a `Customers`.

`Invoice.php`
```php
class Invoice extends Model
{
    use HasFactory;

    public function customer(){
        return $this->belongsTo(Customer::class);
    }
}
```

### 03: Creating models factories

Functions were created to generate fake data for testing purposes.

`CustomerFactory.php`
```php
public function definition(): array
{
    $type = $this->faker->randomElement(['I', 'B']);
    $name = $type == 'I' ? $this->faker->name() : $this->faker->company();

    return [
        'name' => $name,
        'type' => $type,
        'email' => $this->faker->email(),
        'address' => $this->faker->streetAddress(),
        'city' => $this->faker->city(),
        'state' => $this->faker->state(),
        'postal_code' => $this->faker->postcode()
    ];
}
```

---

`Invoiceactory.php`
```php
public function definition(): array
{
    $status = $this->faker->randomElement(['B', 'P', 'V']);

    return [
        'customer_id' => Customer::factory(),
        'amount' => $this->faker->numberBetween(100, 20000),
        'status' => $status,
        'billed_date' => $this->faker->dateTimeThisDecade(),
        'paid_date' => $status == 'P' ? $this->faker->dateTimeThisDecade() : NULL,
    ];
}
```

### 04: Seeding the Database

Now we can configure how the database will be populated.

First, we set up the generation of `Customers`.

`CustomerSeeder.php`
```php
public function run(): void
{
    Customer::factory()
        ->count(25)
        ->hasInvoices(10)
        ->create();

    Customer::factory()
        ->count(100)
        ->hasInvoices(5)
        ->create();

    Customer::factory()
        ->count(100)
        ->hasInvoices(3)
        ->create();

    Customer::factory()
        ->count(5)
        ->create();
}
```

---

Then, we instruct the system to call the seeder class to generate the data.

`DatabaseSeeder.php`
```php
public function run(): void
{
    $this->call([
        CustomerSeeder::class
    ]);
}
```

---

Finally, we can generate and populate the database.

```
php artisan migrate:fresh --seed
```

This command is used in Laravel to recreate all the database tables from scratch and then fill them with initial data using the seeders.

The command rolls back all the previously executed migrations and then re-runs all the migrations.

`--seed` is an additional option that instructs Artisan to run the seeders after recreating the tables.

### 05: Versioning and defining routes

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
