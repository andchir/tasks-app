<?php

namespace App\Controller;

use App\Entity\Task;
use App\Repository\TaskRepository;

class HomepageController extends BaseController {

    public function indexAction(): string
    {
        /** @var TaskRepository $repository */
        $repository = $this->entityManager->getRepository(Task::class);

        $orderByFields = ['username', 'email', 'status'];
        $orderBy = !empty($_GET['orderby']) && in_array($_GET['orderby'], $orderByFields)
            ? $_GET['orderby']
            : $orderByFields[0];
        $page = !empty($_GET['page']) && is_numeric($_GET['page']) ? (int) $_GET['page'] : 1;

        $items = $repository->findItemsList(3, 0, $orderBy);

        return $this->getPage('homepage', [
            'items' => $items,
            'orderBy' => $orderBy,
            'page' => $page
        ]);
    }
}
