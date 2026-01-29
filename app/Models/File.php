<?php

namespace App\Models;

use App\Traits\HasCreatorAndUpdator;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Kalnoy\Nestedset\NodeTrait;

class File extends Model
{
    use HasCreatorAndUpdator, HasFactory,NodeTrait,SoftDeletes;

    public function isOwnedBy($userId): bool
    {
        return $this->created_by === $userId;
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function parent(): BelongsTo
    {
        return $this->belongsTo(File::class, 'parent_id');
    }

    public function owner(): Attribute
    {
        return Attribute::make(
            get: fn ($value, $attributes) => $attributes['created_by'] == Auth::id() ? 'Me' : $this->user->name
        );
    }

    public function storagePath(): string
    {
        return $this->storage_path;
    }

    public function isRoot(): bool
    {
        return $this->parent_id === null;
    }

    public function get_file_size()
    {
        $unit = ['B', 'KB', 'MB', 'GB', 'TB'];
        $power = $this->size > 0 ? floor(log($this->size, 1024)) : 0;

        return number_format($this->size / pow(1024, $power), 2).' '.$unit[$power];
    }

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            if (! $model->parent) {
                return;
            }
            $model->path = (! $model->parent->isRoot() ? $model->parent->path.'/' : '').Str::slug($model->name);
        });
        // static::deleted(function (file $model) {
        //     if (! $model->is_folder) {

        //         Storage::delete($model->storage_path);
        //     }
        // });
    }
}
