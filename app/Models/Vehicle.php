<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Mode;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
// use Psy\Util\Str;
use Illuminate\Support\Str;
use PhpParser\Node\Expr\FuncCall;


class Vehicle extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'slug',
        'thumbnail',
        'about',
        'price',
        'duration',
        'horse_power',
        'cc',
        'is_popular',
        'category_id',
    ];

    public function SetNameAttribute($value){
        $this->attributes['name']-> $value;
        $this->attributes['slug']-> Str::slug($value);
    }

    public function category(): BelongsTo{
        return $this->belongsTo(Category::class);
    }

    public function photo(): hasMany{
        return $this->hasMany(VehiclePhoto::class);
    }

    public function testimonials(): HasMany{
        return $this->hasMany(Testimonial::class);
    }
}
