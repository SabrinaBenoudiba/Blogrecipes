<?php

namespace App\Controller;

use App\Entity\Category;
use App\Form\CategoryType;
use App\Repository\CategoryRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#region Index All Categories
#[Route('/category')]
final class CategoryController extends AbstractController
{
    #[Route(name: 'app_category_index', methods: ['GET'])]
    public function index(CategoryRepository $categoryRepository): Response
    {
        return $this->render('category/index.html.twig', [
            'categories' => $categoryRepository->findAll(),
        ]);
    }
#endregion Index All Categories

    #region New
    #[Route('/admin/new', name: 'app_category_new', methods: ['GET', 'POST'])]
    #[IsGranted('ROLE_ADMIN')]    
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $category = new Category();
        $form = $this->createForm(CategoryType::class, $category);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($category);
            $entityManager->flush();

            $this->addFlash('success', "La catégorie a bien été ajoutée");

            return $this->redirectToRoute('app_category_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('category/new.html.twig', [
            'category' => $category,
            'form' => $form,
        ]);
    }
    #endregion New

    #region Show
    #[Route('/{id}', name: 'app_category_show', methods: ['GET'])]
    // #[IsGranted('ROLE_ADMIN')]  
    // #[IsGranted('ROLE_USER')]  
    public function show(Category $category): Response
    {
        $recipes=$category->getRecipes();
        return $this->render('category/show.html.twig', [
            'category' => $category,
            'recipes' => $recipes,
        ]);
    }
    #endregion Show

    #region Edit
    #[Route('/admin/{id}/edit', name: 'app_category_edit', methods: ['GET', 'POST'])]
     #[IsGranted('ROLE_ADMIN')]
    public function edit(Request $request, Category $category, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(CategoryType::class, $category);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            $this->addFlash('info', "Les modifications ont bien été appliquées");

            return $this->redirectToRoute('app_category_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('category/edit.html.twig', [
            'category' => $category,
            'form' => $form,
        ]);
    }
    #endregion Edit

    #region Delete
    #[Route('/admin/{id}', name: 'app_category_delete', methods: ['GET','POST'])]
    #[IsGranted('ROLE_ADMIN')]
    public function delete($id, Request $request, Category $category, EntityManagerInterface $entityManager): Response
    {
        $category = $entityManager->getRepository(Category::class)->find($id); //attention à faire le repository sur l'entité que l'on veut

        if ($this->isCsrfTokenValid('delete'.$category->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($category);
            $entityManager->flush();
        }

        $this->addFlash('danger', "La catégorie a bien été supprimée");

        return $this->redirectToRoute('app_category_index', [], Response::HTTP_SEE_OTHER);
    }
}
    #endregion Delete
