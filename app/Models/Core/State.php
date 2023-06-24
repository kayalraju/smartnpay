<?php

namespace App\Models\Core;

// use Illuminate\Database\Eloquent\Factories\HasFactory;
use Kyslik\ColumnSortable\Sortable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class State extends Model
{
    // use HasFactory;

    // if your key name is not 'id'
    // you can also set this to null if you don't have a primary key
    // protected $primaryKey = 'states_id';

    use Sortable;
    public $sortable = ['states_id','states_name'];

    public function getter(){
      $states = State::sortable(['states_id'=>'ASC'])->get();
        return $states;
    }

    public function paginator(){
      $states = State::sortable(['states_id'=>'ASC'])->paginate(30);
        return $states;
    }

    public function filter($data){

        $name = $data['FilterBy'];
        $param = $data['parameter'];

        switch ( $name ) {
            case 'StateName':
                 $states = State::sortable(['states_id'=>'ASC'])->where('states_name', 'LIKE', '%' . $param . '%')
                    ->orderBy('states_id','ASC')
                    ->paginate(30);
                break;
           default :
             $states = State::sortable(['states_id'=>'ASC'])->paginate(30);
              break;
        }
        return $states;
    }

    public function insert($request){
        $state_id = DB::table('states')->insertGetId([
            'states_name'  		 =>   $request->states_name
        ]);
        return $state_id;
    }

    public function edit($id){
      $state = State::where('states_id', $id)->first();
      return $state;
    }

    public function updaterecord($request){
        $stateUpdate = DB::table('states')->where('states_id', $request->id)->update([
            'states_name'  		 =>   $request->states_name
        ]);
        return $stateUpdate;
    }

    public function deleterecord($request){
      $deletestate = DB::table('states')->where('states_id', $request->id)->delete();
    }

    public function getstate($request){
      $state = DB::table('states')->where('states_id', $request->id)->get();
      return $state;
    }
    public function getstates(){
        $states = DB::table('states')->get();
        return $states;
      }
}
