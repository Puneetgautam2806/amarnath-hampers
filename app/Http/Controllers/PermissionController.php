<?php

namespace App\Http\Controllers;

use App\Models\LinkTbl;
use App\Models\User;
use App\Models\UserMenuPermission;
use Illuminate\Http\Request;

class PermissionController extends Controller
{
    public function index()
    {
        $users = User::query()->orderBy('name')->get();

        return view('backoffice.permissions.index', ['users' => $users]);
    }

    public function editUser(User $user)
    {
        $menus = LinkTbl::query()
            ->where('status', 1)
            ->orderBy('is_parent')
            ->orderBy('orders')
            ->get();

        $overrides = UserMenuPermission::query()
            ->where('user_id', $user->id)
            ->pluck('is_allowed', 'linktbl_id');

        return view('backoffice.permissions.user', [
            'selectedUser' => $user,
            'menus' => $menus,
            'overrides' => $overrides,
        ]);
    }

    public function updateUser(Request $request, User $user)
    {
        $validated = $request->validate([
            'allowed' => 'array',
            'denied' => 'array',
            'allowed.*' => 'integer|exists:linktbls,id',
            'denied.*' => 'integer|exists:linktbls,id',
        ]);

        $allowedIds = collect($validated['allowed'] ?? [])->map(fn ($id) => (int) $id)->all();
        $deniedIds = collect($validated['denied'] ?? [])->map(fn ($id) => (int) $id)->all();

        if (! empty(array_intersect($allowedIds, $deniedIds))) {
            return back()->withErrors([
                'permissions' => 'A module cannot be both allowed and denied.',
            ])->withInput();
        }

        UserMenuPermission::query()->where('user_id', $user->id)->delete();

        foreach ($allowedIds as $menuId) {
            UserMenuPermission::create([
                'user_id' => $user->id,
                'linktbl_id' => $menuId,
                'is_allowed' => 1,
            ]);
        }

        foreach ($deniedIds as $menuId) {
            UserMenuPermission::create([
                'user_id' => $user->id,
                'linktbl_id' => $menuId,
                'is_allowed' => 2,
            ]);
        }

        return redirect()->route('permissions.editUser', $user)->with('success', 'Permissions updated successfully.');
    }
}
