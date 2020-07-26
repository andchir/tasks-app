<?php

namespace App\Controller;

use App\Entity\Task;

class HomepageController extends BaseController {

    public function indexAction(): string
    {

        $repository = $this->entityManager->getRepository(Task::class);
        $items = $repository->findBy([], ['id' => 'asc']);

        return $this->getPage('homepage', [
            'items' => $items
        ]);
    }

}
