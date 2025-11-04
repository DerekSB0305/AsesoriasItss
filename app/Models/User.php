<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
        protected $primaryKey = 'user_id';
        protected $fillable = ['user', 'password', 'role_id'];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function role()
    {
         return $this->belongsTo(Role::class, 'role_id', 'id');
    }

    public function administrative()
    {
         return $this->hasOne(Administrative::class, 'user', 'administrative_user');
    }

    public function teacher()
    {
         return $this->hasOne(Teacher::class, 'teacher_user', 'user');
    }

    public function student()
    {
         return $this->hasOne(Student::class, 'user', 'enrollment');
    }
}
