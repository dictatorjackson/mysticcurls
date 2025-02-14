<?php

namespace App\Models\User;

use App\Models\Model;

class UserSettings extends Model {
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'is_fto', 'free_myos_made', 'submission_count', 'banned_at', 'ban_reason', 'birthday_setting',
        'deactivate_reason', 'deactivated_at',
        'is_fto', 'submission_count', 'banned_at', 'ban_reason', 'birthday_setting','hol_plays', 'selected_character_id',
    ];

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'user_settings';

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'banned_at'      => 'datetime',
        'deactivated_at' => 'datetime',
    ];

    /**
     * The primary key of the model.
     *
     * @var string
     */
    public $primaryKey = 'user_id';

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
}
