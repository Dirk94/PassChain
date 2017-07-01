<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


/**
 * App\Password
 *
 * @property int $id
 * @property string $url
 * @property string $username
 * @property string $password
 * @property int $user_id
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Password whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Password whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Password wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Password whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Password whereUrl($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Password whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Password whereUsername($value)
 * @mixin \Eloquent
 */
class Password extends Model {

    protected $fillable = [
        'url', 'username', 'password'
    ];

    protected $guarded = [
        'user_id'
    ];

    public function user() {
        return $this->belongsTo('App\User');
    }
}
