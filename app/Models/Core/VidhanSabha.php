<?php

namespace App\Models\Core;

// use Illuminate\Database\Eloquent\Factories\HasFactory;
use Kyslik\ColumnSortable\Sortable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class VidhanSabha extends Model
{
    use Sortable;
    public $sortable = ['vidhan_sabhas_id', 'vidhan_sabhas_name'];
    public $sortableAs = ['districts_name','states_name'];
    public function getter()
    {
        $vidhan_sabhas = VidhanSabha::sortable(['vidhan_sabhas_id' => 'ASC'])
            ->LeftJoin('districts', 'districts.districts_id', '=', 'vidhan_sabhas.districts_id')
            ->LeftJoin('states', 'states.states_id', '=', 'districts.states_id')
            ->groupby('vidhan_sabhas.vidhan_sabhas_id')
            ->get();
        return $vidhan_sabhas;
    }

    public function paginator()
    {
        $vidhan_sabhas = VidhanSabha::sortable(['vidhan_sabhas_id' => 'ASC'])
            ->LeftJoin('districts', 'districts.districts_id', '=', 'vidhan_sabhas.districts_id')
            ->LeftJoin('states', 'states.states_id', '=', 'districts.states_id')
            ->groupby('vidhan_sabhas.vidhan_sabhas_id')
            ->paginate(30);
        return $vidhan_sabhas;
    }

    public function filter($data)
    {

        $name = $data['FilterBy'];
        $param = $data['parameter'];

        switch ($name) {
            case 'VidhanSabhaName':
                $vidhan_sabhas = VidhanSabha::sortable(['vidhan_sabhas_id' => 'ASC'])->where('vidhan_sabhas_name', 'LIKE', '%' . $param . '%')
                    ->LeftJoin('districts', 'districts.districts_id', '=', 'vidhan_sabhas.districts_id')
                    ->LeftJoin('states', 'states.states_id', '=', 'districts.states_id')
                    ->groupby('vidhan_sabhas.vidhan_sabhas_id')
                    ->orderBy('vidhan_sabhas_id', 'ASC')
                    ->paginate(30);
                break;
            case 'StateName':
                $vidhan_sabhas = VidhanSabha::sortable(['vidhan_sabhas_id' => 'ASC'])->where('districts_name', 'LIKE', '%' . $param . '%')
                    ->LeftJoin('districts', 'districts.districts_id', '=', 'vidhan_sabhas.districts_id')
                    ->LeftJoin('states', 'states.states_id', '=', 'districts.states_id')
                    ->groupby('vidhan_sabhas.vidhan_sabhas_id')
                    ->orderBy('vidhan_sabhas_id', 'ASC')
                    ->paginate(30);
                break;
            default:
                $vidhan_sabhas = VidhanSabha::sortable(['vidhan_sabhas_id' => 'ASC'])
                ->LeftJoin('districts', 'districts.districts_id', '=', 'vidhan_sabhas.districts_id')
                ->groupby('vidhan_sabhas.vidhan_sabhas_id')
                ->paginate(30);
                break;
        }
        return $vidhan_sabhas;
    }

    public function insert($request)
    {
        $vidhan_sabha_id = DB::table('vidhan_sabhas')->insertGetId([
            'vidhan_sabhas_name' => $request->vidhan_sabhas_name,
            'districts_id' => $request->districts_id,
            'states_id' => $request->states_id
        ]);
        return $vidhan_sabha_id;
    }

    public function edit($id)
    {
        $vidhan_sabha = VidhanSabha::where('vidhan_sabhas_id', $id)->LeftJoin('districts', 'districts.districts_id', '=', 'vidhan_sabhas.districts_id')->first();
        return $vidhan_sabha;
    }

    public function updaterecord($request)
    {
        $vidhan_sabhaUpdate = DB::table('vidhan_sabhas')->where('vidhan_sabhas_id', $request->id)->update([
            'vidhan_sabhas_name' => $request->vidhan_sabhas_name,
            'districts_id' => $request->districts_id,
            'states_id' => $request->states_id
        ]);
        return $vidhan_sabhaUpdate;
    }

    public function deleterecord($request)
    {
        $deletevidhan_sabha = DB::table('vidhan_sabhas')->where('vidhan_sabhas_id', $request->id)->delete();
    }

    public function getvidhansabha($request)
    {
        $vidhan_sabha = DB::table('vidhan_sabhas')
        ->where('vidhan_sabhas_id', $request->id)
        ->LeftJoin('districts', 'districts.districts_id', '=', 'vidhan_sabhas.districts_id')
        ->LeftJoin('states', 'states.states_id', '=', 'districts.states_id')
        ->groupby('vidhan_sabhas.vidhan_sabhas_id')
        ->get();
        return $vidhan_sabha;
    }
    public function getvidhansabhas($districts_id){
        $vidhan_sabhas = DB::table('vidhan_sabhas')->where('districts_id', $districts_id)->get();
        return $vidhan_sabhas;
      }
}