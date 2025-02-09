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
 * @property int $user_id
 * @property string|null $manager_comment
 * @property string|null $comment
 * @property int $average_rating
 * @method static \Database\Factories\QuestionResponseFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|QuestionResponse newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|QuestionResponse newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|QuestionResponse query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|QuestionResponse whereAverageRating($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|QuestionResponse whereComment($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|QuestionResponse whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|QuestionResponse whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|QuestionResponse whereManagerComment($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|QuestionResponse whereReviewCycleId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|QuestionResponse whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|QuestionResponse whereUserId($value)
 * @mixin \Eloquent
 */
class QuestionResponse extends Model
{
    /** @use HasFactory<\Database\Factories\QuestionResponseFactory> */
    use HasFactory;

    protected $fillable = ['review_id', 'question_id', 'reviewer_id', 'comment', 'rating'];

    public function questions(): BelongsTo
    {
        return $this->belongsTo(Questions::class, 'question_id');
    }
}
