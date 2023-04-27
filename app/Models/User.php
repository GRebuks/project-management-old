<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = 'users';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'surname',
        'username',
        'birthday',
        'email',
        'password',
        'role_id',
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
    ];

    public function belongsToTeam(int $team_id): bool
    {
        return $this->participatingInTeams()->where('team_id', $team_id)->exists();
    }

    public function isTeamOwner($team_id): bool
    {
        return Team::find($team_id)->user_id === $this->id;
    }

    public function teams(): HasMany
    {
        return $this->hasMany(Team::class);
    }
    public function participatingInTeams(): BelongsToMany {
        return $this->belongsToMany(Team::class, "membership", "user_id", "team_id")
//            ->withPivot('role_id')
//            ->using(TeamUserRole::class)
//            ->as('team_role')
            ->withTimestamps();
    }

    public function projects(): MorphMany
    {
        return $this->morphMany(Project::class, 'owner');
    }
}
