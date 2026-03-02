<?php

namespace App\Policies;

use App\Models\Review;
use App\Models\User;

class ReviewPolicy
{
    /**
     * Admin pode tudo
     */
    public function before(User $user, $ability)
    {
        return $user->role->name === 'A' ? true : null;
    }

    /**
     * Listar avaliações
     */
    public function viewAny(User $user)
    {
        return in_array($user->role->name, ['A','B','C']);
    }

    /**
     * Ver uma avaliação
     */
    public function view(User $user, Review $review)
    {
        // Avaliador vê apenas as suas
        if ($user->role->name === 'C') {
            return $review->reviewer_id === $user->id;
        }

        // Diretor vê avaliações da sua área
        if ($user->role->name === 'B') {
            return $review->submission
                ->thematicArea
                ->director_id === $user->id;
        }

        return false;
    }

    /**
     * Criar avaliação (avaliador)
     */
    public function create(User $user, Review $review)
    {
        return $user->role->name === 'C'
            && $review->reviewer_id === $user->id;
    }

    /**
     * Atualizar avaliação
     */
    public function update(User $user, Review $review)
    {
        return $user->role->name === 'C'
            && $review->reviewer_id === $user->id;
    }

    /**
     * Atribuir avaliador (Diretor)
     */
    public function assignReviewer(User $user, Review $review)
    {
        return $user->role->name === 'B'
            && $review->submission
                ->thematicArea
                ->director_id === $user->id;
    }

    /**
     * Deletar avaliação
     */
    public function delete(User $user, Review $review)
    {
        return $user->role->name === 'B'
            && $review->submission
                ->thematicArea
                ->director_id === $user->id;
    }
}
