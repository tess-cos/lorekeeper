<?php

namespace App\Models\User;

use App\Models\EventTeam;
use App\Models\Model;

class UserSettings extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'is_fto', 'submission_count', 'banned_at', 'ban_reason', 'birthday_setting', 'selected_character_id', 'strike_count', 'team_id', 'theme_id','hol_plays'
    ];

    /**
     * The primary key of the model.
     *
     * @var string
     */
    public $primaryKey = 'user_id';

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'user_settings';

    /**
     * Dates on the model to convert to Carbon instances.
     *
     * @var array
     */
    protected $dates = ['banned_at'];

    /**********************************************************************************************

        RELATIONS

    **********************************************************************************************/

    /**
     * Get the user this set of settings belongs to.
     */
    public function user()
    {
        return $this->belongsTo('App\Models\User\User');
    }

    /**
     * Get the character the user has selected if appropriate.
     */
    public function selectedCharacter()
    {
        return $this->belongsTo('App\Models\Character\Character', 'selected_character_id')->visible();
    }

    /**
     * Get the team this set of settings belongs to.
     */
    public function team()
    {
        return $this->belongsTo(EventTeam::class, 'team_id');
    }
}
