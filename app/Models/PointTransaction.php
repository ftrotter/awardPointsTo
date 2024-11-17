<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PointTransaction extends Model
{
    use HasFactory;

    protected $fillable = ['points', 'reason', 'team_member_id', 'house_team_id'];

    public function teamMember()
    {
        return $this->belongsTo(TeamMember::class);
    }

    public function houseTeam()
    {
        return $this->belongsTo(HouseTeam::class);
    }
}

