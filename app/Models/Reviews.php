<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * 
 *
 * @property int $id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int $review_cycle_id
 * @property int|null $reviewer_id
 * @property int|null $reviewee_id
 * @property bool $is_reviewed
 * @property float|null $average_rating
 * @property-read \App\Models\ReviewCycle $reviewCycle
 * @property-read \App\Models\User|null $reviewee
 * @property-read \App\Models\User|null $reviewer
 * @method static \Database\Factories\ReviewsFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Reviews newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Reviews newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Reviews query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Reviews whereAverageRating($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Reviews whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Reviews whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Reviews whereIsReviewed($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Reviews whereReviewCycleId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Reviews whereRevieweeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Reviews whereReviewerId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Reviews whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Reviews extends Model
{
    /** @use HasFactory<\Database\Factories\ReviewsFactory> */
    use HasFactory;

    protected $fillable = ['review_cycle_id', 'reviewer_id', 'reviewee_id', 'comment', 'manager_feedback', 'average_rating', 'is_reviewed'];

    public function reviewCycle(): BelongsTo
    {
        return $this->belongsTo(ReviewCycle::class, 'review_cycle_id', 'id');
    }

    public function reviewer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'reviewer_id');
    }

    public function reviewee(): BelongsTo
    {
        return $this->belongsTo(User::class, 'reviewee_id');
    }
}
