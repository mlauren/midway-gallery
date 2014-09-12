<?php

use Illuminate\Auth\UserTrait;
use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableTrait;
use Illuminate\Auth\Reminders\RemindableInterface;

class User extends Eloquent implements UserInterface, RemindableInterface {

	use UserTrait, RemindableTrait;

	// Adds support for remember token upgrade.
	public function getRememberToken()
	{
	    return $this->remember_token;
	}

	public function setRememberToken($value)
	{
	    $this->remember_token = $value;
	}

	public function getRememberTokenName()
	{
	    return 'remember_token';
	}


	protected $fillable = array(
		'email', 'username', 'password', 'password_temp', 'code', 'active');

	public static $rules = array(
		'email'=>'required|email|unique:users',
		'username'=>'required|alpha|min:3|unique:users',
		'password'=>'required|alpha_num|between:6,12|confirmed',
		'password_confirmation'=>'required|alpha_num|between:6,12'
	);

	public static $loginRules = array(
		 'email'=>'required|email',
		 'password'=>'required',
	);

    /**
     * Get the password for the user.
     *
     * @return string
	 */
    public function getAuthPassword()
    {
        return $this->password;
    }
	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'users';

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	protected $hidden = array('password', 'remember_token');

}
