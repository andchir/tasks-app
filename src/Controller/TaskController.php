<?php

namespace App\Controller;

use App\Entity\Task;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;

class TaskController extends BaseController {

    public function addPageAction(): string
    {
        $data = ['requestData' => ''];
        if (isset($_POST['username'])) {

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
}
