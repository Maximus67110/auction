<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

class LocaleController extends AbstractController
{
    private SessionInterface $session;

    public function __construct(
        private readonly RequestStack $requestStack,
    ) {
        $this->session = $this->requestStack->getSession();
    }

    #[Route('/locale', name: 'app_locale')]
    public function index(Request $request): Response
    {
        $locale = $request->get('locale');
        $this->session->set('locale', $locale);
        $previousUrl = $request->headers->get("referer");
        return $this->redirect($previousUrl);
    }
}
