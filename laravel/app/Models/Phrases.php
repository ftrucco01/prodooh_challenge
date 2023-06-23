<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Phrases extends Model
{
    use SoftDeletes;

    protected $table = 'phrases';
    protected $fillable = ['phrase', 'background', 'avatar'];
    protected $primaryKey = 'id';
    public $timestamps = true;
    protected $dates = ['deleted_at'];

    public function images()
    {
        return $this->hasMany(Image::class, 'phrase_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}