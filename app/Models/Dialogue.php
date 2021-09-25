<?php

namespace App\Models;

use Auth;

use App\Models\Model;

use App\Models\User\User;

class Dialogue extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'dialogue', 'speaker_name', 'speaker_id', 'speaker_type', 'parent_id'
    ];

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'dialogues';

    /**
     * Whether the model contains timestamps to be saved and updated.
     *
     * @var string
     */
    public $timestamps = false;


    /**********************************************************************************************
    
        RELATIONS

    **********************************************************************************************/

    /**
     * Get the parent dialogue
     */
    public function parent() 
    {
        return $this->belongsTo('App\Models\Dialogue', 'parent_id');
    }

    /**
     * Get the children dialogues
     */
    public function children() 
    {
        return $this->hasMany('App\Models\Dialogue', 'parent_id');
    }

    /**
     * Get the speaker if set
     */
    public function speaker() 
    {
        if(isset($this->speaker_id)) {
            if($this->speaker_type == 'Character') return $this->belongsTo('App\Models\Character\Character', 'speaker_id');
            elseif($this->speaker_type == 'User')  return $this->belongsTo('App\Models\User\User', 'speaker_id');
            elseif($this->speaker_type == 'Response') return Auth::user();
        }
        else 
            // Laravel requires a relationship instance to be returned (cannot return null), so returning one that doesn't exist here.
            return $this->belongsTo('App\Models\Loot\Loot', 'rewardable_id', 'loot_table_id')->whereNull('loot_table_id');
    }

    /**********************************************************************************************
    
        ATTRIBUTES

    **********************************************************************************************/

    /**
     * returns the speakers image
     */
    public function getImageAttribute()
    {
        if(!isset($this->speaker_type) && !isset($this->speaker_id)) return null;
        if($this->speaker_type == 'Narration') return null;

        if($this->speaker_type == 'Character') {
            return $this->speaker->image->thumbnailUrl;
        }
        elseif($this->speaker_type == 'Response') {
            return '/images/avatars/'.Auth::user()->avatar;
        }
        else return '/images/avatars/'. $this->speaker->avatar;
    }

    /**
     * returns the speaker's username
     */
    public function getDisplayNameAttribute()
    {
        if($this->speaker_name != 'Username') return $this->speaker_name;
        else return Auth::user()->displayname;
    }
}
