<?php

namespace App\Presentation\Web\Controller;

use App\Infrastructure\Repository\WordRepository;
use App\Presentation\Web\Form\GameFormDTO;
use App\Presentation\Web\Form\GameFormType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class AddAdditionalWordController extends AbstractController
{
    public function __construct(
        private readonly WordRepository $wordRep,
    ){
    }

    public function action(Request $request): Response
    {
        $form = $this->createForm(GameFormType::class);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            /** @var GameFormDTO $formData */
            $formData = $form->getData();

            $rus = $formData->getRus()
                ?: throw new \Exception('Перевод не передан!');

            $word = $this->wordRep->findByEng($formData->getEng())
                ?: throw new \Exception('Слово не найдено!');

            if ($rus !== $word->getRus() && !in_array($rus, $word->getAdditionalRus(), true)) {
                $word->addAdditionalRus($rus);
                $this->wordRep->save($word);
            }
        }

        return $this->redirectToRoute('main');
    }
}