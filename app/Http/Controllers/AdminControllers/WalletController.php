<?php

namespace App\Http\Controllers\AdminControllers;

use App\Http\Controllers\Controller;
use App\Models\Core\Setting;
use App\Models\Core\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Redirect;

class WalletController extends Controller
{
    public function __construct(Setting $setting, Transaction $transaction)
    {
        $this->Setting = $setting;
        $this->Transaction = $transaction;
    }
    public function cspDisplay(Request $request)
    {
        $title = array('pageTitle' => Lang::get("labels.Wallets"));
        $result['cspWallets'] = DB::table('accounts')
                                ->LeftJoin('users', 'users.id', '=', 'accounts.users_id')
                                ->where('account_types_id', 1)
                                ->select('users.first_name','users.email','users.phone','accounts.*')
                                ->get();
        $result['commonContent'] = $this->Setting->commonContent();
        return view("admin.wallets.index", $title)->with('result', $result);
    }

    public function credit($id)
    {
        $title = array('pageTitle' => Lang::get("labels.Wallets"));
        $result['users_id'] = $id;
        $result['transactionTypes'] = 'credit';
        $result['commonContent'] = $this->Setting->commonContent();
        return view("admin.wallets.edit", $title)->with('result', $result);
    }
    public function debit($id)
    {
        $title = array('pageTitle' => Lang::get("labels.Wallets"));
        $result['users_id'] = $id;
        $result['transactionTypes'] = 'debit';
        $result['commonContent'] = $this->Setting->commonContent();
        return view("admin.wallets.edit", $title)->with('result', $result);
    }
    public function update(Request $request)
    {
        $accountDetails = DB::table('accounts')
                            ->where('users_id', $request->id)
                            ->first();
        if($request->transactionTypes == 'credit'){
            $transaction_type = 1;
            $amount = $accountDetails->current_balance + $request->amount;
        }elseif($request->transactionTypes == 'debit'){
            $transaction_type = 2;
            $amount = $accountDetails->current_balance - $request->amount;
        }
        
        $transaction_data = array (
            'amount' => $request->amount,
            'user_account_sender_id' => auth()->user()->id,
            'user_account_receiver_id' => $request->id,
            'transaction_payment_id' => null,
            'transaction_type' => $transaction_type,
            'status' => 'completed',
            'other_transaction_details' => '',
            'remarks' => '',
        );
        $transactions_id = $this->Transaction->insert($transaction_data);
        if($transactions_id){
            $accountsupdate = DB::table('accounts')
                ->where('users_id', $request->id)
                ->update([
                    'current_balance'=> $amount,
                    'updated_at'=> $amount
                ]);
            $message = "Wallet updated successfully."; 
        }else{
            $message = "Not updated.";
        }
        
        return Redirect::back()->with('message', $message);
    }

    // public function filter(Request $request)
    // {
    //     $title = array('pageTitle' => Lang::get("labels.ListingVidhanSabhas"));
    //     $name = $request->FilterBy;
    //     $param = $request->parameter;

    //     $vidhanSabhaData = array();
    //     $message = array();
    //     $errorMessage = array();
    //     $vidhan_sabhas = $this->VidhanSabha->filter($request);
    //     $vidhanSabhaData['message'] = $message;
    //     $vidhanSabhaData['vidhan_sabhas'] = $vidhan_sabhas;
    //     $result['commonContent'] = $this->Setting->commonContent();
    //     return view("admin.VidhanSabhas.index", $title)->with('result', $result)->with('vidhanSabhaData', $vidhanSabhaData)->with('name', $name)->with('param', $param);
    // }
}
