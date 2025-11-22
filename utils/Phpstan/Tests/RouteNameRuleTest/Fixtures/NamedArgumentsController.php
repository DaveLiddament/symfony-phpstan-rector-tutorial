<?php

namespace RouteNameRuleTest\Fixtures;

use App\Phpstan\Route;

class NamedArgumentsController
{
    #[Route(path: '/people', name: 'people_list')]
    public function listPeople(): string
    {
        return "List of people";
    }
    #[Route(path: '/person/{id}/jobs')]
    public function getPersonJobs(int $id): string
    {
        return "A person";
    }

    #[Route(name: 'personAddress', path:'/person/{id}/address')]
    public function getPersonAddress(int $id): string
    {
        return "A person";
    }

    #[Route('/person/{id}/relatives', name: 'personRelatives')]
    public function getPersonRelatives(int $id): string
    {
        return "A person";
    }

    #[Route(name: 'person_cars', path:'/person/{id}/address')]
    public function getPersonCars(int $id): string
    {
        return "A person";
    }

}