<?php

namespace App\Filters\V1;

use App\Filters\ApiFilter;

class CustomersFilter extends ApiFilter {

    protected static $safeParms = [
        'name' => ['eq'],
        'type' => ['eq'],
        'email' => ['eq'],
        'address' => ['eq'],
        'city' => ['eq'],
        'state' => ['eq'],
        'postalCode' => ['eq', 'gt', 'lt'],
    ];

    protected static $columnMap = [
        'postalCode' => 'postal_code',
    ];
}
