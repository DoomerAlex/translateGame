<?php

namespace App\Presentation\Web\Form;

use App\Core\Service\WordStandartizator;

final class GameFormDTO
{
    public function __construct(
        public ?string $eng = null,
        public ?string $rus = null,
    ){
    }

    public function setEng(string $eng): void
    {
        $this->eng = $eng;
    }

    public function getEng(): string
    {
        return $this->eng;
    }

    public function setRus(?string $rus): void
    {
        $this->rus = WordStandartizator::convert($rus);
    }

    public function getRus(): ?string
    {
        return $this->rus;
    }
}