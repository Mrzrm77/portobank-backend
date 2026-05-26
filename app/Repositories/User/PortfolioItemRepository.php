<?php

namespace App\Repositories\User;

use App\Models\Portfolio;
use App\Models\PortfolioItem;

class PortfolioItemRepository
{
    public function getUserPortfolioItems($user)
    {
        $portfolio = $this->getOrCreateUserPortfolio($user);

        return $portfolio->items()
            ->latest()
            ->get();
    }

    public function create($user, array $data)
    {
        $portfolio = $this->getOrCreateUserPortfolio($user);

        return $portfolio->items()
            ->create($data);
    }

    public function update(PortfolioItem $item, array $data)
    {
        $item->update($data);

        return $item->fresh();
    }

    public function delete(PortfolioItem $item)
    {
        return $item->delete();
    }

    public function findUserPortfolioItem($user, int $itemId)
    {
        $portfolio = $this->getOrCreateUserPortfolio($user);

        return $portfolio->items()
            ->findOrFail($itemId);
    }

    public function getItemByPortfolio(Portfolio $portfolio, int $itemId)
    {
        return $portfolio->items()
            ->findOrFail($itemId);
    }

    protected function getOrCreateUserPortfolio($user): Portfolio
    {
        return Portfolio::firstOrCreate(
            ['user_id' => $user->id],
            ['title' => 'Portfolio', 'description' => null, 'is_published' => false, 'view_count' => 0]
        );
    }
}
