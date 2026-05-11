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
        $skill = $this->repo
            ->findOrCreateSkill(
                $data['skill_name']
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