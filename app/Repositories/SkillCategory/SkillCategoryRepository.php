<?php

namespace App\Repositories\SkillCategory;

use App\Models\SkillCategory;
use Illuminate\Database\Eloquent\Collection;

class SkillCategoryRepository
{
    public function all(): Collection
    {
        return SkillCategory::orderBy('name')->get();
    }

    public function create(array $data): SkillCategory
    {
        return SkillCategory::create($data);
    }

    public function find(int $id): ?SkillCategory
    {
        return SkillCategory::find($id);
    }

    public function update(SkillCategory $category, array $data): SkillCategory
    {
        $category->fill($data);
        $category->save();

        return $category;
    }

    public function delete(SkillCategory $category): void
    {
        $category->delete();
    }
}
