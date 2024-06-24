<?php

namespace App\Game\State;

readonly class Save
{
    public function __construct(
        private GameSaveStorage     $gameSaveStorage,
        private GameStateSerializer $gameStateSerializer,
    )
    {
    }

    public function save(): void
    {
        $this->gameSaveStorage->save($this->gameStateSerializer->serialize());
    }

    public function restore(): void
    {
        $data = $this->gameSaveStorage->restore();
        $this->gameStateSerializer->deserialize($data);
    }

    public function saveExists(): bool
    {
        return $this->gameSaveStorage->exists();
    }

    public function delete(): void
    {
        $this->gameSaveStorage->flush();
    }
}
