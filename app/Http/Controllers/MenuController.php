<?php

namespace App\Http\Controllers;

use App\Models\LinkTbl;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class MenuController extends Controller
{
    public function create()
    {
        $parentMenus = LinkTbl::query()
            ->where('status', 1)
            ->where('is_parent', 1)
            ->orderBy('menu_name')
            ->get();

        return view('backoffice.menus.create', ['parentMenus' => $parentMenus]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'menu_name' => 'required|string|max:250',
            'path' => 'required|string|max:500',
            'category' => 'required|string|max:250',
            'is_parent' => 'required|integer|in:1,2',
            'parent_id' => 'nullable|integer|exists:linktbls,id',
            'status' => 'required|integer|in:1,2',
            'orders' => 'required|integer|min:1',
            'icon' => 'nullable|string|max:50',
            'permissions' => 'required|array|min:1',
            'permissions.*' => 'in:admin,manager,staff',
        ]);

        if ((int) $validated['is_parent'] === 1) {
            $validated['parent_id'] = 0;
        } elseif (empty($validated['parent_id'])) {
            return back()->withErrors([
                'parent_id' => 'Parent menu is required for sub menu.',
            ])->withInput();
        }

        $request->validate([
            'path' => [
                'required',
                Rule::unique('linktbls', 'path')->where(fn ($query) => $query->where('parent_id', (int) $validated['parent_id'])),
            ],
        ], [
            'path.unique' => 'This menu path already exists for the selected parent.',
        ]);

        $validated['permissions'] = implode(',', $validated['permissions']);

        LinkTbl::create($validated);

        return redirect()->route('menus.manage')->with('success', 'Menu created successfully.');
    }

    public function manage()
    {
        $menus = LinkTbl::query()
            ->orderBy('category')
            ->orderBy('is_parent')
            ->orderBy('orders')
            ->get();

        return view('backoffice.menus.manage', ['menus' => $menus]);
    }

    public function edit(LinkTbl $menu)
    {
        $parentMenus = LinkTbl::query()
            ->where('status', 1)
            ->where('is_parent', 1)
            ->where('id', '!=', $menu->id)
            ->orderBy('menu_name')
            ->get();

        return view('backoffice.menus.edit', [
            'menu' => $menu,
            'parentMenus' => $parentMenus,
        ]);
    }

    public function update(Request $request, LinkTbl $menu)
    {
        $validated = $request->validate([
            'menu_name' => 'required|string|max:250',
            'path' => 'required|string|max:500',
            'category' => 'required|string|max:250',
            'is_parent' => 'required|integer|in:1,2',
            'parent_id' => 'nullable|integer|exists:linktbls,id',
            'status' => 'required|integer|in:1,2',
            'orders' => 'required|integer|min:1',
            'icon' => 'nullable|string|max:50',
            'permissions' => 'required|array|min:1',
            'permissions.*' => 'in:admin,manager,staff',
        ]);

        if ((int) $validated['is_parent'] === 1) {
            $validated['parent_id'] = 0;
        } elseif (empty($validated['parent_id'])) {
            return back()->withErrors([
                'parent_id' => 'Parent menu is required for sub menu.',
            ])->withInput();
        }

        $request->validate([
            'path' => [
                'required',
                Rule::unique('linktbls', 'path')
                    ->where(fn ($query) => $query->where('parent_id', (int) $validated['parent_id']))
                    ->ignore($menu->id),
            ],
        ], [
            'path.unique' => 'This menu path already exists for the selected parent.',
        ]);

        $validated['permissions'] = implode(',', $validated['permissions']);
        $menu->update($validated);

        return redirect()->route('menus.manage')->with('success', 'Menu updated successfully.');
    }

    public function destroy(LinkTbl $menu)
    {
        $hasChildren = LinkTbl::query()->where('parent_id', $menu->id)->exists();
        if ($hasChildren) {
            return redirect()->route('menus.manage')->withErrors([
                'menu_delete' => 'Cannot delete this menu because it has sub menus.',
            ]);
        }

        $menu->delete();

        return redirect()->route('menus.manage')->with('success', 'Menu deleted successfully.');
    }

    public function getMenuCategory()
    {
        $menu_category = DB::table('linktbls')
            ->select('category')
            ->distinct()
            ->where('status', 1)
            ->get();

        return view('backoffice.common_inc.menu', ['menu_category' => $menu_category]);
    }
}
