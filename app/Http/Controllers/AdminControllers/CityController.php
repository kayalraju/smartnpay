<?php

namespace App\Http\Controllers\AdminControllers;

use App\Http\Controllers\Controller;
use App\Models\Core\City;
use App\Models\Core\State;
use App\Models\Core\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Redirect;

class CityController extends Controller
{
    public function __construct(Setting $setting, City $city, State $state)
    {
        $this->City = $city;
        $this->State = $state;
        $this->Setting = $setting;
    }
    public function index(Request $request)
    {
        $title = array('pageTitle' => Lang::get("labels.ListingCities"));
        $cityData = array();
        $message = array();
        $errorMessage = array();
        $cities = $this->City->paginator();
        $cityData['message'] = $message;
        $cityData['cities'] = $cities;
        $result['commonContent'] = $this->Setting->commonContent();
        return view("admin.cities.index", $title)->with('result', $result)->with('cityData', $cityData);
    }

    public function add(Request $request)
    {
        $title = array('pageTitle' => Lang::get("labels.AddCity"));
        $result['commonContent'] = $this->Setting->commonContent();
        $stateData['states'] = $this->State->getstates();
        return view("admin.cities.add", $title)->with('result', $result)->with('stateData', $stateData);
    }

    public function insert(Request $request)
    {
        $title = array('pageTitle' => Lang::get("labels.EditCity"));
        $cities_id = $this->City->insert($request);
        $message = Lang::get("labels.CityAddedMessage");
        return Redirect::back()->with('message', $message);
    }

    public function edit($id)
    {
        $title = array('pageTitle' => Lang::get("labels.EditCity"));
        $city = $this->City->edit($id);
        $stateData['states'] = $this->State->getstates();
        $result['commonContent'] = $this->Setting->commonContent();
        return view("admin.cities.edit", $title)->with('result', $result)->with('city', $city)->with('stateData', $stateData);;
    }

    public function update(Request $request)
    {
        $this->City->updaterecord($request);
        $message = Lang::get("labels.CityUpdatedMessage");
        return Redirect::back()->with('message', $message);
    }

    public function delete(Request $request)
    {
        $this->City->deleterecord($request);
        return redirect()->back()->withErrors([Lang::get("labels.CityDeletedMessage")]);
    }

    public function filter(Request $request)
    {
        $title = array('pageTitle' => Lang::get("labels.ListingCities"));
        $name = $request->FilterBy;
        $param = $request->parameter;

        $cityData = array();
        $message = array();
        $errorMessage = array();
        $cities = $this->City->filter($request);
        $cityData['message'] = $message;
        $cityData['cities'] = $cities;
        $result['commonContent'] = $this->Setting->commonContent();
        return view("admin.cities.index", $title)->with('result', $result)->with('cityData', $cityData)->with('name', $name)->with('param', $param);
    }
}
