<?php

namespace App\Http\Controllers\AdminControllers;

use App\Http\Controllers\Controller;
use App\Models\Core\VidhanSabha;
use App\Models\Core\District;
use App\Models\Core\State;
use App\Models\Core\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Redirect;

class VidhanSabhaController extends Controller
{
    public function __construct(Setting $setting, VidhanSabha $vidhanSabha, District $district, State $state)
    {
        $this->VidhanSabha = $vidhanSabha;
        $this->District = $district;
        $this->State = $state;
        $this->Setting = $setting;
    }
    public function index(Request $request)
    {
        $title = array('pageTitle' => Lang::get("labels.ListingVidhanSabhas"));
        $vidhanSabhaData = array();
        $message = array();
        $errorMessage = array();
        $vidhan_sabhas = $this->VidhanSabha->paginator();
        $vidhanSabhaData['message'] = $message;
        $vidhanSabhaData['vidhan_sabhas'] = $vidhan_sabhas;
        $result['commonContent'] = $this->Setting->commonContent();
        return view("admin.VidhanSabhas.index", $title)->with('result', $result)->with('vidhanSabhaData', $vidhanSabhaData);
    }

    public function add(Request $request)
    {
        $title = array('pageTitle' => Lang::get("labels.AddVidhanSabha"));
        $result['commonContent'] = $this->Setting->commonContent();
        $stateData['states'] = $this->State->getstates();
        return view("admin.VidhanSabhas.add", $title)->with('result', $result)->with('stateData', $stateData);
    }

    public function insert(Request $request)
    {
        $title = array('pageTitle' => Lang::get("labels.EditVidhanSabha"));
        $vidhan_sabhas_id = $this->VidhanSabha->insert($request);
        $message = Lang::get("labels.VidhanSabhaAddedMessage");
        return Redirect::back()->with('message', $message);
    }

    public function edit($id)
    {
        $title = array('pageTitle' => Lang::get("labels.EditVidhanSabha"));
        $vidhanSabha = $this->VidhanSabha->edit($id);
        $stateData['states'] = $this->State->getstates();
        $districtData['districts'] = $this->District->getdistrictsbystate($vidhanSabha->states_id);
        $result['commonContent'] = $this->Setting->commonContent();
        return view("admin.VidhanSabhas.edit", $title)
        ->with('result', $result)
        ->with('vidhanSabha', $vidhanSabha)
        ->with('stateData', $stateData)
        ->with('districtData', $districtData);
    }

    public function update(Request $request)
    {
        $this->VidhanSabha->updaterecord($request);
        $message = Lang::get("labels.VidhanSabhaUpdatedMessage");
        return Redirect::back()->with('message', $message);
    }

    public function delete(Request $request)
    {
        $this->VidhanSabha->deleterecord($request);
        return redirect()->back()->withErrors([Lang::get("labels.VidhanSabhaDeletedMessage")]);
    }

    public function filter(Request $request)
    {
        $title = array('pageTitle' => Lang::get("labels.ListingVidhanSabhas"));
        $name = $request->FilterBy;
        $param = $request->parameter;

        $vidhanSabhaData = array();
        $message = array();
        $errorMessage = array();
        $vidhan_sabhas = $this->VidhanSabha->filter($request);
        $vidhanSabhaData['message'] = $message;
        $vidhanSabhaData['vidhan_sabhas'] = $vidhan_sabhas;
        $result['commonContent'] = $this->Setting->commonContent();
        return view("admin.VidhanSabhas.index", $title)->with('result', $result)->with('vidhanSabhaData', $vidhanSabhaData)->with('name', $name)->with('param', $param);
    }

    public function getvidhansabhas(Request $request)
    {
        $getVidhanSabhas = array();
        $getVidhanSabhas = DB::table('vidhan_sabhas')->where('districts_id', $request->district_id)->get();
        if (count($getVidhanSabhas) > 0) {
            $responseData = array('success' => '1', 'data' => $getVidhanSabhas, 'message' => "Returned all states.");
        } else {
            $responseData = array('success' => '0', 'data' => $getVidhanSabhas, 'message' => "Returned all states.");
        }
        $vidhanSabhaResponse = json_encode($responseData);
        print $vidhanSabhaResponse;
    }
}
