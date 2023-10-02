<?php

namespace App\Controller;

use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class IndexController extends AbstractController
{
    #[Route('/', name: 'app_index')]
    public function index(): Response
    {
        return $this->render('index/index.html.twig', [
            'controller_name' => 'IndexController',
        ]);
    }

    #[Route('/profile/details', name: 'app_details')]
    public function details(UserRepository $userRepository): Response
    {
        $users = $userRepository->findAll();

        return $this->render('index/details.html.twig', [
            'users' => $users,
        ]);
    }

    #[Route('/profile/details/{id}', name: 'app_employe')]
    public function detailEmploye(UserRepository $userRepository, $id): Response
    {
        $user = $userRepository->find($id);

        return $this->render('index/employe.html.twig', [
            'user' => $user,
        ]);
    }
}
