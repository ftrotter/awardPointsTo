<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HouseteamMember extends Model
{
    use HasFactory;

    protected $table = 'houseteam_members';

    protected $fillable = ['name', 'user_id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function houseteams()
    {
        return $this->belongsToMany(Houseteam::class, 'houseteam_houseteam_member', 'houseteam_member_id', 'houseteam_id')->withTimestamps();
    }

    public function pointTransactions()
    {
        return $this->hasMany(PointTransaction::class, 'houseteam_member_id');
    }

    public function getTotalPointsAttribute()
    {
        return $this->pointTransactions()->sum('points');
    }

    public function getPointsPerHouseteam()
    {
        return $this->pointTransactions()
            ->selectRaw('houseteam_id, SUM(points) as total_points')
            ->groupBy('houseteam_id')
            ->with('houseteam')
            ->get();
    }
}
