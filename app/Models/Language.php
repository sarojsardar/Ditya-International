<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class Language extends Model
{
    use HasFactory, HasSlug;

    protected $fillable = [
        'name',
        'slug'
        // other fillable properties
    ];

    public function getSlugOptions() : SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('name')
            ->saveSlugsTo('slug');
    }

    public function companyDemands()
    {
        return $this->belongsToMany(CompanyDemand::class);
    }

}
