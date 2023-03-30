<?php

namespace App\Http\Controllers\Sys;

use App\Traits\ApiResponser;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;


class UserAvatarController extends Controller
{
    use ApiResponser;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        
        $user = auth()->user()->id;

        $list = Http::withOptions([
            'proxy' => 'http://SPANM6001:5sqLK7cc@10.35.150.40:82'
        ])->get('http://fotoparacracha.oiservicos.com.br/api/photo');
       
       $list = json_decode($list, true);
        
        try {

            $n = 0;
            // foreach ($list as $value) {
                // $user = $value['Matricula'];
                $user = '764670';
                if(!Storage::disk('public')->exists("UsersAvatars/$user.jpg")){
                    $response = Http::withOptions([
                        'proxy' => 'http://SPANM6001:5sqLK7cc@10.35.150.40:82'
                    ])->get('http://fotoparacracha.oiservicos.com.br/api/photo', ['matricula' =>  $user]);
                   
                    if(!empty($response['Imagem'])){
                        $image_64 = $response['Imagem']; //your base64 encoded data
                        $imageName = 'UsersAvatars/bc'.$user.'.jpg';
                        Storage::disk('public')->put($imageName, base64_decode($image_64));                       
                    }     
                // }
            $n++;
            }                     
          
            return  $this->success("$n Avatare criados com sucesso",'Dados atualizados');
        } catch (\Throwable $th) {
            return $this->error($th, 'Erro ao salvar fotos', 422);
        }
       
    }

   
    public function show()
    {
        //
    }


    public function update()
    {
        //
    }

    
    public function destroy()
    {
        
    }
}
