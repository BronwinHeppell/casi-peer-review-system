<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * 
 *
 * @property int $id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int $review_cycle_id
 * @property int $user_id
 * @property string|null $manager_comment
 * @property string|null $comment
 * @property string $average_rating
 * @property-read \App\Models\ReviewCycle $reviewCycle
 * @property-read \App\Models\User $user
 * @property-read \Illuminate\Database\Eloquent\Collection<int, UserRatings> $userRatings
 * @property-read int|null $user_ratings_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserRatings newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserRatings newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserRatings query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserRatings whereAverageRating($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserRatings whereComment($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserRatings whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserRatings whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserRatings whereManagerComment($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserRatings whereReviewCycleId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserRatings whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserRatings whereUserId($value)
 * @mixin \Eloquent
 */
class UserRatings extends Model
{
    protected $fillable = [
        'review_cycle_id',
        'user_id',
        'manager_comment',
        'comment',
        'average_rating',
    ];

    public function reviewCycle(): BelongsTo
    {
        return $this->belongsTo(ReviewCycle::class, 'review_cycle_id', 'id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function userRatings(): hasMany
    {
        return $this->hasMany(UserRatings::class);
    }
}
