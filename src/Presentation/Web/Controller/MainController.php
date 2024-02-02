<?php

namespace App\Presentation\Web\Controller;

use App\Core\Entity\User;
use App\Core\Service\WordChecker;
use App\Core\Service\WordGenerator;
use App\Core\Service\WordReport;
use App\Infrastructure\Repository\WordRepository;
use App\Presentation\Web\Form\GameFormDTO;
use App\Presentation\Web\Form\GameFormType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class MainController extends AbstractController
{
    private string $template = 'main.html.twig';
    private string $errorTemplate = 'error.html.twig';

    private User $user;

    public function __construct(
        private readonly WordGenerator $wordGenerator,
        private readonly WordChecker $wordChecker,
        private readonly WordReport $wordReport,
        private readonly WordRepository $wordRep,
    ){}

    public function action(Request $request): Response
    {
        $form = $this->createForm(GameFormType::class);

        $this->user = new User(1, 'admin');

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            /** @var GameFormDTO $formData */
            $formData = $form->getData();

            return $this->wordChecker->checkWord($formData->getEng(), $formData->getRus(), $this->user)
                ? $this->returnNewWord(true)
                : $this->renderError($form);
        }

        return $this->returnNewWord();
    }

    private function returnNewWord(bool $success = null): Response
    {
        $word = $this->wordGenerator->getRandomWord($this->user);
        $form = $this->createForm(GameFormType::class, new GameFormDTO($word->getEng()));

        return $this->render($this->template, [
            'rus' => $word->getRus(),
            'eng' => $word->getEng(),
            'form' => $form->createView(),
            'success' => $success,
            'progress' => $this->wordReport->getSuccessCount($this->user),
        ]);
    }

    private function renderError(FormInterface $form): Response
    {
        /** @var GameFormDTO $formData */
        $formData = $form->getData();
        $word = $this->wordRep->findByEng($formData->getEng());
        $additional = $word->getAdditionalData()['rus'] ?? [];
        $progress = $this->wordReport->getSuccessCount($this->user);

        return $this->render($this->errorTemplate, [
            'rus' => $word->getRus(),
            'eng' => $word->getEng(),
            'form' => $form->createView(),
            'additional' => $additional,
            'progress' => $progress,
        ]);
    }
}