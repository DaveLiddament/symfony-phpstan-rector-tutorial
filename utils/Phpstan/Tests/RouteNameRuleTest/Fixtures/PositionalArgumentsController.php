<?php

namespace Utils\Phpstan\Tests\RouteNameRuleTest\Fixtures;

use App\Phpstan\Route;

class PositionalArgumentsController
{
    #[Route('/people', 'peopleList')]
    public function listPeople(): string
    {
        return "List of people";
    }

    #[Route('/person/{id}', 'person')]
    public function getPerson(int $id): string
    {
        return "A person";
    }

    #[Route('/person/{id}/jobs')]
    public function getPersonJobs(int $id): string
    {
        return "A person";
    }
}