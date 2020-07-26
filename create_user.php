<?php

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;

require __DIR__ . '/app/bootstrap.php';
/** @var EntityManagerInterface $entityManager */

$plainPassword = '123';
$passwordHash = hash('SHA512', $plainPassword);

$user = new User();
$user
    ->setUsername('admin')
    ->setEmail('aaa@bbb.cc')
    ->setRole(User::ROLE_ADMIN)
    ->setPassword($passwordHash);

$entityManager->persist($user);
$entityManager->flush();

echo 'User created successfully.' . PHP_EOL;

