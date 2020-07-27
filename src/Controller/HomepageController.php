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

        $totalItems = $repository->getCount();
        $pagesData = self::getPagesData($totalItems, 3, $orderBy);

        $items = $repository->findItemsList($pagesData['perPage'], $pagesData['offset'], $orderBy);

        // Redirect to the first page if no records were found
        if (count($items) === 0 && intval($pagesData['current']) > 1) {
            self::redirectTo('/');
        }

        return $this->getPage('homepage', [
            'items' => $items,
            'orderBy' => $orderBy,
            'totalItems' => $totalItems,
            'pages' => $pagesData
        ]);
    }
}
