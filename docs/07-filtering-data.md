# 07: Filtering Data

Primeiramente, foi necessário definir como seria o padrão de filtragem na URL. O padrão escolhido foi o seguinte:

```
/resource?field[op]=value
```

- **field:** é o campo a ser filtrado.
- **op:** é a operação a ser realizada.
- **value:** é o valor do campo a ser filtrado.

---

Então começamos desenvolvendo um código que receba essa requisição e deixe no padrão que o Laravel consiga fazer a filtragem. O padra é `[$field, $op, $value]`.

Para isso foi criado uma classe que servirá de base para as que definiram os campos que podem ser filtrados.

---

- :arrow_left: [Previous](06-transforming-database-data-into-json)
- :arrow_right: [Next](/README.md)
