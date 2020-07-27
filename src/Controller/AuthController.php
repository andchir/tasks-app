<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\UserRepository;

class AuthController extends BaseController {

    /**
     * Authorization page
     * @return string
     * @throws \Doctrine\ORM\NoResultException
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function authAction(): string
    {
        $user = self::getUser();
        if ($user) {
            self::redirectTo($this->config['basePath']);
        }

        $data = ['requestData' => ''];
        if (isset($_POST['username'])) {

            $requestData = [
                'username' => $_POST['username'] ?? '',
                'password' => $_POST['password'] ?? ''
            ];

            if (!$requestData['username']) {
                $this->setMessage('The "Username" field is required.');
            }
            if (!$this->getIsError() && !$requestData['password']) {
                $this->setMessage('The "Password" field is required.');
            }
            if (!$this->getIsError()) {
                $passwordHash = hash('SHA512', $requestData['password']);
                /** @var UserRepository $repository */
                $repository = $this->entityManager->getRepository(User::class);

                /** @var User $user */
                $user = $repository->findByUsernameOrEmail($requestData['username'], $passwordHash);

                if (!$user) {
                    $this->setMessage('The username or password you entered is incorrect.');
                } else {

                    self::sessionSet('user', array(
                        'id' => $user->getId(),
                        'username' => $user->getUsername(),
                        'role' => $user->getRole()
                    ));

                    self::redirectTo($this->config['basePath']);
                }
            }
            $data['requestData'] = $requestData;
        }
        $data['message'] = $this->getMessage();
        $data['messageType'] = $this->getMessageType();

        return $this->getPage('auth', $data);
    }

    /**
     * Log out
     */
    public function logoutAction(): void
    {
        self::sessionDelete('user');
        $refererIrl = $_SERVER['HTTP_REFERER'] ?? $this->config['basePath'];
        self::redirectTo($refererIrl);
    }
}
