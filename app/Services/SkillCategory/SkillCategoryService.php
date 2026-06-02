<?php

namespace App\Services\SkillCategory;

use App\Repositories\SkillCategory\SkillCategoryRepository;

class SkillCategoryService
{
    protected SkillCategoryRepository $repo;

    public function __construct(SkillCategoryRepository $repo)
    {
        $this->repo = $repo;
    }

    public function listCategories()
    {
        return $this->repo->all();
    }

    public function createCategory(array $data)
    {
        return $this->repo->create($data);
    }

    public function updateCategory(int $id, array $data)
    {
        $category = $this->repo->find($id);

        if (! $category) {
            abort(404, 'Skill category not found.');
        }

        return $this->repo->update($category, $data);
    }

    public function deleteCategory(int $id)
    {
        $category = $this->repo->find($id);

        if (! $category) {
            abort(404, 'Skill category not found.');
        }

        $this->repo->delete($category);
    }
}
