<?php

namespace App\Models\Content;

use Illuminate\Database\Eloquent\Model;

class Media extends Model
{
    protected $table = 'media';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'path',
        'type',
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [

    ];

    public function articles()
    {
        return $this->hasMany('App\Models\Content\Article');
    }
}
