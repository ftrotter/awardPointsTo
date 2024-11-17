<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TeamMember extends Model
{
    use HasFactory;

    protected $fillable = ['name'];

    public function houseTeams()
    {
        return $this->belongsToMany(HouseTeam::class)->withTimestamps();
    }

    public function pointTransactions()
    {
        return $this->hasMany(PointTransaction::class);
    }

    public function getTotalPointsAttribute()
    {
        return $this->pointTransactions()->sum('points');
    }

    public function getPointsPerHouseTeam()
    {
        return $this->pointTransactions()
            ->selectRaw('house_team_id, SUM(points) as total_points')
            ->groupBy('house_team_id')
            ->with('houseTeam')
            ->get();
    }
}

