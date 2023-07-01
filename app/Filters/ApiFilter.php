<?php

namespace App\Filters;

use Illuminate\Http\Request;

class ApiFilter{

    protected static $safeParms = [];
    protected static $columnMap = [];
    protected static $operatorMap = [
        'eq'  => '=',
        'ne'  => '!=',
        'lt'  => '<',
        'lte' => '<=',
        'gt'  => '>',
        'gte' => '>=',
    ];

    public static function transform(Request $request) {
        $eloQuery = [];

        foreach(static::$safeParms as $parm => $operators){
            $query = $request->query($parm);
            if(!isset($query)){
                continue;
            }

            $column = static::$columnMap[$parm] ?? $parm;
            foreach($operators as $operator){
                if(isset($query[$operator])){
                    $eloQuery[] = [$column, static::$operatorMap[$operator], $query[$operator]];
                }
            }
        }

        return $eloQuery;
    }
}
