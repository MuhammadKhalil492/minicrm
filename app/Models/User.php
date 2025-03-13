<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Kodeine\Metable\Metable;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use App\Models\Traits\HasUuidTrait;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable implements HasMedia
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, Metable, InteractsWithMedia, HasUuidTrait, SoftDeletes,HasRoles;
    

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

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

    protected $metaTable = 'users_meta';

    public $meta_fields = [
        'whatsapp',
        'website',
        'facebook',
        'instagram',
        'twitter',
        'youtube',
        'first_name',
        'last_name',
        'mobile',
        'phone',
        'tiktok',
        'linkedin',
        'language',
        'status',
    ];
    /**
     * Find a model by its UUID or fail.
     *
     * @param  string  $uuid
     * @return static
     *
     * @throws ModelNotFoundException
     */
    public static function findByUuidOrFail(string $uuid): self
    {
        return static::where('uuid', $uuid)->firstOrFail();
    }

    /**
     * Register media collections for the user model.
     *
     * This function sets up a media collection named 'profile_media' for storing user profile images.
     * It configures the collection to allow only a single file and sets fallback options for when no image is present.
     *
     * @return void
     */
    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('profile_media')
            ->singleFile()
            ->useFallbackUrl(asset('/images/user.png'))
            ->useFallbackPath(public_path('/images/user.png'));
    }

    /**
     * Add media conversions
     * @param  Media|null
     * @return [type]
     */
    public function registerMediaConversions(?Media $media = null): void
    {
        // Add thumb Image
        $this->addMediaConversion('thumb')
            ->nonQueued()
            ->width(150)
            ->height(150)
            ->sharpen(10)
            ->performOnCollections('profile_media');

        // Add Medium Image
        $this->addMediaConversion('medium')
            ->nonQueued()
            ->width(300)
            ->height(300)
            ->sharpen(10)
            ->performOnCollections('profile_media');
        // Add large Image
        $this->addMediaConversion('banner')
            ->nonQueued()
            ->width(1020)
            ->height(600)
            ->sharpen(10)
            ->performOnCollections('profile_media');
    }
}
