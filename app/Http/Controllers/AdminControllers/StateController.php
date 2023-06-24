<?php

namespace App\Http\Controllers\AdminControllers;

use App\Http\Controllers\Controller;
use App\Models\Core\State;
use App\Models\Core\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Redirect;

class StateController extends Controller
{
    public function __construct(Setting $setting, State $state)
    {
        $this->State = $state;
        $this->Setting = $setting;
    }
    public function index(Request $request)
    {
        $title = array('pageTitle' => Lang::get("labels.ListingStates"));
        $stateData = array();
        $message = array();
        $errorMessage = array();
        $states = $this->State->paginator();
        $stateData['message'] = $message;
        $stateData['states'] = $states;
        $result['commonContent'] = $this->Setting->commonContent();
        return view("admin.states.index", $title)->with('result', $result)->with('stateData', $stateData);
    }

    public function add(Request $request)
    {
        $title = array('pageTitle' => Lang::get("labels.AddState"));
        $result['commonContent'] = $this->Setting->commonContent();
        return view("admin.states.add", $title)->with('result', $result);
    }

    public function insert(Request $request)
    {
        $title = array('pageTitle' => Lang::get("labels.EditState"));
        $states_id = $this->State->insert($request);
        $message = Lang::get("labels.StateAddedMessage");
        return Redirect::back()->with('message', $message);
    }

    public function edit($id)
    {
        $title = array('pageTitle' => Lang::get("labels.EditState"));
        $state = $this->State->edit($id);
        $result['commonContent'] = $this->Setting->commonContent();
        return view("admin.states.edit", $title)->with('result', $result)->with('state', $state);
    }

    public function update(Request $request)
    {
        $this->State->updaterecord($request);
        $message = Lang::get("labels.StateUpdatedMessage");
        return Redirect::back()->with('message', $message);
    }

    public function delete(Request $request)
    {
        $this->State->deleterecord($request);
        return redirect()->back()->withErrors([Lang::get("labels.StateDeletedMessage")]);
    }

    public function filter(Request $request)
    {
        $title = array('pageTitle' => Lang::get("labels.ListingStates"));
        $name = $request->FilterBy;
        $param = $request->parameter;

        $stateData = array();
        $message = array();
        $errorMessage = array();
        $states = $this->State->filter($request);
        $stateData['message'] = $message;
        $stateData['states'] = $states;
        $result['commonContent'] = $this->Setting->commonContent();
        return view("admin.states.index", $title)->with('result', $result)->with('stateData', $stateData)->with('name', $name)->with('param', $param);
    }
}
