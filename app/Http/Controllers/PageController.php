<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\Tenant;
use App\Models\User;
use Artisan;
use Auth;
use Carbon\Carbon;
use DB;
use Illuminate\Http\Request;

class PageController extends Controller
{
    public function index()
    {
        if (!Auth::check()) {
            return view('auth.login');
        }
        return view('app');
    }

    public function login(Request $request)
    {
        $rules = [
            'email' => 'required|email|max:255',
            'password' => 'required|min:6|max:255'
        ];
        $niceNames = [
            'email' => __('lang.email'),
            'password' => __('lang.password')
        ];
        $this->validate($request, $rules, [], $niceNames);

        $auth = Auth::attempt([
            'email' => $request->email,
            'password' => $request->password
        ]);

        if ($auth) {
            return redirect()
                ->intended('/');
        }

        return back()
            ->withInput()
            ->withErrors(['email' => [__('lang.invalid_login')]]);
    }

    public function showRegister()
    {
        if (!Auth::check()) {
            return view('auth.register');
        }
        return view('app');
    }

    public function register(Request $request)
    {
        $rules = [
            'name' => 'required|string|max:60',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|min:6|max:255|confirmed',
            'active_users_limit' => 'required|min:1|max:100'
        ];
        $niceNames = [
            'name' => __('lang.name'),
            'email' => __('lang.email'),
            'password' => __('lang.password'),
            'active_users_limit' => 'Quantidade de usuários'
        ];
        $this->validate($request, $rules, [], $niceNames);

        DB::beginTransaction();

        try {
            $tenant = Tenant::create([
                'name' => $request['name'],
                'price' => $request['active_users_limit'] * 25,
                'invoice_period' => 1,
                'trial_ends_at' => Carbon::now()->addDays(14),
                'active_users_limit' => $request['active_users_limit'],
                'active' => 1
            ]);

            DB::statement('SET @tenant_id=' . $tenant->id);

            // Instala sistema por tenant
            $this->install();

            // Cria usuário administrador
            $role = Role::where([
                'name' => 'admin'
            ])->first();

            $user = User::create([
                'name' => $request['name'],
                'email' => $request['email'],
                'password' => bcrypt($request['password']),
                'role_id' => $role->id
            ]);

            DB::commit();

            Auth::loginUsingId($user->id);

            // Create custom dashboards
            Artisan::call('db:seed', ['--class' => 'UserMetricsTableSeeder', '--force' => true]);

            return redirect()
                ->intended('/');
        } catch (Exception $e) {
            DB::rollback();

            return back()
                ->withInput()
                ->withErrors(['name' => [$e->getMessage()]]);
        }
    }

    protected function install()
    {
        // seeders
        Artisan::call('db:seed', ['--class' => 'DatabaseSeeder', '--force' => true]);

        // counters
        DB::table('counters')->insert(config('flow.counters'));

        // settings
        $cs = config('settings');

        foreach ($cs as $key => $value) {
            DB::table('settings')->insert([
                'key' => $key,
                'value' => $value
            ]);
        }
    }

    public function logout()
    {
        Auth::logout();
        return redirect('/');
    }
}
