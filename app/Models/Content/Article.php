<?php

namespace App\Models\Content;

use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'content',
        'media_id',
        'title',
        'subtitle',
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [

    ];

    public function thumbnail()
    {
        return $this->belongsTo('App\Models\Content\Media', 'media_id');
    }
}
