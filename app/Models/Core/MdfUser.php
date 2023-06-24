<?php

namespace App\Models\Core;

// use Illuminate\Database\Eloquent\Factories\HasFactory;
use Kyslik\ColumnSortable\Sortable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Hash;

class MdfUser extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'users';
    // use HasFactory;

    // if your key name is not 'id'
    // you can also set this to null if you don't have a primary key
    // protected $primaryKey = 'id';

    use Sortable;
    public $sortable = ['id','first_name','email','phone'];
    public $sortableAs = ['states_name','districts_name','vidhan_sabhas_name'];
    public function getter(){
      $mdf_users = MdfUser::sortable(['id'=>'ASC'])->where('role_id', 2)->get();
        return $mdf_users;
    }

    public function paginator(){
      $mdf_users = MdfUser::sortable(['id'=>'ASC']) 
                  ->LeftJoin('states', 'states.states_id', '=', 'users.states_id')
                  ->LeftJoin('districts', 'districts.districts_id', '=', 'users.districts_id')
                  ->LeftJoin('vidhan_sabhas', 'vidhan_sabhas.vidhan_sabhas_id', '=', 'users.vidhan_sabhas_id')
                  ->LeftJoin('accounts', 'accounts.users_id', '=', 'users.id');
      if(auth()->user()->role_id == 17){
        $mdf_users->where('accounts.operated_by', auth()->user()->id);
      }
      $mdf_users_data = $mdf_users->where('role_id', 2)->paginate(30);
        return $mdf_users_data;
    }

    public function filter($data){

        $name = $data['FilterBy'];
        $param = $data['parameter'];

        switch ( $name ) {
            case 'MdfUserName':
                 $mdf_users = MdfUser::sortable(['id'=>'ASC'])->where('role_id', 2)->where('first_name', 'LIKE', '%' . $param . '%')
                    ->orderBy('id','ASC')
                    ->paginate(30);
                break;
           default :
             $mdf_users = MdfUser::sortable(['id'=>'ASC'])->where('role_id', 2)->paginate(30);
              break;
        }
        return $mdf_users;
    }

    public function insert($request){
        $mdf_user_id = DB::table('users')->insertGetId([
            'role_id' => 2,
            'first_name' => $request->first_name,
            'gender' => $request->gender,
            'email' => $request->email,
            'phone' => $request->phone,
            'states_id' => $request->states_id,
            'districts_id' => $request->districts_id,
            'vidhan_sabhas_id' => $request->vidhan_sabhas_id,
            'password' => Hash::make($request->password),
            'created_at'=>now()
        ]);
        DB::table('accounts')->insertGetId([
          'accounts_id' => $request->phone,
          'accounts_name' => $request->first_name,
          'account_types_id' => $request->account_types_id,
          'users_id' => $mdf_user_id,
          'date_of_open' => now(),
          'operated_by' => auth()->user()->id
      ]);
        return $mdf_user_id;
    }

    public function edit($id){
      $mdf_user = MdfUser::where('id', $id)->first();
      return $mdf_user;
    }

    public function updaterecord($request){
        $mdf_user_update_data = [
          // 'role_id' => 2,
          'first_name' => $request->first_name,
          'gender' => $request->gender,
          // 'phone' => $request->phone,
          'email' => $request->email,
          'states_id' => $request->states_id,
          'districts_id' => $request->districts_id,
          'vidhan_sabhas_id' => $request->vidhan_sabhas_id,
          'status' => $request->isActive,
          'updated_at'=>now()
        ];
        if($request->password != ''){
          $mdf_user_update_data['password'] = Hash::make($request->password);
        }

        $mdf_user_update = DB::table('users')->where('id', $request->id)->update($mdf_user_update_data);
        DB::table('accounts')->where('users_id', $request->id)->update([
          // 'accounts_id' => $request->phone,
          'accounts_name' => $request->first_name,
          'account_types_id' => $request->account_types_id
      ]);
        return $mdf_user_update;
    }

    public function deleterecord($request){
      $deletemdfuser = DB::table('users')->where('id', $request->id)->delete();
    }

    public function get_mdf_user($request){
      $mdf_user = DB::table('users')->where('id', $request->id)->get();
      return $mdf_user;
    }
    public function get_    (){
        $mdf_users = DB::table('users')->where('role_id', 2)->get();
        return $mdf_users;
      }
}
