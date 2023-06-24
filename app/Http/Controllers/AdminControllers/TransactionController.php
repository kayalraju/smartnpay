<?php

namespace App\Http\Controllers\AdminControllers;

use App\Http\Controllers\Controller;
use App\Models\Core\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Redirect;

class TransactionController extends Controller
{
    public function __construct(Setting $setting)
    {
        $this->Setting = $setting;
    }

    public function moneyTransferMdfaToMdfa(Request $request)
    {
        $title = array('pageTitle' => "Money Transfer MDFA To MDFA");
        $result['commonContent'] = $this->Setting->commonContent();
        return view("admin.MoneyTransfer.mdfa_to_mdfa", $title)->with('result', $result);
    }
}