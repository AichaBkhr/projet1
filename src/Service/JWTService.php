<?php
namespace App\Service;

use DateTimeImmutable;

class JWTService
{
    //on génére le token
    public function generate(array $header,array $payload, string $secret, int $validity = 10800): string
    {
        if($validity > 0){
            $now = new DateTimeImmutable();
            $exp = $now->getTimestamp() + $validity;

            $payload['iat'] = $now->getTimestamp();
            $payload['exp'] = $exp;
        }
        

        //encoder tout ça en bas64
        $base64Header = base64_encode(json_encode($header));
        $base64Payload = base64_encode(json_encode($payload));

        // nettoyer les valeurs encodées (retrait des +, / et =)
        $base64Header = str_replace(['+','/','='], ['-', '_', ''], $base64Header);
        $base64Payload = str_replace(['+','/','='], ['-', '_', ''], $base64Payload);

        // générer la signature
        $secret = base64_encode($secret);

        $signature = hash_hmac('sha256',  $base64Header . '.' . $base64Payload, $secret, true);

        $base64Signature = base64_encode($signature);
        $base64Signature = str_replace(['+','/','='], ['-', '_', ''], $base64Signature);

        // créer le token
        $jwt = $base64Header . '.' . $base64Payload . '.' . $base64Signature;


        return $jwt;
    }

    // vérifier si le token est valide 
    public function isValid(string $token): bool
    {
        return preg_match(
            '/^[a-zA-Z0-9\-\_\=]+\.[a-zA-Z0-9\-\_\=]+\.[a-zA-Z0-9\-\_\=]+$/',
            $token
        ) === 1;
    }

    // vérifier si le token a expiré 

    // on commence par récupérer le payload
    public function getPayload(string $token): array
    {
        // démonter le token
        $array = explode('.', $token);

        // décoder le payload
        $payload = json_decode(base64_decode($array[1]), true);


        return $payload;

    }
    // ensuite on vérifie la date d'expiration
    public function isExpired(string $token): bool
    {
        $payload = $this->getPayload($token);

        $now = new DateTimeImmutable();

        return $payload['exp'] < $now->getTimestamp();

    }

    // vérifier la signature du token

    // on commence par récupérer le Header
    public function getHeader(string $token): array
    {
        // démonter le token
        $array = explode('.', $token);

        // décoder le Header
        $header = json_decode(base64_decode($array[0]), true);


        return $header;

    }
    public function check(string $token, string $secret): bool
    {
        // récuperer le header et le payload :
        $header = $this->getHeader($token);
        $payload = $this->getPayload($token);

        // vérifier la signature en régénérant un nv token
        $verifToken = $this->generate($header, $payload, $secret, 0); //pour pas regénerer des date d'expiration et je pourrais donc vérifier mon token

        return $token === $verifToken;
    }
}