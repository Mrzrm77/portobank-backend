<?php

namespace App\Repositories\User;

use App\Models\Skill;

class SkillRepository
{
    public function getUserSkills($user)
    {
        return $user->profile
            ->skills()
            ->orderBy('skill_name')
            ->get();
    }

    public function findOrCreateSkill(string $skillName, ?int $categoryId = null)
    {
        return Skill::firstOrCreate(
            ['skill_name' => trim($skillName)],
            ['category_id' => $categoryId]
        );
    }

    public function findSkill(int $skillId)
    {
        return Skill::findOrFail($skillId);
    }

    public function attachSkill($profile, $skill)
    {
        $profile->skills()
            ->syncWithoutDetaching([$skill->id]);

        return $skill;
    }

    public function detachSkill($profile, int $skillId)
    {
        $profile->skills()
            ->detach($skillId);
    }
}