<?php

namespace App\Http\Functions;

use App\Http\Controllers\Controller;

class ListFunctions extends Controller
{
    
    static function where($request)
    {
        // Pega a string que está no header da solicitação para usar como filtro
        $where = collect(json_decode($request['where']));
        $where = $where->prepend('1','1');

        // Retira chaves com valor nulo ou vazio 
        $where = $where->filter();
        
        // Prepara o valor da key para ser usado na clausula where
        $where = $where->map(function ($item, $key) {return "NVL(".$key . ",0) like ?";});

        // Transforma a collate em array para pegar somente o valor sem a key e junta tudo em uma sting
        $where = array_values($where->toArray());
        $where = implode(" and ", $where );

        return $where;
        
    }

    static function search($request)
    {
        // Pega a string que está no header da solicitação para usar como filtro
        $search = collect(json_decode($request['where']));
        $search = $search->prepend('1','1');
        // Retira chaves com valor nulo ou vazio 
        $search = $search->filter();
        // Prepara o valor da key para ser usado na clausula where
        $search = $search->map(function ($item, $key) {return $item;});

        // Transforma a collate em array para pegar somente o valor sem a key
        $search = array_values($search->toArray());

        return $search;
        
    }

    static function orderBy($request, $default)
    {
        // Pega a string que está no header da solicitação para usar como filtro
        $orderBy = collect(json_decode($request['orderBy']));
        // Retira chaves com valor nulo ou vazio 
        $orderBy = $orderBy->filter();
        // Prepara o valor da key para ser usado na clausula where
        $orderBy = $orderBy->map(function ($item, $key) {return $key .' '.$item;});

        // Transforma a collate em array para pegar somente o valor sem a key e junta tudo em uma sting
        $orderBy = array_values($orderBy->toArray());
        $orderBy = implode(",", $orderBy );

        $orderBy = empty($orderBy) ? $default : $orderBy;

        return $orderBy;
        
    }

    static function paginate($request)
    {
        $paginate = $request['paginate'] ? $request['paginate'] : 10;
        return  $paginate ;
    }
    

}
