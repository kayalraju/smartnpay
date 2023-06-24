<?php

namespace App\Http\Controllers\AdminControllers;

use App\Http\Controllers\Controller;
use App\Models\Core\District;
use App\Models\Core\State;
use App\Models\Core\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Redirect;

class DistrictController extends Controller
{
    public function __construct(Setting $setting, District $district, State $state)
    {
        $this->District = $district;
        $this->State = $state;
        $this->Setting = $setting;
    }
    public function index(Request $request)
    {
        $title = array('pageTitle' => Lang::get("labels.ListingDistricts"));
        $districtData = array();
        $message = array();
        $errorMessage = array();
        $districts = $this->District->paginator();
        $districtData['message'] = $message;
        $districtData['districts'] = $districts;
        $result['commonContent'] = $this->Setting->commonContent();
        return view("admin.districts.index", $title)->with('result', $result)->with('districtData', $districtData);
    }

    public function add(Request $request)
    {
        $title = array('pageTitle' => Lang::get("labels.AddDistrict"));
        $result['commonContent'] = $this->Setting->commonContent();
        $stateData['states'] = $this->State->getstates();
        return view("admin.districts.add", $title)->with('result', $result)->with('stateData', $stateData);
    }

    public function insert(Request $request)
    {
        $title = array('pageTitle' => Lang::get("labels.EditDistrict"));
        $districts_id = $this->District->insert($request);
        $message = Lang::get("labels.DistrictAddedMessage");
        return Redirect::back()->with('message', $message);
    }

    public function edit($id)
    {
        $title = array('pageTitle' => Lang::get("labels.EditDistrict"));
        $district = $this->District->edit($id);
        $stateData['states'] = $this->State->getstates();
        $result['commonContent'] = $this->Setting->commonContent();
        return view("admin.districts.edit", $title)->with('result', $result)->with('district', $district)->with('stateData', $stateData);
    }

    public function update(Request $request)
    {
        $this->District->updaterecord($request);
        $message = Lang::get("labels.DistrictUpdatedMessage");
        return Redirect::back()->with('message', $message);
    }

    public function delete(Request $request)
    {
        $this->District->deleterecord($request);
        return redirect()->back()->withErrors([Lang::get("labels.DistrictDeletedMessage")]);
    }

    public function filter(Request $request)
    {
        $title = array('pageTitle' => Lang::get("labels.ListingDistricts"));
        $name = $request->FilterBy;
        $param = $request->parameter;

        $districtData = array();
        $message = array();
        $errorMessage = array();
        $districts = $this->District->filter($request);
        $districtData['message'] = $message;
        $districtData['districts'] = $districts;
        $result['commonContent'] = $this->Setting->commonContent();
        return view("admin.districts.index", $title)->with('result', $result)->with('districtData', $districtData)->with('name', $name)->with('param', $param);
    }

    public function getdistricts(Request $request)
    {
        $getDistricts = array();
        $getDistricts = DB::table('districts')->where('states_id', $request->state_id)->get();
        if (count($getDistricts) > 0) {
            $responseData = array('success' => '1', 'data' => $getDistricts, 'message' => "Returned all states.");
        } else {
            $responseData = array('success' => '0', 'data' => $getDistricts, 'message' => "Returned all states.");
        }
        $districtResponse = json_encode($responseData);
        print $districtResponse;
    }
}
