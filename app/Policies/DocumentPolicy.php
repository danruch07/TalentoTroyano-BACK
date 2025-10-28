<?php

namespace App\Policies;

use App\Models\Document;
use App\Models\User;

class DocumentPolicy
{
    public function view(User $user, Document $doc): bool
    {
        if ($user->role === 'admin') return true;
        if ($doc->owner_user_id === $user->id) return true;

        // Permitir a la empresa ver CVs de postulaciones a sus vacantes (si ya existe Application->Vacancy->company_id)
        if ($user->role === 'company' && $doc->application && $doc->application->vacancy->company_id === $user->id) {
            return true;
        }

        return false;
    }

    public function download(User $user, Document $doc): bool
    {
        return $this->view($user, $doc);
    }

    public function delete(User $user, Document $doc): bool
    {
        if ($user->role === 'admin') return true;
        // El dueño puede borrar su propio documento
        return $doc->owner_user_id === $user->id;
    }

    public function upload(User $user): bool
    {
        // Cualquier usuario autenticado puede subir su propio CV
        return in_array($user->role, ['student','company','admin'], true);
    }
}
