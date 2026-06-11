<?php

namespace App\Services\User;

use App\Repositories\User\SkillRepository;

class SkillService
{
    protected $repo;

    public function __construct(
        SkillRepository $repo
    ) {
        $this->repo = $repo;
    }

    public function index($user)
    {
        return $this->repo
            ->getUserSkills($user);
    }

    public function store(
        $user,
        array $data
    ) {
        $categoryId = null;
        if (!empty($data['category'])) {
            $cat = \App\Models\SkillCategory::firstOrCreate(['name' => $data['category']]);
            $categoryId = $cat->id;
        }

        $skill = $this->repo
            ->findOrCreateSkill(
                $data['name'],
                $data['level'] ?? null,
                $categoryId
            );

        $this->repo->attachSkill(
            $user->profile,
            $skill
        );

        return $skill;
    }

    public function destroy(
        $user,
        int $skillId
    ) {
        $this->repo->detachSkill(
            $user->profile,
            $skillId
        );
    }
}