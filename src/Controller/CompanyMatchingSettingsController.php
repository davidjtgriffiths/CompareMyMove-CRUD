<?php

namespace App\Controller;

use App\Entity\CompanyMatchingSettings;
use App\Form\CompanyMatchingSettingsType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/company/matching/settings')]
class CompanyMatchingSettingsController extends AbstractController
{
    #[Route('/', name: 'app_company_matching_settings_index', methods: ['GET'])]
    public function index(EntityManagerInterface $entityManager): Response
    {
        $companyMatchingSettings = $entityManager
            ->getRepository(CompanyMatchingSettings::class)
            ->findAll();

        return $this->render('company_matching_settings/index.html.twig', [
            'company_matching_settings' => $companyMatchingSettings,
        ]);
    }

    #[Route('/new', name: 'app_company_matching_settings_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $companyMatchingSetting = new CompanyMatchingSettings();
        $form = $this->createForm(CompanyMatchingSettingsType::class, $companyMatchingSetting);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($companyMatchingSetting);
            $entityManager->flush();

            return $this->redirectToRoute('app_company_matching_settings_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('company_matching_settings/new.html.twig', [
            'company_matching_setting' => $companyMatchingSetting,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_company_matching_settings_show', methods: ['GET'])]
    public function show(CompanyMatchingSettings $companyMatchingSetting): Response
    {
        return $this->render('company_matching_settings/show.html.twig', [
            'company_matching_setting' => $companyMatchingSetting,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_company_matching_settings_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, CompanyMatchingSettings $companyMatchingSetting, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(CompanyMatchingSettingsType::class, $companyMatchingSetting);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_company_matching_settings_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('company_matching_settings/edit.html.twig', [
            'company_matching_setting' => $companyMatchingSetting,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_company_matching_settings_delete', methods: ['POST'])]
    public function delete(Request $request, CompanyMatchingSettings $companyMatchingSetting, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$companyMatchingSetting->getId(), $request->request->get('_token'))) {
            $entityManager->remove($companyMatchingSetting);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_company_matching_settings_index', [], Response::HTTP_SEE_OTHER);
    }
}
