<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'is_active',
        'profile_photo',
        'author_request_status',
        'author_requested_at',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'is_active' => 'boolean',
        'author_requested_at' => 'datetime',
    ];

    /**
     * Check if user is admin
     */
    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    /**
     * Check if user is author
     */
    public function isAuthor(): bool
    {
        return $this->role === 'author';
    }

    /**
     * Check if user is guest
     */
    public function isGuest(): bool
    {
        return $this->role === 'guest';
    }

    /**
     * Check if user can publish posts
     */
    public function canPublish(): bool
    {
        return in_array($this->role, ['admin', 'author']);
    }

    /**
     * Check if user can moderate
     */
    public function canModerate(): bool
    {
        return $this->role === 'admin';
    }

    /**
     * Get the posts for the user.
     */
    public function posts()
    {
        return $this->hasMany(Post::class);
    }

    /**
     * Get the comments for the user.
     */
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    /**
     * Get the profile photo URL
     */
    public function getProfilePhotoUrlAttribute()
    {
        if ($this->profile_photo) {
            return asset('storage/' . $this->profile_photo);
        }

        // Generate a default avatar with initials
        return 'https://ui-avatars.com/api/?name=' . urlencode($this->name) . '&color=7F9CF5&background=EBF4FF&size=200';
    }

    /**
     * Check if user can request author status
     */
    public function canRequestAuthor()
    {
        return $this->role === 'guest' && $this->author_request_status === 'none';
    }

    /**
     * Check if user has pending author request
     */
    public function hasPendingAuthorRequest()
    {
        return $this->author_request_status === 'pending';
    }

    /**
     * Request author status
     */
    public function requestAuthorStatus()
    {
        $this->update([
            'author_request_status' => 'pending',
            'author_requested_at' => now(),
        ]);
    }

    /**
     * Approve author request
     */
    public function approveAuthorRequest()
    {
        $this->update([
            'role' => 'author',
            'author_request_status' => 'approved',
        ]);
    }

    /**
     * Reject author request
     */
    public function rejectAuthorRequest()
    {
        $this->update([
            'author_request_status' => 'rejected',
        ]);
    }
}
