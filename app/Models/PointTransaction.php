<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PointTransaction extends Model
{
    use HasFactory;

    protected $fillable = ['points', 'reason', 'houseteam_member_id', 'houseteam_id'];

    public function teamMember()
    {
        return $this->belongsTo(TeamMember::class);
    }

    public function houseTeam()
    {
        return $this->belongsTo(HouseTeam::class, 'houseteam_id');
    }
}
