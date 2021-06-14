<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserFormRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\JsonResponse;


class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $users = User::query()
                        ->with('roles')
                        ->when($request->has('roles') && Role::all()->contains('name', $request->roles), function ($user) use ($request){
                            return $user->whereHas('roles', function($role) use ($request) {
                                return $role->where('name', $request->roles);
                            });;
                        })
                        ->orderBy('id', 'desc')
                        ->get();

        return Inertia::render('Admin/User/Index', [
            'users' => $users
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $roles = Role::all();

        return Inertia::render('Admin/User/Form', [
            'roles' => $roles
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UserFormRequest $request)
    {
        $validated = $request->validated();

        $user = User::create($validated);

        $user->syncRoles($request->roles);

        return redirect()->route('admin.users.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = User::query()
                        ->with('roles')
                        ->find($id);
        if(!$user){
            return back();
        }
        return Inertia::render('Admin/User/Show', [
            'user' => $user
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $users = collect(User::findOrFail($id));

        $users->put('roles', array_values(User::query()->findOrFail($id)->roles->pluck('id')->toArray()));

        $roles = Role::all();

        return Inertia::render('Admin/User/Form', [
            'roles' => $roles,
            'users' => $users,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UserFormRequest $request, $id)
    {
        $validated = $request->validated();

        $user = User::findOrFail($id);

        $user->update($validated);

        $user->syncRoles($request->roles);

        return $request->wantsJson()
        ? new JsonResponse('', 200)
        : back()->with('status', 'User updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  $id, Request $request
     * @return json
     */
    public function destroy($id)
    {
        if(Auth::user()->hasRole('Super-Admin')){

            User::findOrFail($id)->delete();

            return redirect()->route('admin.users.index');
        }
    }
}
