<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Team extends Model
{
    use HasFactory;
    protected $table = "team";
    protected $fillable = [
        'name',
        'description',
        'public',
    ];

    public function isOwnedByLoggedUser(): bool
    {
        return $this->owner->id === auth()->id();
    }

    public function getParticipants(): Collection
    {
        return $this->participants()->get();
    }

    public function owner(): BelongsTo
    {
        return $this->belongsTo(User::class, "user_id");
    }

    public function participants(): BelongsToMany
    {
        return $this->belongsToMany(User::class, "membership", "team_id", "user_id")
//            ->withPivot('role_id')
//            ->using(TeamUserRole::class)
//            ->as('team_role')
            ->withTimestamps();
    }
}
