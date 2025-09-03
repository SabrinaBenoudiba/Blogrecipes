<?php

namespace App\Controller;

use App\Repository\CategoryRepository;
use App\Repository\RecipeRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class HomePageController extends AbstractController
{
    #[Route('/', name: 'app_home_page', methods: ['GET'])]
    public function index(RecipeRepository $recipeRepository, CategoryRepository $categoryRepository, Request $request): Response
    {
        $recipeRepository->findby([],['id'=>"DESC"]);
        return $this->render('home_page/index.html.twig', [
            'controller_name' => 'HomePageController',
            'categories' => $categoryRepository -> findAll()
        ]);
    }
}
