<?php
namespace App\Models;

use App\Models\Traits\HasUuidTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Client extends Model
{
    /** @use HasFactory<\Database\Factories\ClietFactory> */
    use HasFactory, HasUuidTrait, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'uuid',
        'contact_name',
        'contact_email',
        'phone',
        'company_name',
        'company_address',
        'company_city',
        'company_zip',
        'company_vat',
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
     * Get the projects associated with the client.
     *
     * @return BelongsToMany The relationship instance between clients and projects.
     */
    public function projects(): BelongsToMany
    {
        return $this->belongsToMany(Project::class, 'client_projects');
    }
}
