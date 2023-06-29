# 04: Seeding the Database

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

---

- :arrow_left: [Previous](03-creating-models-factories.md)
- :arrow_right: [Next](05-versioning-and-defining-routes.md)