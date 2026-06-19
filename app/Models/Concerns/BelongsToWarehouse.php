<?php

namespace App\Models\Concerns;

use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

trait BelongsToWarehouse
{
    protected static function bootBelongsToWarehouse(): void
    {
        static::addGlobalScope('warehouse', function (Builder $builder) {
            if (Auth::check() && Auth::user()?->role === 'warehouse') {
                $builder->where(
                    $builder->getModel()->getTable() . '.user_id',
                    Auth::id()
                );
            }
        });

        static::creating(function ($model) {
            if (! empty($model->user_id)) {
                return;
            }

            if (Auth::check() && Auth::user()?->role === 'warehouse') {
                $model->user_id = Auth::id();
                return;
            }

            if (app()->runningInConsole()) {
                $oldWarehouseId = self::oldWarehouseIdForConsoleSeed();

                if ($oldWarehouseId) {
                    $model->user_id = $oldWarehouseId;
                }
            }
        });
    }

    public function warehouse()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    protected static function oldWarehouseIdForConsoleSeed(): ?int
    {
        try {
            if (! Schema::hasTable('users')) {
                return null;
            }

            $id = DB::table('users')
                ->where('email', 'oldwarehouse@fridaystore.vn')
                ->value('id');

            return $id ? (int) $id : null;
        } catch (\Throwable $e) {
            return null;
        }
    }
}
