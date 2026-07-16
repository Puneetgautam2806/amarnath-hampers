<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Collection;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        View::composer('backoffice.common_inc.menu', function ($view): void {
            $user = Auth::user();
            $role = $user?->isDeveloper() ? 'developer' : ($user?->usertype ?? 'staff');

            $allMenus = DB::table('linktbls')
                ->where('status', 1)
                ->orderBy('orders', 'asc')
                ->get();

            $visibleMenus = $this->getVisibleMenus($allMenus, $user?->id, $role);

            $parentMenus = $visibleMenus->where('is_parent', 1)->values();
            $subMenus = $visibleMenus->where('is_parent', 2)->values();

            $categories = $parentMenus
                ->pluck('category')
                ->unique()
                ->values()
                ->map(fn (string $category): object => (object) ['category' => $category]);

            $view->with([
                'categories' => $categories,
                'parent_menus' => $parentMenus,
                'sub_menus' => $subMenus,
            ]);
        });
    }

    private function getVisibleMenus(Collection $allMenus, ?int $userId, string $role): Collection
    {
        $roleAllowedIds = $allMenus
            ->filter(function ($menu) use ($role): bool {
                if ($role === 'admin' || $role === 'developer') {
                    return true;
                }

                if (empty($menu->permissions)) {
                    return true;
                }

                return in_array($role, explode(',', (string) $menu->permissions), true);
            })
            ->pluck('id')
            ->all();

        $overrides = collect();
        if ($userId) {
            $overrides = DB::table('user_menu_permissions')
                ->where('user_id', $userId)
                ->pluck('is_allowed', 'linktbl_id');
        }

        $visible = $allMenus->filter(function ($menu) use ($roleAllowedIds, $overrides): bool {
            if ($overrides->has($menu->id)) {
                return (int) $overrides->get($menu->id) === 1;
            }

            return in_array($menu->id, $roleAllowedIds, true);
        });

        // Ensure parent containers render when any child is visible.
        $requiredParentIds = $visible
            ->where('is_parent', 2)
            ->pluck('parent_id')
            ->filter(fn ($id): bool => (int) $id > 0)
            ->unique()
            ->values();

        if ($requiredParentIds->isNotEmpty()) {
            $parentContainers = $allMenus->whereIn('id', $requiredParentIds);
            $visible = $visible->merge($parentContainers);
        }

        return $visible
            ->unique('id')
            ->sortBy('orders')
            ->values();
    }
}
