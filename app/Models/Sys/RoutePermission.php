<?php

namespace App\Models\Sys;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\CreatedUpdatedBy;
use Illuminate\Support\Facades\Route;
use \Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;
use App\Models\Sys\App;

class RoutePermission extends Model
{
    use HasFactory, CreatedUpdatedBy;
    protected $table = 'sys_route_permissions';

    protected $fillable = [
        'route_name',
        'user_id',
        'sector_n1_id',
        'sector_n2_id',
        'manager_n1_id',
        'manager_n2_id',
        'manager_n3_id',
        'manager_n4_id',
        'manager_n5_id',
        'manager_n6_id',
        'hierarchical_level',
        'type',
        'allowed'
    ];

    // regras para validação de acessos 
    static function userRules()
    {
        // gera regras para filtro de acessos dos usuários 
        $payload = auth()->user();

        $user_id = empty($payload['id']) ? '""' : $payload['id'];
        $sector_n1_id = empty($payload['sector_n1_id']) ? '""' : $payload['sector_n1_id'];
        $sector_n2_id = empty($payload['sector_n2_id']) ? '""' : $payload['sector_n2_id'];
        $manager_n1_id = empty($payload['manager_n1_id']) ? '""' : $payload['manager_n1_id'];
        $manager_n2_id = empty($payload['manager_n2_id']) ? '""' : $payload['manager_n2_id'];
        $manager_n3_id = empty($payload['manager_n3_id']) ? '""' : $payload['manager_n3_id'];
        $manager_n4_id = empty($payload['manager_n4_id']) ? '""' : $payload['manager_n4_id'];
        $manager_n5_id = empty($payload['manager_n5_id']) ? '""' : $payload['manager_n5_id'];
        $manager_n6_id = empty($payload['manager_n6_id']) ? '""' : $payload['manager_n6_id'];
        $hierarchical_level = empty($payload['hierarchical_level']) ? '"0"' : $payload['hierarchical_level'];
        $type = empty($payload['type']) ? '""' : $payload['type'];



        $where = '   ? like user_id
                 and ? LIKE sector_n1_id
                 and ? LIKE sector_n2_id
                 and ? LIKE manager_n1_id
                 and ? LIKE manager_n2_id
                 and ? LIKE manager_n3_id
                 and ? LIKE manager_n4_id
                 and ? LIKE manager_n5_id
                 and ? LIKE manager_n6_id
                 and ? LIKE hierarchical_level
                 and ? LIKE type
                 and allowed = 1 ';
        $search  =
            [
                $user_id,
                $sector_n1_id,
                $sector_n2_id,
                $manager_n1_id,
                $manager_n2_id,
                $manager_n3_id,
                $manager_n4_id,
                $manager_n5_id,
                $manager_n6_id,
                $hierarchical_level,
                $type
            ];

        $filtros = ['where' => $where, 'search' => $search];

        return $filtros;
    }

    // valida acesso a rota requisitada pelo usuário
    static function accesses($route = null)
    {
        //verifica se o usuário é admin, sendo adminim libera o acesso 
        $isAdmin = RoutePermission::isAdmin();

        if ($isAdmin >= 1) {
            return 1;
        }

        //captura a rota atual ou rota repassada
        $routes = $route ? $route->toArray() : [Route::getCurrentRoute()->getName()];

        $where = ' and (';

        foreach ($routes as $key => $route) {
            $where .= $key == 0 ? ' ? like route_name ' : ' or ? like route_name ';
        }

        $where .= ')';

        //lista as regras de acesso para o usuário logado
        $userRoles = RoutePermission::userRules();

        $userRoles['where'] = $userRoles['where'] . $where;
        $userRoles['search'] = array_merge($userRoles['search'], $routes);


        //verifica se o usuário possue permissão de acesso
        $permission = RoutePermission::whereRaw($userRoles['where'],  $userRoles['search'])
            ->get('allowed')->first();

        $permission['allowed'] = !empty($permission['allowed']) ? $permission['allowed'] :  0;

        return $permission['allowed'];
    }

    // lista de rotas que o usuário possui permisão para acessar 
    static function routeAllowed()
    {
        //lista as regras de acesso para o usuário logado
        $userRoles = self::userRules();

        //lista as rotas liberadas para o usuário
        $routes = RoutePermission::whereRaw($userRoles['where'],  $userRoles['search'])
            ->where('allowed', '1')
            ->get(['route_name', 'allowed']);

        $routes = $routes->map(function ($item, $key) {
            return $item['route_name'];
        });

        return  $routes;
    }

    // Gera lista de navegação do usuário (modulos, menus n1 e n2)
    static function navigation()
    {
        // Lista rotas permitidas para o usuário
        $routes = RoutePermission::routeAllowed();

        // armazena as rotas autorizadas para serem usadas no filtro
        $routes = array_values($routes->toArray());

        // usa as rotas para capturar o ID dos menus N2 liberados 
        $apps = App::where(function ($query) use ($routes) {
            foreach ($routes as $key => $route) {
                $key == 0 ? $query->where('route_api', 'like', $route) : $query->orWhere('route_api', 'like', $route);
            };
        })->groupBy('menu_n2_id')->get('menu_n2_id');

        $apps = $apps->map(function ($item, $key) {
            return $item['menu_n2_id'];
        });

        // Verifica se usuário é admin
        $isAdmin = RoutePermission::isAdmin();

        
        // pega os módulos, menus N1 e menus N2 liberados para o usuário 
        $navigation = Module::withWhereHas('sysMenuN1.sysMenuN2', function ($query) use ( $apps, $isAdmin  ) {

            $query->where('status', 1);
            // Libera todos os items se o usuário for admin 
            if($isAdmin < 1) {
                $query->whereIn('id',  $apps );
            }
            
           

        })->where('status', 1)->orderBy('order')->get(['id', 'title', 'icon','order'])->toArray();

        // dd( $navigation);
        // remove menus n2 que não possuem menu N2 liberados 
        $navigation = collect($navigation)->map(function ($value) {
            $value['sys_menu_n1'] = collect($value['sys_menu_n1'])->filter(function ($value2, $key2) {
                return collect($value2['sys_menu_n2'])->count();
            });
            return $value;
        });

        // Gera lista de menus N2 para serem usadas pelo componente  
        $menuN2 = [];
        foreach ($navigation as $valueN0) {
            foreach ($valueN0['sys_menu_n1'] as $valueN1) {
                // if($valueN1['sys_menu_n2']['status'] == 1){
                $menuN2[$valueN1['to']] = collect($valueN1['sys_menu_n2'])->filter(function ($value2, $key2) {
                    return $value2['status'] == '1';
                });;
                // }
            }
        }

        // $navigation['menuN2'] =  $menuN2;
        return $navigation;
    }



    // Formata lista de rotas para serem usadas no menu dinamico conforme rota atual
    static function isAdmin()
    {
        $user =  auth()->user()->id;

        $isAdmin = RoutePermission::where('user_id', $user)
            ->where('route_name', '_%')
            ->where('sector_n1_id', '_%')
            ->where('sector_n2_id', '_%')
            ->where('manager_n1_id', '_%')
            ->where('manager_n2_id', '_%')
            ->where('manager_n3_id', '_%')
            ->where('manager_n4_id', '_%')
            ->where('manager_n5_id', '_%')
            ->where('manager_n6_id', '_%')
            ->where('hierarchical_level', '_%')
            ->where('type', '_%')
            ->where('allowed', '1')->count();

        return $isAdmin;
    }

    // Formata lista de rotas para serem usadas no menu dinamico conforme rota atual
    static function menuN1()
    {
        // pega lista de menus liberados para o usuários (módulo, n1 e n2)
        $navigation = self::navigation();

        // Gera lista de menus N2 para serem usadas pelo componente  
        $menuN2 = [];
        foreach ($navigation as $valueN0) {
            foreach ($valueN0['sys_menu_n1'] as $valueN1) {
                $menuN2[$valueN1['to']] =  $valueN1['sys_menu_n2'];
            }
        }

        return $menuN2;
    }
    // relacionamentos da tabela

    public function getMenuN2()
    {
        return $this->belongsTo('App\Models\Sys\MenuN2', 'route_name', 'to');
    }

    public function sysApp()
    {
        return $this->belongsTo('App\Models\Sys\app', 'route_name', 'route_api');
    }
}
