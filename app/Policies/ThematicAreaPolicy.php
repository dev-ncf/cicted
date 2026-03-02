<?php

namespace App\Policies;

use App\Models\ThematicArea;
use App\Models\User;

class ThematicAreaPolicy
{
    /**
     * Admin pode tudo
     */
    
    public function before(User $user, $ability)
    {
        return $user->role->name === 'A' ? true : null;
    }

    /**
     * Listar áreas
     */
    public function viewAny(User $user)
    {
        return in_array($user->role->name, ['A','B']);
    }

    /**
     * Ver área
     */
    public function view(User $user, ThematicArea $area)
    {
        return $user->role->name === 'B'
            && $area->director_id === $user->id;
    }

    /**
     * Criar área
     */
    public function create(User $user)
    {
        return $user->role->name === 'A';
    }

    /**
     * Atualizar área
     */
    public function update(User $user, ThematicArea $area)
    {
        return $user->role->name === 'A';
    }

    /**
     * Deletar área
     */
    public function delete(User $user, ThematicArea $area)
    {
        return $user->role->name === 'A';
    }
}
