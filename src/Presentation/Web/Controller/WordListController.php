<?php

namespace App\Presentation\Web\Controller;

use App\Core\Entity\User;
use App\Core\Service\WordReport;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class WordListController extends AbstractController
{
    private string $template = 'wordList.html.twig';

    public function __construct(
        private readonly WordReport $wordReport,
    ){
    }

    public function action(): Response
    {
        $user = new User(1, 'admin');

        $data = $this->wordReport->getStatisticDataByUser($user);

        return $this->render($this->template, [
            'data' => $data,
        ]);
    }
}