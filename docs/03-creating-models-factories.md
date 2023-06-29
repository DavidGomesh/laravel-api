# 03: Creating models factories

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

`InvoiceFactory.php`
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

---

- :arrow_left: [Previous](02-designing-the-database.md)
- :arrow_right: [Next](04-seeding-the-database.md)