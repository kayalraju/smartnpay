<?php

namespace App\Models\Core;

// use Illuminate\Database\Eloquent\Factories\HasFactory;
use Kyslik\ColumnSortable\Sortable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Transaction extends Model
{
    use Sortable;
    // public $sortable = ['districts_id', 'districts_name'];
    // public $sortableAs = ['states_name'];
    // public function getter()
    // {
    //     $districts = District::sortable(['districts_id' => 'ASC'])
    //         ->LeftJoin('states', 'states.states_id', '=', 'districts.states_id')
    //         ->groupby('districts.districts_id')
    //         ->get();
    //     return $districts;
    // }

    // public function paginator()
    // {
    //     $districts = District::sortable(['districts_id' => 'ASC'])
    //         ->LeftJoin('states', 'states.states_id', '=', 'districts.states_id')
    //         ->groupby('districts.districts_id')
    //         ->paginate(30);
    //     return $districts;
    // }

    // public function filter($data)
    // {

    //     $name = $data['FilterBy'];
    //     $param = $data['parameter'];

    //     switch ($name) {
    //         case 'DistrictName':
    //             $districts = District::sortable(['districts_id' => 'ASC'])->where('districts_name', 'LIKE', '%' . $param . '%')
    //                 ->LeftJoin('states', 'states.states_id', '=', 'districts.states_id')
    //                 ->groupby('districts.districts_id')
    //                 ->orderBy('districts_id', 'ASC')
    //                 ->paginate(30);
    //             break;
    //         case 'StateName':
    //             $districts = District::sortable(['districts_id' => 'ASC'])->where('states_name', 'LIKE', '%' . $param . '%')
    //                 ->LeftJoin('states', 'states.states_id', '=', 'districts.states_id')
    //                 ->groupby('districts.districts_id')
    //                 ->orderBy('districts_id', 'ASC')
    //                 ->paginate(30);
    //             break;
    //         default:
    //             $districts = District::sortable(['districts_id' => 'ASC'])
    //             ->LeftJoin('states', 'states.states_id', '=', 'districts.states_id')
    //             ->groupby('districts.districts_id')
    //             ->paginate(30);
    //             break;
    //     }
    //     return $districts;
    // }

    public function insert($transaction_data)
    {
        $transactions_id = DB::table('transactions')->insertGetId([
            'amount' => $transaction_data['amount'],
            'user_account_sender_id' => $transaction_data['user_account_sender_id'],
            'user_account_receiver_id' => $transaction_data['user_account_receiver_id'],
            'transaction_payment_id' => $transaction_data['transaction_payment_id'],
            'transaction_types_id' => $transaction_data['transaction_type'],
            'operator_id' => auth()->user()->id,
            'status' => $transaction_data['status'],
            'other_transaction_details' => $transaction_data['other_transaction_details'],
            'date_of_transaction' => now()
        ]);
        DB::table('transaction_status_history')->insert([
            'transactions_id' => $transactions_id,
            'transaction_status' => $transaction_data['status'],
            'operator_id' => auth()->user()->id,
            'remarks' => $transaction_data['remarks'],
            'created_at' => now()
        ]);
        return $transactions_id;
    }

    // public function edit($id)
    // {
    //     $district = District::where('districts_id', $id)->LeftJoin('states', 'states.states_id', '=', 'districts.states_id')->first();
    //     return $district;
    // }

    public function updateStatus($request)
    {
        $transactionUpdate = DB::table('transactions')->where('transactions_id', $request->transactions_id)->update([
            'status' => $request->status,
            'updated_at' => now()
        ]);
        DB::table('transactions')->insert([
            'transactions_id' => $request->transactions_id,
            'transaction_status' => $request->status,
            'operator_id' => auth()->user()->id,
            'remarks' => $request->remarks,
            'created_at' => now()
        ]);
        return $transactionUpdate;
    }

    // public function deleterecord($request)
    // {
    //     $deletedistrict = DB::table('districts')->where('districts_id', $request->id)->delete();
    // }

    // public function getdistrict($request)
    // {
    //     $district = DB::table('districts')
    //     ->where('districts_id', $request->id)
    //     ->LeftJoin('states', 'states.states_id', '=', 'districts.states_id')
    //     ->groupby('districts.districts_id')
    //     ->get();
    //     return $district;
    // }

    // public function getdistricts($states_id){
    //     $districts = DB::table('districts')->where('states_id', $states_id)->get();
    //     return $districts;
    //   }
}