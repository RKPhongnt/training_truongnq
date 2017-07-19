<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'address', 'username', 'is_admin', 'is_active', 'division_id'
    ];

    /**
        * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];
    
    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'is_admin' => 'boolean',
        'is_active' => 'boolean'
    ];

    /**get the division user belongs to
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */

    public function division() {
        return $this->belongsTo('App\Division', 'division_id','id');
    }
}
