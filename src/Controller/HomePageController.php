<?php

namespace App\Controller;

use App\Repository\RecipeRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class HomePageController extends AbstractController
{
    #[Route('/', name: 'app_home_page', methods: ['GET'])]
    public function index(RecipeRepository $recipeRepository): Response
    {

        return $this->render('home_page/index.html.twig', [
            'controller_name' => 'HomePageController',
            'recipes' => $recipeRepository->findAll(),
        ]);
    }
}
