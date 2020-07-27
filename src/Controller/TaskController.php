<?php

namespace App\Controller;

use App\Entity\Task;
use App\Entity\User;
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
            'requestData' => [],
            'user' => self::getUser()
        ];
        if (isset($_POST['username'])) {

            $requestData = $this->getPostData();
            if (!$this->getIsError()) {

                $task = new Task();
                $this->saveTask($task, $requestData);

                if (!$this->getIsError()) {
                    $this->setMessage('Task added successfully.', self::MESSAGE_TYPE_SUCCESS);
                    $requestData = [];
                }
            }
            $data['requestData'] = $requestData;
        }
        $data['message'] = $this->getMessage();
        $data['messageType'] = $this->getMessageType();

        return $this->getPage('task_form', $data);
    }

    /**
     * @param string $itemId
     * @return string
     */
    public function updatePageAction(string $itemId): string
    {
        $user = self::getUser();
        if (!$user) {
            self::redirectTo('/auth');
        }

        $data = [
            'formActionUrl' => $this->config['basePath'] . 'tasks/edit/' . $itemId,
            'itemId' => $itemId,
            'requestData' => [],
            'user' => $user
        ];
        $repository = $this->entityManager->getRepository(Task::class);

        /** @var Task $task */
        $task = $repository->findOneBy(['id' => (int) $itemId]);

        if (!$task) {

            $this->setMessage('Item not found.');
            $data['formActionUrl'] = '';

        } else {

            if (isset($_POST['username'])) {
                $requestData = $this->getPostData();
                if (!$this->getIsError()) {
                    $this->saveTask($task, $requestData);
                    if (!$this->getIsError()) {
                        $this->setMessage('Task saved successfully.', self::MESSAGE_TYPE_SUCCESS);
                    }
                }
                $data['requestData'] = $requestData;
            } else {
                $data['requestData'] = [
                    'username' => $task->getUsername(),
                    'email' => $task->getEmail(),
                    'description' => $task->getDescription(),
                    'finished' => $task->getStatus() === Task::STATUS_FINISHED
                ];
            }
        }

        $data['message'] = $this->getMessage();
        $data['messageType'] = $this->getMessageType();

        return $this->getPage('task_form', $data);
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
            'finished' => !empty($_POST['finished'])
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

    /**
     * @param Task $task
     * @param array $requestData
     * @param string $status
     */
    public function saveTask(Task $task, array $requestData, string $status = Task::STATUS_CREATED): void
    {
        $task
            ->setUsername($requestData['username'])
            ->setEmail($requestData['email'])
            ->setDescription($requestData['description'])
            ->setStatus($status);

        $user = self::getUser();
        if ($task->getId() && $user && $user['role'] === User::ROLE_ADMIN) {
            $task
                ->setEditedBy($user['username'])
                ->setStatus(!empty($requestData['finished']) ? Task::STATUS_FINISHED : Task::STATUS_CREATED);
        }

        try {
            if (!$task->getId()) {
                $this->entityManager->persist($task);
            }
            $this->entityManager->flush();
        } catch (ORMException $e) {
            $this->setMessage('An error occurred while creating/updating a record in the database.');
        }
    }
}
