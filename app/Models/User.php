<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class User
 * 
 * @property int $id
 * @property string $firstname
 * @property string $lastname
 * @property string $login
 * @property string $email
 * @property Carbon|null $email_verified_at
 * @property string $password
 * @property string $role
 * @property string $statut
 * @property bool $actif
 * @property string|null $remember_token
 * @property int|null $updated_by
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property User|null $user
 * @property Collection|Artiste[] $artistes
 * @property Collection|Faq[] $faqs
 * @property Collection|User[] $users
 *
 * @package App\Models
 */
class User extends Model
{
	protected $table = 'users';

	protected $casts = [
		'email_verified_at' => 'datetime',
		'actif' => 'bool',
		'updated_by' => 'int'
	];

	protected $hidden = [
		'password',
		'remember_token'
	];

	protected $fillable = [
		'firstname',
		'lastname',
		'login',
		'email',
		'email_verified_at',
		'password',
		'role',
		'statut',
		'actif',
		'remember_token',
		'updated_by'
	];

	public function user()
	{
		return $this->belongsTo(User::class, 'updated_by');
	}

	public function artistes()
	{
		return $this->hasMany(Artiste::class, 'updated_by');
	}

	public function faqs()
	{
		return $this->hasMany(Faq::class, 'updated_by');
	}

	public function users()
	{
		return $this->hasMany(User::class, 'updated_by');
	}
}
