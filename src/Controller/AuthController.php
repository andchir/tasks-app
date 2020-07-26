<?php

namespace App\Controller;

class AuthController extends BaseController {

    public function authAction(): string
    {

        $data = [];

        return $this->getPage('auth', $data);
    }

}
