# 06: Transforming database data into JSON

Nesse passo a primeira coisa a se fazer foi implementar o método `show()` para retornar o `Customer`. Esse método é o que implementa a rota `/customers/{id}`.

`CustomerController.php`
```php
public function show(Customer $customer)
{
    return $customer;
}
```

Então, usando o `php artisan` foi criado dois recursos que servirão para fazer o mapeamento do **model** para o **JSON**. 

```
php artisan make:resource V1\CustomerResource
php artisan make:resource V1\CustomerCollection
```

O `CustomerResource` tranforma um model individual para JSON, enquanto o `CustomerCollection` é capaz de tranformar uma lista de models para uma lista de JSON. A definição do JSON resultante precisa ser implementada no arquivo `CustomerResource`. Já no conversor de lista, nada precisa ser feito pois automaticamente irá usar o **Resource** para fazer a conversão.

`CustomerResource.php`
```php
public function toArray(Request $request): array
{
    return [
        'id' => $this->id,
        'name' => $this->name,
        'type' => $this->type,
        'email' => $this->email,
        'address' => $this->address,
        'city' => $this->city,
        'state' => $this->state,
        'postalCode' => $this->postal_code,
    ];
}
```

No **Controller** será necessário apenas envolver o retorno com uma instância dos **Resources**. O método `paginate()` foi utilizado para tornar a resposta mais padronizada usando paginação.

```php
public function index()
{
    return new CustomerCollection(Customer::paginate());
}

public function show(Customer $customer)
{
    return new CustomerResource($customer);
}
```

---

- :arrow_left: [Previous](05-versioning-and-defining-routes.md)
- :arrow_right: [Next](07-filtering-data.md)
