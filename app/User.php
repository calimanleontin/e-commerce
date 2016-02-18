<?php
namespace  App;
use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
class User extends Model implements AuthenticatableContract, CanResetPasswordContract {
    use Authenticatable, CanResetPassword;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function products()
    {
        return $this->hasMany('App\Products');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function categories()
    {
        return $this->hasMany('App\Categories');
    }

    public function comments()
    {
        return $this->hasMany('App\Comments');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function cart()
    {
        return $this->hasOne('App\Cart');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function order()
    {
        return $this->hasMany('App\Orders');
    }

    /**
     * @return bool
     */
    public function is_admin()
    {
        if($this->role == 'admin')
            return true;
        return false;
    }

    /**
     * @return bool
     */
    public function is_moderator()
    {
        if($this->role == 'moderator')
            return true;
        return false;
    }

    /**
     * @return bool
     */
    public function can_create_category()
    {
        return $this->is_admin();
    }


    public function can_create_product()
    {
        if($this->is_admin() || $this->is_moderator())
            return true;
        return false;
    }

    public function profile()
    {
        return $this->hasOne('App\Profiles');
    }

}
