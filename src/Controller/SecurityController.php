<?php

namespace App\Controller;

use ApiPlatform\Api\IriConverterInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\CurrentUser;

class SecurityController extends AbstractController {

  #[Route('/login', name: 'app_login', methods: ['POST'])]
  public function login(IriConverterInterface $iriConverter, #[CurrentUser] $user = null): Response {

    if (!$user) {
      return $this->json([
        'error' => 'Acceso denegado',
      ], 401);
    }
    return $this->json([
      'token' => $user->getValidTokenStrings(),
      'username' => $user->getUsername(),
      'uri' => $iriConverter->getIriFromResource($user)

    ], 200);
  }

  #[Route('/logout', name: 'app_logout', methods: ['POST'])]
  public function logout(Security $security): Response {
    // logout the user in on the current firewall
    $response = $security->logout();

    // you can also disable the csrf logout
    $response = $security->logout(false);

    return new Response();
  }

  #[Route('/auth', name: 'auth', methods: ['POST'])]
  public function auth(#[CurrentUser] $user = null): Response {

    if (!$user = $this->getUser()) {
      return $this->json([
        'error' => 'Acceso denegado',
      ], 401);
    }
    return $this->json([
      'token' => $user->getValidTokenStrings(),
      'username' => $user->getUsername()

    ], 200);
  }
}
