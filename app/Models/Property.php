<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Property extends Model
{
    use HasFactory;
    protected $guarded = ['id'];
    protected $table = 'properties';

    /**
     * Get the property type associated with the property.
     */
    public function propertyType()
    {
        return $this->belongsTo(PropertyType::class, 'property_type_id');
    }

    /**
     * Get the images associated with the property.
     */
    public function images()
    {
        return $this->hasMany(PropertyAttachments::class, 'property_id');
    }
}
