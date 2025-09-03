<?php

namespace App\Controller;

use App\Repository\RecipeRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class LookupController extends AbstractController
{
    #[Route('/lookup', name: 'app_lookup')]
    public function index(Request $request, RecipeRepository $recipeRepository): Response
    {
        $search = $request->query->get('search');
        // dd($search);
        $recipes = $recipeRepository->findBySearch($search);
        return $this->render('lookup/index.html.twig', [
            'controller_name' => 'LookupController',
            'recipes'=> $recipes
        ]);
    }
}
