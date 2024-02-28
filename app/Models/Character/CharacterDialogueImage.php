<?php

namespace App\Models\Character;

use DB;
use App\Models\Model;

class CharacterDialogueImage extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'character_id', 'emotion'
    ];

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'character_dialogue_images';

        /**
     * Validation rules for creation.
     *
     * @var array
     */
    public static $createRules = [
        'character_id' => 'required|integer',
        'emotion' => 'required|string',
        'image' => 'required'
    ];

    /**
     * Validation rules for updating.
     *
     * @var array
     */
    public static $updateRules = [
        'character_id' => 'required|integer',
        'emotion' => 'required|string',
    ];
    
    /**********************************************************************************************
    
        RELATIONS

    **********************************************************************************************/
    
    /**
     * Get the character associated with the dialogue info
     */
    public function character() 
    {
        return $this->belongsTo('App\Models\Character\Character');
    }

    /**********************************************************************************************
    
        ACCESSORS

    **********************************************************************************************/

    /**
     * Gets the file directory containing the model's image.
     *
     * @return string
     */
    public function getImageDirectoryAttribute()
    {
        return 'images/data/character-dialogue-images';
    }

    /**
     * Gets the file name of the model's image.
     *
     * @return string
     */
    public function getImageFileNameAttribute()
    {
        return $this->character_id . '-' . $this->emotion . '-image.png';
    }

    /**
     * Gets the path to the file directory containing the model's image.
     *
     * @return string
     */
    public function getImagePathAttribute()
    {
        return public_path($this->imageDirectory);
    }

    /**
     * Gets the URL of the model's image.
     *
     * @return string
     */
    public function getImageUrlAttribute()
    {
        return asset($this->imageDirectory . '/' . $this->imageFileName);
    }
}
