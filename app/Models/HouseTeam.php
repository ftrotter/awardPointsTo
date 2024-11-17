<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HouseTeam extends Model
{
    use HasFactory;

    protected $table = 'houseteams';

    protected $fillable = ['name', 'user_id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function houseteamMembers()
    {
        return $this->belongsToMany(HouseteamMember::class, 'houseteam_houseteam_member')->withTimestamps();
    }

    public function pointTransactions()
    {
        return $this->hasMany(PointTransaction::class);
    }

    public function getTotalPointsAttribute()
    {
        return $this->pointTransactions()->sum('points');
    }
}
