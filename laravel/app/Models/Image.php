<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    protected $table = 'images';
    protected $fillable = ['size', 'image_url', 'phrase_id'];
    protected $primaryKey = 'id';
    public $timestamps = true;

    public function phrase()
    {
        return $this->belongsTo(Phrases::class);
    }
}
