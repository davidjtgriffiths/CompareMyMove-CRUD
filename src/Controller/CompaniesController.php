<?php

namespace App\Controller;

use App\Entity\Companies;
use App\Form\CompaniesType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/companies')]
class CompaniesController extends AbstractController
{
    #[Route('/', name: 'app_companies_index', methods: ['GET'])]
    public function index(EntityManagerInterface $entityManager): Response
    {
        $companies = $entityManager
            ->getRepository(Companies::class)
            ->findAll();

        return $this->render('companies/index.html.twig', [
            'companies' => $companies,
        ]);
    }

    #[Route('/new', name: 'app_companies_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $company = new Companies();
        $form = $this->createForm(CompaniesType::class, $company);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($company);
            $entityManager->flush();

            return $this->redirectToRoute('app_companies_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('companies/new.html.twig', [
            'company' => $company,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_companies_show', methods: ['GET'])]
    public function show(Companies $company): Response
    {
        return $this->render('companies/show.html.twig', [
            'company' => $company,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_companies_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Companies $company, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(CompaniesType::class, $company);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_companies_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('companies/edit.html.twig', [
            'company' => $company,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_companies_delete', methods: ['POST'])]
    public function delete(Request $request, Companies $company, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$company->getId(), $request->request->get('_token'))) {
            $entityManager->remove($company);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_companies_index', [], Response::HTTP_SEE_OTHER);
    }
}
