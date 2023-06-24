<?php

namespace App\Http\Controllers\AdminControllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Lang;
use App\Models\Core\Setting;
use App\Models\Core\Directory;
use App\Models\Core\Admin;
use App\Models\Core\State;
use App\Models\Core\District;
use App\Models\Core\VidhanSabha;
use Validator;
use Hash;
use Auth;

class AdminController extends Controller
{
	public function __construct(Setting $setting, Directory $directory, Admin $admin, State $state, District $district, VidhanSabha $vidhanSabha)
	{
		$this->Setting = $setting;
		$this->Directory = $directory;
		$this->Admin = $admin;
		$this->State = $state;
        $this->District = $district;
        $this->VidhanSabha = $vidhanSabha;
	}

	public function login()
	{
		if (Auth::check()) {
			// echo "dashboard";
			// exit;
			return redirect('/admin/dashboard/this_month');
		} else {
			$title = array('pageTitle' => Lang::get("labels.login_page_name"));
			return view("admin.login", $title);
		}
	}

	//login function
	public function checkLogin(Request $request)
	{
		$validator = Validator::make(
			array(
				'email' => $request->email,
				'password' => $request->password
			),
			array(
				'email' => 'required | email',
				'password' => 'required',
			)
		);
		//check validation
		if ($validator->fails()) {
			return redirect('admin/login')->withErrors($validator)->withInput();
		} else {
			//check authentication of email and password
			$adminInfo = array("email" => $request->email, "password" => $request->password, "status" => 1);

			if (auth()->attempt($adminInfo)) {
				$admin = auth()->user();

				$administrators = DB::table('users')->where('id', $admin->myid)->get();



				$categories_id = '';
				//admin category role
				if (auth()->user()->adminType != '1') {
					$categories_role = DB::table('categories_role')->where('admin_id', auth()->user()->myid)->get();
					if (!empty($categories_role) and count($categories_role) > 0) {
						$categories_id = $categories_role[0]->categories_ids;
					} else {
						$categories_id = '';
					}
				}

				session(['categories_id' => $categories_id]);
				return redirect()->intended('admin/dashboard/this_month')->with('administrators', $administrators);
			} else {
				return redirect('admin/login')->with('loginError', Lang::get("labels.EmailPasswordIncorrectText"));
			}
		}
	}

	//logout
	public function logout()
	{
		Auth::logout();
		return redirect('/admin/login');
	}

	// Dashboard
	public function dashboard(Request $request)
	{
		$title = array('pageTitle' => Lang::get("labels.title_dashboard"));
		$language_id = '1';

		$result = array();

		$reportBase = $request->reportBase;


		$result['commonContent'] = $this->Setting->commonContent();

		return view("admin.dashboard", $title)->with('result', $result);
	}

	//admins
	public function admins(Request $request)
	{

		$title = array('pageTitle' => Lang::get("labels.ListingCustomers"));
		$language_id = '1';

		$result = array();
		$message = array();
		$errorMessage = array();

		$admins = $this->Admin->paginator();


		$result['message'] = $message;
		$result['errorMessage'] = $errorMessage;
		$result['admins'] = $admins;
		$result['commonContent'] = $this->Setting->commonContent();

		return view("admin.admins.index", $title)->with('result', $result);

	}

	//add admins
	public function addadmins(Request $request)
	{

		$title = array('pageTitle' => Lang::get("labels.addadmin"));

		$result = array();
		$message = array();
		$errorMessage = array();

		//get function from ManufacturerController controller
		$result['states'] = $this->State->getstates();
		$adminTypes = DB::table('user_types')->where('isActive', 1)->where('user_types_id', '>', '10')->get();
		$result['adminTypes'] = $adminTypes;
		$result['commonContent'] = $this->Setting->commonContent();

		return view("admin.admins.add", $title)->with('result', $result);

	}

	//addnewadmin
	public function addnewadmin(Request $request)
	{

		//get function from other controller
		$myVar = new SiteSettingController();
		$extensions = $myVar->imageType();

		$result = array();
		$message = array();
		$errorMessage = array();

		//check email already exists
		$existEmail = DB::table('users')->where('email', '=', $request->email)->get();
		if (count($existEmail) > 0) {
			$errorMessage = Lang::get("labels.Email address already exist");
			return redirect()->back()->with('errorMessage', $errorMessage);
		} else {

			$uploadImage = '';
			$admins = $this->Admin->insert($request);
			

			$message = Lang::get("labels.New admin has been added successfully");
			return redirect()->back()->with('message', $message);

		}
	}
	//editadmin
	public function editadmin(Request $request)
	{

		$title = array('pageTitle' => Lang::get("labels.EditAdmin"));
		$myid = $request->id;

		$result = array();
		$message = array();
		$errorMessage = array();

		//get function from other controller
		$adminTypes = DB::table('user_types')->where('isActive', 1)->where('user_types_id', '>', '10')->get();
		$result['adminTypes'] = $adminTypes;
		$result['myid'] = $myid;
		$admins = DB::table('users')->where('id', '=', $myid)->get();
		$result['admins'] = $admins;
        $result['states'] = $this->State->getstates();
        $result['districts'] = $this->District->getdistricts($admins[0]->states_id);
        $result['vidhanSabhas'] = $this->VidhanSabha->getvidhansabhas($admins[0]->districts_id);
		$result['commonContent'] = $this->Setting->commonContent();
		return view("admin.admins.edit", $title)->with('result', $result);
	}

	//update admin
	public function updateadmin(Request $request)
	{

		//get function from other controller
		$myVar = new SiteSettingController();
		$extensions = $myVar->imageType();
		$myid = $request->myid;
		$result = array();
		$message = array();
		$errorMessage = array();

		//check email already exists
		$existEmail = DB::table('users')->where([['email', '=', $request->email], ['id', '!=', $myid]])->get();
		if (count($existEmail) > 0) {
			$errorMessage = Lang::get("labels.Email address already exist");
			return redirect()->back()->with('errorMessage', $errorMessage);
		} else {

			$uploadImage = '';
			$admins = $this->Admin->updaterecord($request);
			$message = Lang::get("labels.Admin has been updated successfully");
			return redirect()->back()->with('message', $message);
		}

	}

	public function profile(Request $request)
	{

		$title = array('pageTitle' => Lang::get("labels.Profile"));
		$result = array();
		$images = new Images;
		$allimage = $images->getimages();
		$result['admin'] = $this->Admin->edit(auth()->user()->id);
		$countries = DB::table('countries')->get();
		$zones = DB::table('zones')->where('zone_country_id', '=', $result['admin']->entry_country_id)->get();
		$result['countries'] = $countries;
		$result['zones'] = $zones;
		$result['commonContent'] = $this->Setting->commonContent();
		return view("admin.admin.profile", $title)->with('result', $result)->with('allimage', $allimage);
	}

	public function update(Request $request)
	{
		$validator = Validator::make(
			array(
				'first_name' => $request->first_name,
				'last_name' => $request->last_name,
				'address' => $request->address,
				'phone' => $request->phone,
				'city' => $request->city,
				'country' => $request->first_name,
				'zip' => $request->zip
			),
			array(
				'first_name' => 'required',
				'last_name' => 'required',
				'address' => 'required',
				'phone' => 'required',
				'city' => 'required',
				'country' => 'required',
				'zip' => 'required'
			)
		);
		if ($validator->fails()) {
			return redirect()->back()->withErrors($validator)->withInput();
		}

		$update = $this->Admin->updaterecord($request);
		$message = Lang::get("labels.ProfileUpdateMessage");
		return redirect()->back()->with(['success' => $message]);
	}

	public function updatepassword(Request $request)
	{
		$update = $this->Admin->updatepassword($request);
		$message = Lang::get("labels.PasswordUpdateMessage");
		return redirect()->back()->withErrors([$message]);
	}

	//deleteProduct
	public function deleteadmin(Request $request)
	{

		$myid = $request->myid;

		DB::table('users')->where('id', '=', $myid)->delete();

		return redirect()->back()->withErrors([Lang::get("labels.DeleteAdminMessage")]);

	}

	//manageroles
	public function manageroles(Request $request)
	{

		$title = array('pageTitle' => Lang::get("labels.manageroles"));
		$language_id = '1';

		$result = array();
		$message = array();
		$errorMessage = array();

		$adminTypes = DB::table('user_types')->where('user_types_id', '>', '10')->paginate(50);

		$result['message'] = $message;
		$result['errorMessage'] = $errorMessage;
		$result['adminTypes'] = $adminTypes;
		$result['commonContent'] = $this->Setting->commonContent();

		return view("admin.admins.roles.manageroles", $title)->with('result', $result);

	}


	//add admins type
	public function addadmintype(Request $request)
	{
		$title = array('pageTitle' => Lang::get("labels.addadmintype"));

		$result = array();
		$message = array();
		$errorMessage = array();

		//get function from ManufacturerController controller
		$myVar = new AddressController();
		$result['countries'] = $myVar->getAllCountries();

		$adminTypes = DB::table('user_types')->where('isActive', 1)->get();
		$result['adminTypes'] = $adminTypes;
		$result['commonContent'] = $this->Setting->commonContent();

		return view("admin.admins.roles.addadmintype", $title)->with('result', $result);
	}

	//addnewtype
	public function addnewtype(Request $request)
	{

		$result = array();
		$message = array();
		$errorMessage = array();

		$customers_id = DB::table('user_types')->insertGetId([
			'user_types_name' => $request->user_types_name,
			'created_at' => time(),
			'isActive' => $request->isActive,
		]);

		$message = Lang::get("labels.Admin type has been added successfully");
		return redirect()->back()->with('message', $message);

	}


	//editadmintype
	public function editadmintype(Request $request)
	{
		$title = array('pageTitle' => Lang::get("labels.EditAdminType"));
		$user_types_id = $request->id;

		$result = array();

		$result['user_types_id'] = $user_types_id;

		$user_types = DB::table('user_types')->where('user_types_id', '=', $user_types_id)->get();

		$result['user_types'] = $user_types;
		$result['commonContent'] = $this->Setting->commonContent();
		return view("admin.admins.roles.editadmintype", $title)->with('result', $result);
	}

	//updatetype
	public function updatetype(Request $request)
	{

		$result = array();
		$message = array();
		$errorMessage = array();

		$customers_id = DB::table('user_types')->where('user_types_id', $request->user_types_id)->update([
			'user_types_name' => $request->user_types_name,
			'updated_at' => time(),
			'isActive' => $request->isActive,
		]);


		$message = Lang::get("labels.Admin type has been updated successfully");
		return redirect()->back()->with('message', $message);

	}


	//deleteProduct
	public function deleteadmintype(Request $request)
	{

		$user_types_id = $request->user_types_id;

		DB::table('user_types')->where('user_types_id', '=', $user_types_id)->delete();

		return redirect()->back()->withErrors([Lang::get("labels.DeleteAdminTypeMessage")]);

	}
	//managerole
	public function addrole(Request $request)
	{


		$title = array('pageTitle' => Lang::get("labels.EditAdminType"));
		$result = array();
		$user_types_id = $request->id;
		$result['user_types_id'] = $user_types_id;

		$adminType = DB::table('user_types')->where('user_types_id', $user_types_id)->get();
		$result['adminType'] = $adminType;

		$roles = DB::table('manage_role')->where('user_types_id', '=', $user_types_id)->get();

		if (count($roles) > 0) {
			$dashboard_view = $roles[0]->dashboard_view;

			$news_view = $roles[0]->news_view;
			$news_create = $roles[0]->news_create;
			$news_update = $roles[0]->news_update;
			$news_delete = $roles[0]->news_delete;

			$media_view = $roles[0]->view_media;
			$media_create = $roles[0]->add_media;
			$media_update = $roles[0]->edit_media;
			$media_delete = $roles[0]->delete_media;

			$manage_admins_view = $roles[0]->manage_admins_view;
			$manage_admins_create = $roles[0]->manage_admins_create;
			$manage_admins_update = $roles[0]->manage_admins_update;
			$manage_admins_delete = $roles[0]->manage_admins_delete;


			$profile_view = $roles[0]->profile_view;
			$profile_update = $roles[0]->profile_update;

			$admintype_view = $roles[0]->admintype_view;
			$admintype_create = $roles[0]->admintype_create;
			$admintype_update = $roles[0]->admintype_update;
			$admintype_delete = $roles[0]->admintype_delete;
			$manage_admins_role = $roles[0]->manage_admins_role;

		} else {
			$dashboard_view = '0';

			$media_view = '0';
			$media_create = '0';
			$media_update = '0';
			$media_delete = '0';

			$news_view = '0';
			$news_create = '0';
			$news_update = '0';
			$news_delete = '0';

			$manage_admins_view = '0';
			$manage_admins_create = '0';
			$manage_admins_update = '0';
			$manage_admins_delete = '0';

			$profile_view = '0';
			$profile_update = '0';

			$admintype_view = '0';
			$admintype_create = '0';
			$admintype_update = '0';
			$admintype_delete = '0';
			$manage_admins_role = '0';
		}


		$result2[0]['link_name'] = 'dashboard';
		$result2[0]['permissions'] = array('0' => array('name' => 'dashboard_view', 'value' => $dashboard_view));

		$result2[4]['link_name'] = 'news';
		$result2[4]['permissions'] = array(
			'0' => array('name' => 'news_view', 'value' => $news_view),
			'1' => array('name' => 'news_create', 'value' => $news_create),
			'2' => array('name' => 'news_update', 'value' => $news_update),
			'3' => array('name' => 'news_delete', 'value' => $news_delete)
		);

		$result2[16]['link_name'] = 'manage_admins';
		$result2[16]['permissions'] = array(
			'0' => array('name' => 'manage_admins_view', 'value' => $manage_admins_view),
			'1' => array('name' => 'manage_admins_create', 'value' => $manage_admins_create),
			'2' => array('name' => 'manage_admins_update', 'value' => $manage_admins_update),
			'3' => array('name' => 'manage_admins_delete', 'value' => $manage_admins_delete)
		);

		$result2[18]['link_name'] = 'profile';
		$result2[18]['permissions'] = array(
			'0' => array('name' => 'profile_view', 'value' => $profile_view),
			'1' => array('name' => 'profile_update', 'value' => $profile_update)
		);


		$result2[19]['link_name'] = 'Admin Types';
		$result2[19]['permissions'] = array(
			'0' => array('name' => 'admintype_view', 'value' => $admintype_view),
			'1' => array('name' => 'admintype_create', 'value' => $admintype_create),
			'2' => array('name' => 'admintype_update', 'value' => $admintype_update),
			'3' => array('name' => 'admintype_delete', 'value' => $admintype_delete),
			'4' => array('name' => 'manage_admins_role', 'value' => $manage_admins_role)
		);

		$result2[20]['link_name'] = 'Media';
		$result2[20]['permissions'] = array(
			'0' => array('name' => 'media_view', 'value' => $media_view),
			'1' => array('name' => 'media_create', 'value' => $media_create),
			'2' => array('name' => 'media_update', 'value' => $media_update),
			'3' => array('name' => 'media_delete', 'value' => $media_delete),
		);

		$result['data'] = $result2;
		$result['commonContent'] = $this->Setting->commonContent();
		return view("admin.admins.roles.addrole", $title)->with('result', $result);

	}

	//addnewroles
	public function addnewroles(Request $request)
	{

		$user_types_id = $request->user_types_id;
		DB::table('manage_role')->where('user_types_id', $user_types_id)->delete();

		$roles = DB::table('manage_role')->where('user_types_id', $request->user_types_id)->insert([
			'user_types_id' => $request->user_types_id,
			'dashboard_view' => $request->dashboard_view,

			'view_media' => $request->media_view,
			'add_media' => $request->media_create,
			'edit_media' => $request->media_update,
			'delete_media' => $request->media_delete,

			'news_view' => $request->news_view,
			'news_create' => $request->news_create,
			'news_update' => $request->news_update,
			'news_delete' => $request->news_delete,

			'manage_admins_view' => $request->manage_admins_view,
			'manage_admins_create' => $request->manage_admins_create,
			'manage_admins_update' => $request->manage_admins_update,
			'manage_admins_delete' => $request->manage_admins_delete,

			'profile_view' => $request->profile_view,
			'profile_update' => $request->profile_update,

			'admintype_view' => $request->admintype_view,
			'admintype_create' => $request->admintype_create,
			'admintype_update' => $request->admintype_update,
			'admintype_delete' => $request->admintype_delete,
			'manage_admins_role' => $request->manage_admins_role

		]);

		$message = Lang::get("labels.Roles has been added successfully");
		return redirect()->back()->with('message', $message);

	}


	//managerole
	public function categoriesroles(Request $request)
	{
		$title = array('pageTitle' => Lang::get("labels.CategoriesRoles"));
		$result = array();
		$language_id = 1;

		$categories_role = DB::table('users')->join('categories_role', 'categories_role.admin_id', '=', 'users.role_id')->where('users.role_id', '!=', '1')->get();

		$data = array();
		$index = 0;
		foreach ($categories_role as $categories) {
			array_push($data, $categories);
			$cat_array = explode(',', $categories->categories_ids);
			$categories_descrtiption = DB::table('categories_description')->whereIn('categories_id', $cat_array)->where('language_id', $language_id)->get();
			$data[$index++]->description = $categories_descrtiption;
		}

		$result['data'] = $data;
		$result['commonContent'] = $this->Setting->commonContent();
		return view("admin.admins.roles.category.index", $title)->with('result', $result);
	}

	//addCategoriesRoles
	public function addCategoriesRoles(Request $request)
	{

		$title = array('pageTitle' => Lang::get("labels.AddCategoriesRoles"));
		$result = array();
		$language_id = 1;
		$categories_role = DB::table('categories_role')->get();

		//get function from other controller
		$myVar = new AdminCategoriesController();
		$result['categories'] = $myVar->allCategories($language_id);

		$result['admins'] = DB::table('users')->where('role_id', '!=', '1')->get();

		$result['data'] = $categories_role;
		$result['commonContent'] = $this->Setting->commonContent();
		return view("admin.admins.roles.category.add", $title)->with('result', $result);

	}

	//addCategoriesRoles
	public function addNewCategoriesRoles(Request $request)
	{


		$title = array('pageTitle' => Lang::get("labels.AddCategoriesRoles"));
		$result = array();

		$language_id = 1;

		$exist = DB::table('categories_role')->where('admin_id', $request->admin_id)->get();

		if (count($exist) > 0) {
			return redirect()->back()->with('error', Lang::get("labels.AlreadyCategoryAssignToadmin"));
		} else {

			$categories = array();
			foreach ($request->categories as $category) {
				$categories[] = $category;
			}

			$categories = implode(',', $categories);

			$roles = DB::table('categories_role')->insert([
				'categories_ids' => $categories,
				'admin_id' => $request->admin_id,
			]);

			return redirect()->back()->with('success', Lang::get("labels.CategoryRolesAddedSucceccfully"));
		}

	}

	//editCategoriesRoles
	public function editCategoriesRoles(Request $request)
	{

		$title = array('pageTitle' => Lang::get("labels.AddCategoriesRoles"));
		$result = array();
		$language_id = 1;

		//get function from other controller
		$myVar = new AdminCategoriesController();
		$result['categories'] = $myVar->allCategories($language_id);

		$categories_role = DB::table('categories_role')->where('categories_role_id', $request->id)->get();

		$result['admins'] = DB::table('users')->where('role_id', '!=', '1')->get();

		$result['data'] = $categories_role;
		$result['commonContent'] = $this->Setting->commonContent();

		return view("admin.admins.roles.category.edit", $title)->with('result', $result);


	}

	//updatecategoriesroles
	public function updatecategoriesroles(Request $request)
	{
		$result = array();

		$categories = array();
		foreach ($request->categories as $category) {
			$categories[] = $category;
		}
		print_r($request->admin_id);
		$categories = implode(',', $categories);

		$roles = DB::table('categories_role')->where('categories_role_id', $request->categories_role_id)->update([
			'categories_ids' => $categories,
		]);

		return redirect()->back()->with('success', Lang::get("labels.CategoryRolesUpdatedSucceccfully"));
	}

	//deleteCountry
	public function deletecategoriesroles(Request $request)
	{
		DB::table('categories_role')->where('categories_role_id', $request->id)->delete();
		return redirect()->back()->withErrors([Lang::get("labels.AdminRemoveCategoryMessage")]);
	}
}