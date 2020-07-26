<?php

namespace App\Controller;

use App\Entity\Task;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;

class TaskController extends BaseController {

    /**
     * Create task
     * @return string
     */
    public function addPageAction(): string
    {
        $data = [
            'formActionUrl' => $this->config['basePath'] . 'tasks/add',
            'requestData' => []
        ];
        if (isset($_POST['username'])) {

            $requestData = $this->getPostData();
            if (!$this->getIsError()) {

                $task = new Task();
                $task
                    ->setUsername($requestData['username'])
                    ->setEmail($requestData['email'])
                    ->setDescription($requestData['description'])
                    ->setStatus(Task::STATUS_CREATED);

                try {
                    $this->entityManager->persist($task);
                    $this->entityManager->flush();
                } catch (ORMException $e) {
                    $this->setMessage('An error occurred while creating a record in the database.');
                }

                if (!$this->getIsError()) {
                    $this->setMessage('Task added successfully.', self::MESSAGE_TYPE_SUCCESS);
                    $requestData = [];
                }
            }
            $data['requestData'] = $requestData;
        }
        $data['message'] = $this->getMessage();
        $data['messageType'] = $this->getMessageType();

        return $this->getPage('add_task', $data);
    }

    /**
     * @param string $itemId
     * @return string
     */
    public function updatePageAction(string $itemId)
    {
        $user = self::getUser();
        if (!$user) {
            self::redirectTo('/auth');
        }

        $data = [
            'formActionUrl' => $this->config['basePath'] . 'tasks/edit/' . $itemId,
            'itemId' => $itemId,
            'requestData' => []
        ];
        $repository = $this->entityManager->getRepository(Task::class);

        if (isset($_POST['username'])) {
            $requestData = $this->getPostData();
            if (!$this->getIsError()) {



            }
            $data['requestData'] = $requestData;
        } else {

            /** @var Task $task */
            $task = $repository->findOneBy(['id' => (int) $itemId]);

            if (!$task) {

                $this->setMessage('Item not found.');
                $data['formActionUrl'] = '';

            } else {
                $data['requestData'] = [
                    'username' => $task->getUsername(),
                    'email' => $task->getEmail(),
                    'description' => $task->getDescription()
                ];
            }
        }
        $data['message'] = $this->getMessage();
        $data['messageType'] = $this->getMessageType();

        return $this->getPage('add_task', $data);
    }

    /**
     * @return array
     */
    public function getPostData(): array
    {
        $requestData = [
            'username' => isset($_POST['username'])
                ? self::cleanString($_POST['username'])
                : '',
            'email' => isset($_POST['username'])
                ? self::cleanString($_POST['email'])
                : '',
            'description' => isset($_POST['username'])
                ? self::cleanString($_POST['description'], true)
                : '',
        ];

        if (!$requestData['username']) {
            $this->setMessage('The "Username" field is required.');
        }
        if (!$this->getIsError() && !$requestData['email']) {
            $this->setMessage('The "Email" field is required.');
        }
        if (!$this->getIsError() && !filter_var($requestData['email'], FILTER_VALIDATE_EMAIL)) {
            $this->setMessage('Email address is invalid.');
        }
        if (!$this->getIsError() && !$requestData['description']) {
            $this->setMessage('The "Description" field is required.');
        }

        return $requestData;
    }
}
