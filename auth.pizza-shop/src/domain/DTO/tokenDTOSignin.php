<?php

namespace pizzashop\auth\api\domain\DTO\tokenDTOSignin;

use Firebase\Auth\Token\Verifier;
use Firebase\Auth\Token\Domain\Uid;
use Firebase\Auth\Token\Verifier\IdTokenVerifier;

class SignInDTO {
    private $verifier;

    public function __construct() {
        $this->verifier = new IdTokenVerifier();
    }

    public function signInWithToken($idToken) {
        // Validez le token avec Firebase Admin SDK
        $token = $this->verifier->verifyIdToken($idToken);

        // Obtenez l'ID de l'utilisateur à partir du token
        $uid = Uid::fromArray(['uid' => $token->claims()->get('sub')]);

        return $uid->toString();
    }
}
