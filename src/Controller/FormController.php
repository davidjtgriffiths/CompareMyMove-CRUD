<?php

namespace App\Controller;

use App\Service\CompanyMatcher;

class FormController extends Controller
{

    public function index()
    {
        $this->render('form.twig');
    }

    public function submit()
    {
        $matchedCompanies = [];
        $matcher = new CompanyMatcher($this->db());

        $matchedCompanies = $matcher->results(3);
        $matcher->deductCredits($matchedCompanies);

        $this->render('results.twig', [
            'matchedCompanies'  => $matchedCompanies,
        ]);
    }
}
