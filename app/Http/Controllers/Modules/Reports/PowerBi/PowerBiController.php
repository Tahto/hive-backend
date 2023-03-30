<?php

namespace App\Http\Controllers\Modules\Reports\PowerBi;

use App\Models\Modules\Reports\PowerBi;
use App\Models\Modules\Reports\PowerBiOwner;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Traits\ApiResponser;
use App\Http\Functions\ListFunctions;
use App\Http\Requests\Modules\Reports\PowerBi\PowerbiRequest;
use Illuminate\Support\Facades\DB;
use PhpParser\Node\Expr\AssignOp\Coalesce;

use function PHPSTORM_META\map;

class PowerBiController extends Controller
{
    use ApiResponser;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        try {
            $where = ListFunctions::where($request);
            $search  = ListFunctions::search($request);
            $orderBy  = ListFunctions::orderBy($request, 'title asc'); // Importante!!! Definir ordenação padrão
            $paginate = ListFunctions::paginate($request);;
            $data = PowerBi::with(['owners.user', 'status'])
                ->select(['id', 'title', 'url', 'status'])
                ->whereRaw($where, $search)
                ->orderByRaw($orderBy)->paginate($paginate)->onEachSide(0);
        } catch (\Throwable $th) {
            return $this->error($th, 'Erro ao gerar lista', 422);
        }
        return  $data;
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PowerbiRequest $request)
    {

        $payload = $request->all();
        try {
            DB::beginTransaction();
            $data = PowerBi::create($payload);
            $owner = $data->owners()->createMany($payload['owners']);
            DB::commit();
        } catch (\Throwable $th) {
            return $this->error($th, 'Erro ao gerar lista', 422);
        }
        return $this->success([$data, $owner], 'Registro realizado com sucesso');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Modules\Reports\PowerBi  $powerBi
     * @return \Illuminate\Http\Response
     */
    public function show(PowerBi $powerBi)
    {
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Modules\Reports\PowerBi  $powerBi
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, PowerBi $powerBi)
    {
        $payload = $request->all();

        $powerBi['title'] = $payload['title'];
        $powerBi['url'] = $payload['url'];
        $powerBi['status'] = $payload['status'];

        try {
            DB::beginTransaction();
            // Salva alteções diretas
            $powerBi->save();

            // Desativa os owners removidos da lista 
            PowerBiOwner::where('status', 1)
                ->where('report_id', $powerBi->id)
                ->whereNotIn('owner_id', array_values($payload['owners']))
                ->update(['status' => 0]);

            // Pega todos os owners ativos 
            $ownersActive = PowerBiOwner::where('status', 1)->where('report_id', $powerBi->id)->get(['owner_id']);

            // Mapeia o objeto para trazer somente as mantriculas em array simples 
            $ownersActive = $ownersActive->map(function ($item, $key) {
                return $item['owner_id'];
            })->toArray();

            // Paga somente o que é novo para salvar 
            $ownersNew = collect($payload['owners'])->whereNotIn('owner_id', $ownersActive)->toArray();

            // salva os novos owners 
            $powerBi->owners()->createMany($ownersNew);

            DB::commit();
        } catch (\Throwable $th) {
            return $this->error($th, 'Erro ao gerar lista', 422);
        }
        // return $this->success([$data, $owner], 'Registro realizado com sucesso');
        return $this->success($powerBi, 'Registro realizado com sucesso');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Modules\Reports\PowerBi  $powerBi
     * @return \Illuminate\Http\Response
     */
    public function destroy(PowerBi $powerBi)
    {
        //
    }
}
