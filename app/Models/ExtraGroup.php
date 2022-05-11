<?php

namespace App\Models;

use Eloquent as Model;

/**
 * Class ExtraGroup
 * @package App\Models
 * @version April 6, 2020, 10:47 am UTC
 *
 * @property string name
 */
class ExtraGroup extends Model
{

    public $table = 'extra_groups';
    


    public $fillable = [
        'name',
        'is_singled',
        'is_required',
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'name' => 'string',
        'is_singled' => 'boolean',
        'is_required' => 'boolean',
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'name' => 'required'
    ];

    /**
     * New Attributes
     *
     * @var array
     */
    protected $appends = [
        'custom_fields',
        
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     **/
    public function extras()
    {
        return $this->hasMany(\App\Models\Extra::class, 'extra_group_id');
    }

    public function customFieldsValues()
    {
        return $this->morphMany('App\Models\CustomFieldValue', 'customizable');
    }

    public function getCustomFieldsAttribute()
    {
        $hasCustomField = in_array(static::class,setting('custom_field_models',[]));
        if (!$hasCustomField){
            return [];
        }
        $array = $this->customFieldsValues()
            ->join('custom_fields','custom_fields.id','=','custom_field_values.custom_field_id')
            ->where('custom_fields.in_table','=',true)
            ->get()->toArray();

        return convertToAssoc($array,'name');
    }

    
    
}
