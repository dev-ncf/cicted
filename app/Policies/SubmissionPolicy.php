<?php

namespace App\Policies;

use App\Models\Submission;
use App\Models\User;

class SubmissionPolicy
{
    /**
     * Admin pode tudo
     */
    public function before(User $user, $ability)
    {
        return $user->role->name === 'A' ? true : null;
    }

    /**
     * Listar submissões
     */
    public function viewAny(User $user)
    {
        return in_array($user->role->name, ['A','B','C','D']);
    }

    /**
     * Ver uma submissão específica
     */
    public function view(User $user, Submission $submission)
    {
        switch ($user->role->name) {

            // Autor vê apenas o que é dele
            case 'D':
                return $submission->author_id === $user->id;

            // Diretor vê apenas da sua área temática
            case 'B':
                return $submission->thematicArea->director_id === $user->id;

            // Avaliador vê apenas se estiver atribuído
            case 'C':
                return $submission->reviews()
                    ->where('reviewer_id', $user->id)
                    ->exists();
        }

        return false;
    }

    /**
     * Criar submissão (Autor)
     */
    public function create(User $user)
    {
        return $user->role->name === 'D';
    }

    /**
     * Atualizar submissão
     * Autor só antes de avaliação
     */
    public function update(User $user, Submission $submission)
    {
        if ($user->role->name === 'D') {
            return $submission->author_id === $user->id
                && $submission->status === 'em_avaliacao';
        }

        return false;
    }

    /**
     * Diretor pode mudar status
     */
    public function changeStatus(User $user, Submission $submission)
    {
        return $user->role->name === 'B'
            && $submission->thematicArea->director_id === $user->id;
    }

    /**
     * Deletar submissão
     */
    public function delete(User $user, Submission $submission)
    {
        return $user->role->name === 'D'
            && $submission->author_id === $user->id
            && $submission->status === 'em_avaliacao';
    }
}
