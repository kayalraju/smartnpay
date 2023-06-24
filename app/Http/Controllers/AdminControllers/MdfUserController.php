<?php

namespace App\Http\Controllers\AdminControllers;

use App\Http\Controllers\Controller;
use App\Models\Core\MdfUser;
use App\Models\Core\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Redirect;
use App\Models\Core\State;
use App\Models\Core\District;
use App\Models\Core\VidhanSabha;
use App\Models\Core\AccountType;

class MdfUserController extends Controller
{
    public function __construct(Setting $setting, MdfUser $mdfUser, State $state, District $district, VidhanSabha $vidhanSabha, AccountType $accountType)
    {
        $this->MdfUser = $mdfUser;
        $this->Setting = $setting;
        $this->State = $state;
        $this->District = $district;
        $this->VidhanSabha = $vidhanSabha;
        $this->AccountType = $accountType;
    }
    public function index(Request $request)
    {
        $title = array('pageTitle' => Lang::get("labels.ListingMdfUsers"));
        $mdfUserData = array();
        $message = array();
        $errorMessage = array();
        $mdfUsers = $this->MdfUser->paginator();
        $mdfUserData['message'] = $message;
        $mdfUserData['mdfUsers'] = $mdfUsers;
        $result['commonContent'] = $this->Setting->commonContent();
        return view("admin.mdfUsers.index", $title)->with('result', $result)->with('mdfUserData', $mdfUserData);
    }

    public function add(Request $request)
    {
        $title = array('pageTitle' => Lang::get("labels.AddMdfUser"));
        $result['commonContent'] = $this->Setting->commonContent();
        $stateData['states'] = $this->State->getstates();
        $accountTypesData['accountTypes'] = $this->AccountType->getaccounttypes("MDF");
        return view("admin.mdfUsers.add", $title)->with('result', $result)
        ->with('stateData', $stateData)
        ->with('accountTypesData', $accountTypesData);
    }

    public function insert(Request $request)
    {
        $title = array('pageTitle' => Lang::get("labels.EditMdfUser"));
        $mdf_users_id = $this->MdfUser->insert($request);
        $message = Lang::get("labels.MdfUserAddedMessage");
        return Redirect::back()->with('message', $message);
    }

    public function edit($id)
    {
        $title = array('pageTitle' => Lang::get("labels.EditMdfUser"));
        $mdfUser = $this->MdfUser->edit($id);
        $stateData['states'] = $this->State->getstates();
        $districtData['districts'] = $this->District->getdistricts($mdfUser->states_id);
        $vidhanSabhaData['vidhanSabhas'] = $this->VidhanSabha->getvidhansabhas($mdfUser->districts_id);
        $accountTypesData['accountTypes'] = $this->AccountType->getaccounttypes("MDF");
        $result['commonContent'] = $this->Setting->commonContent();
        return view("admin.mdfUsers.edit", $title)->with('result', $result)
        ->with('mdfUser', $mdfUser)
        ->with('stateData', $stateData)
        ->with('districtData', $districtData)
        ->with('vidhanSabhaData', $vidhanSabhaData)
        ->with('accountTypesData', $accountTypesData);
    }

    public function update(Request $request)
    {
        $this->MdfUser->updaterecord($request);
        $message = Lang::get("labels.MdfUserUpdatedMessage");
        return Redirect::back()->with('message', $message);
    }

    public function delete(Request $request)
    {
        $this->MdfUser->deleterecord($request);
        return redirect()->back()->withErrors([Lang::get("labels.MdfUserDeletedMessage")]);
    }

    public function filter(Request $request)
    {
        $title = array('pageTitle' => Lang::get("labels.ListingMdfUsers"));
        $name = $request->FilterBy;
        $param = $request->parameter;

        $mdfUserData = array();
        $message = array();
        $errorMessage = array();
        $mdfUsers = $this->MdfUser->filter($request);
        $mdfUserData['message'] = $message;
        $mdfUserData['mdfUsers'] = $mdfUsers;
        $result['commonContent'] = $this->Setting->commonContent();
        return view("admin.mdfUsers.index", $title)
        ->with('result', $result)
        ->with('mdfUserData', $mdfUserData)
        ->with('name', $name)
        ->with('param', $param);
    }
    public function changeStatusMdfUser(Request $request)
    {
        DB::table('users')->where('id', $request->user_id)->update([
			'status' => $request->status
		]);
		return true;
    }
}
