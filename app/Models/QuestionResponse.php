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
 * @property int $review_id
 * @property int $question_id
 * @property int $reviewer_id
 * @property string|null $comment
 * @property int $rating
 * @property-read \App\Models\Questions $questions
 * @method static \Database\Factories\QuestionResponseFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|QuestionResponse newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|QuestionResponse newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|QuestionResponse query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|QuestionResponse whereComment($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|QuestionResponse whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|QuestionResponse whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|QuestionResponse whereQuestionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|QuestionResponse whereRating($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|QuestionResponse whereReviewId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|QuestionResponse whereReviewerId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|QuestionResponse whereUpdatedAt($value)
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
