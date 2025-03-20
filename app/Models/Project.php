<?php
namespace App\Models;

use App\Enums\ProjectStatusEnum;
use App\Models\Traits\HasUuidTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Project extends Model
{
    use SoftDeletes, HasFactory, HasUuidTrait;

    protected $fillable = [
        'uuid',
        'title',
        'status',
        'description',
        'user_id',
        'client_id',
        'deadline_at',
    ];

    protected $casts = [
        'deadline_at' => 'datetime',
        'status'      => ProjectStatusEnum::class,
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
     * Get the user that owns the project.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo The user associated with the project.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
    /**
     * Get the client that owns the project.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     * @return \App\Models\Client The client associated with the project.
     */
    public function client(): BelongsTo
    {
        return $this->belongsTo(Client::class);
    }

    public function users(): BelongsToMany{
        return $this->belongsToMany(User::class);
    }

    public function clients(): BelongsToMany
    {
        return $this->belongsToMany(Client::class);
    }
}
