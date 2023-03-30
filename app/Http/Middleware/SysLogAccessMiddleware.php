<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Traits\ApiResponser;
use App\Models\Sys\LogAccess;
use App\Models\Sys\RoutePermission;
use Illuminate\Support\Facades\Route;
use App\Models\Sys\User;
use hisorange\BrowserDetect\Parser as Browser;
use Response;


class SysLogAccessMiddleware
{
    use ApiResponser;
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        /** @var  Browser|null $browser */
        // pega a rota atual para velidar o acesso 
        $route = Route::getCurrentRoute();

        if(strpos( $route->getName(), 'index')){
            return $next($request);
        };
        
        // verifica qual o usuário está autenticado ou tentando se autenticar 
        $payload['user_id'] = $request->id ? $request->id : 'bc000000';        
        $user = !empty(auth()->user()) ?  auth()->user() : User::find($payload['user_id']);
        $user = collect($user)->only(['id','position_summary','sector_n1_id', 'manager_n1_id', 'manager_n2_id', 'manager_n3_id', 'manager_n4_id', 'manager_n5_id', 'status_real']);
        $payload['user_id'] = $user['id'];   


        // verifica se o usuário possui acesso liberado para a rota
        $payload['allowed'] = RoutePermission::accesses();

               
        // envia a requisição para frente e captura seu retorno para registro em log
        $return = $payload['allowed'] == 1 ? $next($request) : 'Acesso não autorizado';

        // se a rota for de autenticação, oculta parte do header para proteger dados do usuário 
        if( $route->getName() == 'auth.store' && $payload['allowed'] == 1){
            $return_status = collect($return->original)->only(['status','message','errors']);
        } 
        if( $route->getName() == 'auth.store' && $payload['allowed'] == 0){
            $return_status = 'Acesso não autorizado';
        } 

        // Gera a lista que será salva no log de acessos
        $payload['user'] = $user;
        $payload['request'] = $route->getName() == 'auth.store' ? json_encode($route->methods) . " | Tela de Autenticação |".  json_encode($return_status,JSON_UNESCAPED_UNICODE) : json_encode($route->methods) . " | " . json_encode($request->all(),JSON_UNESCAPED_UNICODE);
        $payload['ip'] = $request->server->get('REMOTE_ADDR');
        $payload['route_uri'] = $route->uri;
        $payload['route_name'] = $route->getName();
        $payload['hostname'] = gethostname();
        $payload['user_agent'] = $request->server('HTTP_USER_AGENT');
        $payload['browser_name'] = Browser::browserName() ? Browser::browserName() : 'Não localizado';
        $payload['browser_family'] = Browser::browserFamily() ? Browser::browserFamily() : 'Não localizado';
        $payload['browser_version'] = Browser::browserVersion() ? Browser::browserVersion() : 'Não localizado';
        $payload['platform_name'] = Browser::platformName() ? Browser::platformName() : 'Não localizado';
        $payload['platform_family'] = Browser::platformFamily() ? Browser::platformFamily() : 'Não localizado';
        $payload['platform_version'] = Browser::platformVersion() ? Browser::platformVersion() : 'Não localizado';
       
        LogAccess::create($payload);

        return $payload['allowed'] == 1 ? $return : $this->error("Rota: ". $route->getName(), 'Acesso não autorizado', 422);

    }

}
