<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * 
 *
 * @property int $id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $deleted_at
 * @property string $title
 * @property string $description
 * @property bool $is_active
 * @property bool $is_complete
 * @property bool $is_peer_review
 * @property bool $is_self_review
 * @property bool $is_manager_review
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Reviews> $reviews
 * @property-read int|null $reviews_count
 * @method static \Database\Factories\ReviewCycleFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ReviewCycle newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ReviewCycle newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ReviewCycle query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ReviewCycle whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ReviewCycle whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ReviewCycle whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ReviewCycle whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ReviewCycle whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ReviewCycle whereIsComplete($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ReviewCycle whereIsManagerReview($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ReviewCycle whereIsPeerReview($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ReviewCycle whereIsSelfReview($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ReviewCycle whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ReviewCycle whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class ReviewCycle extends Model
{
    use HasFactory;

    protected $table = 'review_cycles';
    protected $fillable =['title', 'description', 'is_peer_review', 'is_self_review', 'is_manager_review', 'is_active', 'is_complete'];

    public function reviews(){
        return $this->hasMany(Reviews::class);
    }

}
