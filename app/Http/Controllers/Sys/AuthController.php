<?php

namespace App\Http\Controllers\Sys;

use App\Models\Sys\User;
use Illuminate\Http\Request;
use App\Traits\ApiResponser;
use App\Models\Sys\GipSectorN1;
use App\Models\Sys\RoutePermission;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Http\Requests\Sys\AuthRequest;
use Illuminate\Support\Facades\Storage;

class AuthController extends Controller
{
    use ApiResponser;

    public function __construct()
    {
        $this->middleware('auth:sanctum', ['except' => ['store']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
        $navigation = RoutePermission::navigation();
        $menuN1 = RoutePermission::menuN1();

        $id = auth()->user()->id;    
        $user = User::find($id)->only('id', 'name', 'uf', 'position', 'manager_n6_id','manager_n5_id','manager_n4_id','manager_n3_id','manager_n2_id','manager_n1_id','position_summary','sector_n1_id', 'hierarchical_level'); 

        $avatar_original = env('APP_URL') ."storage/UsersAvatars/$id.jpg";
        $avatar_generic  = env('APP_URL') ."storage/UsersAvatars/bc000000.jpg" ;
        
        $user['avatar'] = !Storage::disk('public')->exists("UsersAvatars/$id.jpg") ? $avatar_generic : $avatar_original;
        $user['sector_n1'] = GipSectorN1::find($user['sector_n1_id'])->only(['id', 'name', 'uf']);
        $user['navigation'] = $navigation;
        $user['menuN1'] =$menuN1 ;
        
        return $this->success($user);


    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(AuthRequest $request)
    {
        $id = $request['id'];
        $password = $request['password'];    
        
        $log_acesso = ''; // Teste

        // validação com rede oi
        // $url_nds = "http://brtccwebservice01.brasiltelecom.intra.corp/siswebldap/Servicos.asmx/ValidacaoNDS?Usuario=$id&Senha=$password&Autenticar=&Servidor=&Porta=&DN=&O=&AcessoSeguro=&Propriedades=";

        // // resultado da solcitação
        // $xmlstr = file_get_contents($url_nds);
        // $log_acesso = substr($xmlstr, strpos($xmlstr, '#'), strripos($xmlstr, '#'));
        // $log_acesso = str_replace('</string>', '', $log_acesso);

        // if (stristr($xmlstr, 'Usuario OK') === false) {
        //     return $this->error($log_acesso, 'Usuário ou senha invalidos', 222);
        // }

        $payload = $request->all();
        $payload['email'] = $payload['id'] . '@oicorp.mail.onmicrosoft.com';
        $payload['password'] = '123456';

        if (!Auth::attempt($payload)) {
            return $this->error($log_acesso, 'Usuário ou senha invalidos', 222);
        }

        /** @var \App\Sys\User|null $user */
        $user = auth()->user();
        $user->tokens()->where('name', 'Session')->delete();
        $token =  $user->createToken('Session')->plainTextToken;
        // $Avatar = Storage::disk('public')->exists("UsersAvatars/$id.jpg") ? UserAvatar::store() : 0;

        return $this->success(['token' => $token,  ],$log_acesso);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            /** @var \App\User|null $user */
            $user = auth()->user();
            $user->tokens('Session Token')->delete();
            $id = $user->id;
        } catch (\Throwable $th) {
            return $this->error($th, 'Erro ao finalizar sessão', 422);
        }

        return $this->success('Sessão finalizada com sucesso', $id );
    }
}
