<?php

namespace App\Game\State;

interface GameSaveStorage
{
    public function save(array $state): void;

    public function restore(): array;

    public function exists(): bool;

    public function flush(): void;
}
