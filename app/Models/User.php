<?php

namespace App\Models;

use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable implements JWTSubject
{
    use HasApiTokens;
    use HasFactory;
    use HasProfilePhoto;
    use Notifiable;
    use TwoFactorAuthenticatable;
    use HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'username',
        'last_name',
        'first_name',
        'password',
        'email',
        'cgu_at',
        'cgv_at',
        'birthday'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
        'cgu_at',
        'cgv_at',
    ];

    /**
     * The mutator that should appends the model.
     *
     * @var string
     */
    protected $appends = ['full_name'];


    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Get the user's full name.
     *
     * @return string
     */
    public function getFullNameAttribute()
    {
        return "{$this->first_name} {$this->last_name}";
    }

        /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }
    
    /**
     *
     */
    public function mangas()
    {
        return $this->belongsToMany(Manga::class, 'mangaka_manga', 'mangaka_id', 'manga_id');
    }

    /**
     * return user with role mangaka
     *
     *
     * @param $query
     */
    public function scopeWhereRoleIsMangaka($query)
    {
        return $query->role('Mangaka');
    }

    /**
     * return user with role reader
     *
     *
     * @param $query
     */
    public function scopeWhereRoleIsReader($query)
    {
        return $query->role('Reader');
    }

    /**
     * return user where full name
     *
     *
     * @param $query
     * @param $fullName
     */
    public function scopeWhereFullNameIs($query, $fullName)
    {
        $name = explode(' ', $fullName);
        return $query->where("first_name", $name[0])->where("last_name", $name[1]);
    }
}
