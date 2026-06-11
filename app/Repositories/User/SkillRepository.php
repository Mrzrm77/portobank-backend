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
            ->get()
            ->map(function ($skill) {
                return [
                    'id' => $skill->id,
                    'name' => $skill->skill_name,
                    'category' => $skill->category->name,
                    'level' => $skill->level
                ];
            });
    }

    public function findOrCreateSkill(string $skillName, ?string $level = null, ?int $categoryId = null)
    {
        return Skill::firstOrCreate(
            ['skill_name' => trim($skillName), 'level' => $level],
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