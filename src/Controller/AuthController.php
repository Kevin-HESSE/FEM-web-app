<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AuthController extends AbstractController
{
    #[Route('/login', name: 'app_auth_login')]
    public function logIn()
    {

    }

    #[Route('/logout', name: 'app_auth_logout')]
    public function logOut()
    {
        //TODO
    }

//    #[Route('/register', name: 'app_auth_register')]
//    public function register(Request $request): Response
//    {
//        if($request->isMethod('POST')){
//            dd($request->request);
//
//
//        }
//
//        return $this->render('authentication/register.html.twig');
//    }
}