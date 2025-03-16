<?php

namespace App\Http\Middleware;

use App\Models\Access;
use App\Models\RoleAccess;
use App\Models\UserRole;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Session;
use Symfony\Component\HttpFoundation\Response;

class CheckRoleAccessMiddleware
{
	/**
	 * Handle an incoming request.
	 *
	 * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
	 */
	public function handle(Request $request, Closure $next): Response
	{
		$session = auth();

		$request->session()->forget('user_access');
		if ($session->check()) {


			$user_roles = UserRole::where('user_uuid', $session->user()->uuid)->get();

			$role_uuid = [];
			$permission_user = [];

			if (!@$user_roles) {
				return redirect('logout');
			} else {
				foreach ($user_roles as $role) {
					$role_uuid[] = $role->role_uuid;
				}
			}


			$accesses = Access::all();
			$role_accesses = RoleAccess::whereIn('role_uuid', $role_uuid)->with('access')->get();


			$gates = [];

			foreach ($role_accesses as $key => $value) {
				# code...
				$gates[] = $value->access->name;
			}

			foreach ($accesses as $acc) {
				// print_r(in_array($acc->uuid, $role_accesses->pluck('access_uuid')->toArray()) ? 'true' : 'false');
				Gate::define($acc->name, function () use ($acc, $role_accesses) {
					return in_array($acc->uuid, $role_accesses->pluck('access_uuid')->toArray());
				});
			}

			Session::put('user_access', $gates);
		} else {
			return redirect('login');
		}


		return $next($request);
	}
}
