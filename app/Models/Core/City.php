<?php

namespace App\Models\Core;

// use Illuminate\Database\Eloquent\Factories\HasFactory;
use Kyslik\ColumnSortable\Sortable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class City extends Model
{
    use Sortable;
    public $sortable = ['cities_id', 'cities_name'];
    public $sortableAs = ['states_name'];
    public function getter()
    {
        $cities = City::sortable(['cities_id' => 'ASC'])
            ->LeftJoin('states', 'states.states_id', '=', 'cities.states_id')
            ->groupby('cities.cities_id')
            ->get();
        return $cities;
    }

    public function paginator()
    {
        $cities = City::sortable(['cities_id' => 'ASC'])
            ->LeftJoin('states', 'states.states_id', '=', 'cities.states_id')
            ->groupby('cities.cities_id')
            ->paginate(30);
        return $cities;
    }

    public function filter($data)
    {

        $name = $data['FilterBy'];
        $param = $data['parameter'];

        switch ($name) {
            case 'CityName':
                $cities = City::sortable(['cities_id' => 'ASC'])->where('cities_name', 'LIKE', '%' . $param . '%')
                    ->LeftJoin('states', 'states.states_id', '=', 'cities.states_id')
                    ->groupby('cities.cities_id')
                    ->orderBy('cities_id', 'ASC')
                    ->paginate(30);
                break;
            case 'StateName':
                $cities = City::sortable(['cities_id' => 'ASC'])->where('states_name', 'LIKE', '%' . $param . '%')
                    ->LeftJoin('states', 'states.states_id', '=', 'cities.states_id')
                    ->groupby('cities.cities_id')
                    ->orderBy('cities_id', 'ASC')
                    ->paginate(30);
                break;
            default:
                $cities = City::sortable(['cities_id' => 'ASC'])
                ->LeftJoin('states', 'states.states_id', '=', 'cities.states_id')
                ->groupby('cities.cities_id')
                ->paginate(30);
                break;
        }
        return $cities;
    }

    public function insert($request)
    {
        $city_id = DB::table('cities')->insertGetId([
            'cities_name' => $request->cities_name,
            'states_id' => $request->states_id
        ]);
        return $city_id;
    }

    public function edit($id)
    {
        $city = City::where('cities_id', $id)->LeftJoin('states', 'states.states_id', '=', 'cities.states_id')->first();
        return $city;
    }

    public function updaterecord($request)
    {
        $cityUpdate = DB::table('cities')->where('cities_id', $request->id)->update([
            'cities_name' => $request->cities_name,
            'states_id' => $request->states_id
        ]);
        return $cityUpdate;
    }

    public function deleterecord($request)
    {
        $deletecity = DB::table('cities')->where('cities_id', $request->id)->delete();
    }

    public function getcity($request)
    {
        $city = DB::table('cities')
        ->where('cities_id', $request->id)
        ->LeftJoin('states', 'states.states_id', '=', 'cities.states_id')
        ->groupby('cities.cities_id')
        ->get();
        return $city;
    }
}