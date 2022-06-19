<?php

namespace App\Models;

use App\Models\Website;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Post extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function website()
    {
        return $this->belongsTo(Website::class);
    }
}
