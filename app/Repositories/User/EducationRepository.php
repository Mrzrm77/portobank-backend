<?php

namespace App\Repositories\User;

use App\Models\Education;
use App\Models\User;

class EducationRepository
{
    public function getByUser(User $user)
    {
        return $user->educations()->latest()->get();
    }

    public function create(User $user, array $data)
    {
        return $user->educations()->create($data);
    }

    public function update(Education $education, array $data)
    {
        $education->update($data);
        return $education;
    }

    public function delete(Education $education)
    {
        return $education->delete();
    }

    public function findById($id)
    {
        return Education::findOrFail($id);
    }
}