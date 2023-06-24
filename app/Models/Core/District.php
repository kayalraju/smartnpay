<?php

namespace App\Models\Core;

// use Illuminate\Database\Eloquent\Factories\HasFactory;
use Kyslik\ColumnSortable\Sortable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class District extends Model
{
    use Sortable;
    public $sortable = ['districts_id', 'districts_name'];
    public $sortableAs = ['states_name'];
    public function getter()
    {
        $districts = District::sortable(['districts_id' => 'ASC'])
            ->LeftJoin('states', 'states.states_id', '=', 'districts.states_id')
            ->groupby('districts.districts_id')
            ->get();
        return $districts;
    }

    public function paginator()
    {
        $districts = District::sortable(['districts_id' => 'ASC'])
            ->LeftJoin('states', 'states.states_id', '=', 'districts.states_id')
            ->groupby('districts.districts_id')
            ->paginate(30);
        return $districts;
    }

    public function filter($data)
    {

        $name = $data['FilterBy'];
        $param = $data['parameter'];

        switch ($name) {
            case 'DistrictName':
                $districts = District::sortable(['districts_id' => 'ASC'])->where('districts_name', 'LIKE', '%' . $param . '%')
                    ->LeftJoin('states', 'states.states_id', '=', 'districts.states_id')
                    ->groupby('districts.districts_id')
                    ->orderBy('districts_id', 'ASC')
                    ->paginate(30);
                break;
            case 'StateName':
                $districts = District::sortable(['districts_id' => 'ASC'])->where('states_name', 'LIKE', '%' . $param . '%')
                    ->LeftJoin('states', 'states.states_id', '=', 'districts.states_id')
                    ->groupby('districts.districts_id')
                    ->orderBy('districts_id', 'ASC')
                    ->paginate(30);
                break;
            default:
                $districts = District::sortable(['districts_id' => 'ASC'])
                ->LeftJoin('states', 'states.states_id', '=', 'districts.states_id')
                ->groupby('districts.districts_id')
                ->paginate(30);
                break;
        }
        return $districts;
    }

    public function insert($request)
    {
        $district_id = DB::table('districts')->insertGetId([
            'districts_name' => $request->districts_name,
            'states_id' => $request->states_id
        ]);
        return $district_id;
    }

    public function edit($id)
    {
        $district = District::where('districts_id', $id)->LeftJoin('states', 'states.states_id', '=', 'districts.states_id')->first();
        return $district;
    }

    public function updaterecord($request)
    {
        $districtUpdate = DB::table('districts')->where('districts_id', $request->id)->update([
            'districts_name' => $request->districts_name,
            'states_id' => $request->states_id
        ]);
        return $districtUpdate;
    }

    public function deleterecord($request)
    {
        $deletedistrict = DB::table('districts')->where('districts_id', $request->id)->delete();
    }

    public function getdistrict($request)
    {
        $district = DB::table('districts')
        ->where('districts_id', $request->id)
        ->LeftJoin('states', 'states.states_id', '=', 'districts.states_id')
        ->groupby('districts.districts_id')
        ->get();
        return $district;
    }
    public function getdistrictsbystate($statesId){
        $districts = DB::table('districts')->where('states_id', $statesId)->get();
        return $districts;
      }
    public function getdistricts(){
        $districts = DB::table('districts')->get();
        return $districts;
      }
}