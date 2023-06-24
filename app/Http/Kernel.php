<?php

namespace App\Http;

use Illuminate\Foundation\Http\Kernel as HttpKernel;

class Kernel extends HttpKernel
{
    /**
     * The application's global HTTP middleware stack.
     *
     * These middleware are run during every request to your application.
     *
     * @var array<int, class-string|string>
     */
    protected $middleware = [
        // \App\Http\Middleware\TrustHosts::class,
        \App\Http\Middleware\TrustProxies::class,
        \Fruitcake\Cors\HandleCors::class,
        \App\Http\Middleware\PreventRequestsDuringMaintenance::class,
        \Illuminate\Foundation\Http\Middleware\ValidatePostSize::class,
        \App\Http\Middleware\TrimStrings::class,
        \Illuminate\Foundation\Http\Middleware\ConvertEmptyStringsToNull::class,
    ];

    /**
     * The application's route middleware groups.
     *
     * @var array<string, array<int, class-string|string>>
     */
    protected $middlewareGroups = [
        'web' => [
            \App\Http\Middleware\EncryptCookies::class,
            \Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse::class,
            \Illuminate\Session\Middleware\StartSession::class,
            // \Illuminate\Session\Middleware\AuthenticateSession::class,
            \Illuminate\View\Middleware\ShareErrorsFromSession::class,
            \App\Http\Middleware\VerifyCsrfToken::class,
            \Illuminate\Routing\Middleware\SubstituteBindings::class,
        ],

        'api' => [
            \Laravel\Sanctum\Http\Middleware\EnsureFrontendRequestsAreStateful::class,
            'throttle:api',
            \Illuminate\Routing\Middleware\SubstituteBindings::class,
        ],
    ];

    /**
     * The application's route middleware.
     *
     * These middleware may be assigned to groups or used individually.
     *
     * @var array<string, class-string|string>
     */
    protected $routeMiddleware = [
        'auth' => \App\Http\Middleware\Authenticate::class,
        'admin' => \App\Http\Middleware\RedirectIfNotAdmin::class,
        'auth.basic' => \Illuminate\Auth\Middleware\AuthenticateWithBasicAuth::class,
        'cache.headers' => \Illuminate\Http\Middleware\SetCacheHeaders::class,
        'can' => \Illuminate\Auth\Middleware\Authorize::class,
        'guest' => \App\Http\Middleware\RedirectIfAuthenticated::class,
        'password.confirm' => \Illuminate\Auth\Middleware\RequirePassword::class,
        'signed' => \Illuminate\Routing\Middleware\ValidateSignature::class,
        'throttle' => \Illuminate\Routing\Middleware\ThrottleRequests::class,
        'verified' => \Illuminate\Auth\Middleware\EnsureEmailIsVerified::class,

        'dashboard' => \App\Http\Middleware\dashboard\dashboard::class,

        'view_state' => \App\Http\Middleware\state\view_state::class,
        'edit_state' => \App\Http\Middleware\state\edit_state::class,
        'delete_state' => \App\Http\Middleware\state\delete_state::class,
        'add_state' => \App\Http\Middleware\state\add_state::class,

        'view_district' => \App\Http\Middleware\district\view_district::class,
        'edit_district' => \App\Http\Middleware\district\edit_district::class,
        'delete_district' => \App\Http\Middleware\district\delete_district::class,
        'add_district' => \App\Http\Middleware\district\add_district::class,

        'view_vidhan_sabha' => \App\Http\Middleware\vidhan_sabha\view_vidhan_sabha::class,
        'edit_vidhan_sabha' => \App\Http\Middleware\vidhan_sabha\edit_vidhan_sabha::class,
        'delete_vidhan_sabha' => \App\Http\Middleware\vidhan_sabha\delete_vidhan_sabha::class,
        'add_vidhan_sabha' => \App\Http\Middleware\vidhan_sabha\add_vidhan_sabha::class,

        'view_mdf_user' => \App\Http\Middleware\mdf_user\view_mdf_user::class,
        'edit_mdf_user' => \App\Http\Middleware\mdf_user\edit_mdf_user::class,
        'add_mdf_user' => \App\Http\Middleware\mdf_user\add_mdf_user::class,
        'change_status_mdf_user' => \App\Http\Middleware\mdf_user\change_status_mdf_user::class,
        
        'view_wallet' => \App\Http\Middleware\wallet\view_wallet::class,
        'edit_wallet' => \App\Http\Middleware\wallet\edit_wallet::class,

        'view_media' => \App\Http\Middleware\media\view_media::class,
        'edit_media' => \App\Http\Middleware\media\edit_media::class,
        'delete_media' => \App\Http\Middleware\media\delete_media::class,
        'add_media' => \App\Http\Middleware\media\add_media::class,

        'view_news' => \App\Http\Middleware\news\view_news::class,
        'edit_news' => \App\Http\Middleware\news\edit_news::class,
        'delete_news' => \App\Http\Middleware\news\delete_news::class,
        'add_news' => \App\Http\Middleware\news\add_news::class,

        'slider_view' => \App\Http\Middleware\sliders\slider_view::class,
        'slider_create' => \App\Http\Middleware\sliders\slider_create::class,
        'slider_update' => \App\Http\Middleware\sliders\slider_update::class,
        'slider_delete' => \App\Http\Middleware\sliders\slider_delete::class,

        'view_manage_admin' => \App\Http\Middleware\manage_admin\view_manage_admin::class,
        'edit_manage_admin' => \App\Http\Middleware\manage_admin\edit_manage_admin::class,
        'delete_manage_admin' => \App\Http\Middleware\manage_admin\delete_manage_admin::class,
        'add_manage_admin' => \App\Http\Middleware\manage_admin\add_manage_admin::class,

        'view_admin_type' => \App\Http\Middleware\admin_type\view_admin_type::class,
        'edit_admin_type' => \App\Http\Middleware\admin_type\edit_admin_type::class,
        'delete_admin_type' => \App\Http\Middleware\admin_type\delete_admin_type::class,
        'add_admin_type' => \App\Http\Middleware\admin_type\add_admin_type::class,

        'manage_role' => \App\Http\Middleware\manage_role\manage_role::class,
    ];
}
