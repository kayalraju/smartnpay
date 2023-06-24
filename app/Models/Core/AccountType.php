<?php

namespace App\Models\Core;

// use Illuminate\Database\Eloquent\Factories\HasFactory;
use Kyslik\ColumnSortable\Sortable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class AccountType extends Model
{
    // use HasFactory;

    // if your key name is not 'id'
    // you can also set this to null if you don't have a primary key
    // protected $primaryKey = 'account_types_id';

    use Sortable;
    public $sortable = ['account_types_id','account_types_name'];

    public function getter(){
      $accountTypes = AccountType::sortable(['account_types_id'=>'ASC'])->get();
        return $accountTypes;
    }

    public function paginator(){
      $accountTypes = AccountType::sortable(['account_types_id'=>'ASC'])->paginate(30);
        return $accountTypes;
    }

    public function filter($data){

        $name = $data['FilterBy'];
        $param = $data['parameter'];

        switch ( $name ) {
            case 'AccountTypeName':
                 $accountTypes = AccountType::sortable(['account_types_id'=>'ASC'])->where('account_types_name', 'LIKE', '%' . $param . '%')
                    ->orderBy('account_types_id','ASC')
                    ->paginate(30);
                break;
           default :
             $accountTypes = AccountType::sortable(['account_types_id'=>'ASC'])->paginate(30);
              break;
        }
        return $accountTypes;
    }

    public function insert($request){
        $accountType_id = DB::table('account_types')->insertGetId([
            'account_types_name'  		 =>   $request->account_types_name
        ]);
        return $accountType_id;
    }

    public function edit($id){
      $accountType = AccountType::where('account_types_id', $id)->first();
      return $accountType;
    }

    public function updaterecord($request){
        $accountTypeUpdate = DB::table('account_types')->where('account_types_id', $request->id)->update([
            'account_types_name'  		 =>   $request->account_types_name
        ]);
        return $accountTypeUpdate;
    }

    public function deleterecord($request){
      $deleteaccounttype = DB::table('account_types')->where('account_types_id', $request->id)->delete();
    }

    public function getaccounttype($request){
      $accountType = DB::table('account_types')->where('account_types_id', $request->id)->get();
      return $accountType;
    }
    public function getaccounttypes($under){
        $accountTypes = DB::table('account_types')->where('account_types_under', $under)->get();
        return $accountTypes;
      }
}
