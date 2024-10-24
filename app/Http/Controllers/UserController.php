<?php

namespace App\Http\Controllers;

use App\Enums\UserRole;
use App\Enums\UserStatus;
use App\Http\Requests\SaveUserRequest;
use App\Models\User;
use App\Queries\UserQuery;
use Illuminate\Routing\Controller;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class UserController extends Controller
{
    use AuthorizesRequests;

    /**
     * Create the controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        /**
         * The authorizeResource method will automatically authorize all the
         * resource methods, using the given model and the method name as the
         * ability name. 
         * 
         * index -> viewAny
         * create -> create
         * store -> create
         * show -> view
         * edit -> update
         * update -> update
         * destroy -> delete
         */
        $this->authorizeResource(User::class, 'user');
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return inertia('Users/Index', [
            'users' => (new UserQuery)->paginate(),
            'filters' => UserQuery::filters(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return $this->edit(new User());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(SaveUserRequest $request)
    {
        // TODO: after creating a new user, send an email with the dummy password
        // he must change it on first login and verify his email address
        return $this->update($request, new User());
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        return inertia('Users/Show', [
            'user' => $user,
            'recentTickets' => $user->assignedTickets()->with('device')->take(5)->get(),
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        return inertia('Users/Edit', [
            'user' => $user,
            'roleOptions' => UserRole::values(),
            'statusOptions' => UserStatus::values(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(SaveUserRequest $request, User $user)
    {
        $params = $request->validated();

        $user->fill($params)->save();

        return redirect()
            ->route('users.show', $user->id)
            ->with('status', __('record saved'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        $user->delete();

        return redirect()
            ->route('users.index')
            ->with('status', __('record deleted'));
    }
}
