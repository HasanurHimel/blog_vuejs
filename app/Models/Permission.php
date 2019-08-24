<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    protected $fillable=['name', 'permission_for_id'];

    public function permission_for(){
        return $this->belongsTo(Permission_for::class);
    }
    public function roles(){
        return $this->belongsToMany(Role::class);
    }
}
