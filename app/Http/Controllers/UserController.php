<?php

namespace App\Http\Controllers;

use App\Enums\UserRole;
use App\Enums\UserStatus;
use App\Http\Requests\SaveUserRequest;
use App\Models\User;

class UserController extends Controller
{
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
        // redirect with the default status if no status is provided
        if (request()->input('status') === null) {
            return redirect()->route('users.index', [
                'status' => UserStatus::ACTIVE
            ]);
        }

        $users = User::query()
            ->filter(request()->all())
            ->search(request()->input('search'))
            ->withCount(['tickets'])
            // TODO: later implement this to show only relevant tickets
            // ->withCount([
            //     'tickets as open_tickets_count' => function (Builder $query) {
            //         $query->inProgress();
            //     },
            // ])
            ->latest('id')
            ->paginate()
            ->withQueryString();

        return inertia('Users/Index', [
            'users' => $users,
            'filters' => [
                'role' => UserRole::values(),
                'status' => UserStatus::values(),
            ]
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
            'recentTickets' => $user->tickets()->with('device')->take(5)->get(),
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
