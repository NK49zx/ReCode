<?php

namespace App\Policies;

use App\Models\Answer;
use App\Models\Question;
use App\Models\User;
use Illuminate\Auth\Access\Response;
use Illuminate\Auth\Access\HandlesAuthorization;

class AnswerPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     * Anyone can view answers.
     */
    public function viewAny(?User $user): bool
    {
        return true; // Anyone can view answers
    }

    /**
     * Determine whether the user can view the model.
     * Anyone can view a specific answer.
     */
    public function view(?User $user, Answer $answer): bool
    {
        return true; // Anyone can view a specific answer
    }

    /**
     * Determine whether the user can create models.
     * Only logged-in users can create answers.
     */
    public function create(User $user): bool
    {
        return $user !== null; // Only logged-in users can create answers
    }

    /**
     * Determine whether the user can update the model.
     * Only the answer author can update.
     */
    public function update(User $user, Answer $answer): bool
    {
        return $user !== null && $user->id === $answer->user_id;
    }

    /**
     * Determine whether the user can delete the model.
     * Only the answer author or the question owner can delete.
     */
    public function delete(User $user, Answer $answer): bool
    {
        return $user !== null && ($user->id === $answer->user_id || $user->id === $answer->question->user_id);
    }

    /**
     * Can the user restore the answer?
     * Not allowed for any user.
     */
    public function restore(User $user, Answer $answer): bool
    {
        return false;
    }

    /**
     * Can the user permanently delete the answer?
     * Not allowed for any user.
     */
    public function forceDelete(User $user, Answer $answer): bool
    {
        return false;
    }

    /**
     * Can the user accept this answer as correct?
     * Only the owner of the question can accept.
     */
    public function accept(User $user, Answer $answer): bool
    {
        return $user !== null && $user->id === $answer->question->user_id;
    }

    /**
     * Can the user update this answer?
     * Only the answer author can update.
     */
    public function updateAnswer(User $user, Answer $answer)
    {
        return $user->id === $answer->user_id;
    }

    /**
     * Can the user delete this answer?
     * Only the answer author can delete.
     */
    public function deleteAnswer(User $user, Answer $answer)
    {
        return $user->id === $answer->user_id;
    }

    /**
     * Can the user accept this answer for a question?
     * Only the question owner can accept answers.
     */
    public function acceptAnswer(User $user, Answer $answer, Question $question)
    {
        return $user->id === $question->user_id;
    }
}
