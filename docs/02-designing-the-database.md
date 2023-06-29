# 02: Designing the Database

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

---

- :arrow_left: [Previous](01-creating-the-project.md)
- :arrow_right: [Next](03-creating-models-factories.md)