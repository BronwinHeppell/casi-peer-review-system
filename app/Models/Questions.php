<?php

namespace App\Models;
use App\Enums\UserRoles;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * 
 *
 * @property int $id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string $question
 * @property int $review_cycle_id
 * @property int $category_id
 * @property-read \App\Models\Category $category
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\QuestionResponse> $questionResponses
 * @property-read int|null $question_responses_count
 * @method static \Database\Factories\QuestionsFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Questions newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Questions newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Questions query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Questions whereCategoryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Questions whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Questions whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Questions whereQuestion($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Questions whereReviewCycleId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Questions whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Questions extends Model
{
    /** @use HasFactory<\Database\Factories\QuestionsFactory> */
    use HasFactory;

    protected $fillable = ['question', 'category_id', 'review_cycle_id'];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }
    public function questionResponses(): HasMany
    {
        return $this->hasMany(QuestionResponse::class);
    }
}
