<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Phrases extends Model
{
    protected $table = 'phrases';
    protected $fillable = ['phrase', 'background', 'avatar', 'user_id'];
    protected $primaryKey = 'id';
    public $timestamps = true;

    public function images()
    {
        return $this->hasMany(Image::class, 'phrase_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}