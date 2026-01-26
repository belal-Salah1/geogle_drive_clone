<?php

namespace App\Models;

use App\Traits\HasCreatorAndUpdator;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Kalnoy\Nestedset\NodeTrait;

class File extends Model
{
    use HasCreatorAndUpdator, HasFactory,NodeTrait,SoftDeletes;

    public function isOwnedBy($userId): bool
    {
        return $this->created_by === $userId;
    }

    // protected $fillable = [
    //     'name',
    //     'path',
    //     'is_folder',
    //     'mime',
    //     'size',
    //     'created_by',
    //     'updated_by',
    //     'parent_id',
    //     '_lft',
    //     '_rgt',
    // ];
}
