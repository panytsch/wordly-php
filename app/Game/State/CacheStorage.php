<?php

namespace App\Game\State;

use Illuminate\Support\Facades\Cache;

class CacheStorage implements GameSaveStorage
{

    public function save(array $state): void
    {
        Cache::put($this->key(), $state);
    }

    public function restore(): array
    {
        return Cache::get($this->key());
    }

    public function exists(): bool
    {
        return Cache::has($this->key());
    }

    private function key(): string
    {
        return 'game-save';
    }

    public function flush(): void
    {
        Cache::delete($this->key());
    }
}
