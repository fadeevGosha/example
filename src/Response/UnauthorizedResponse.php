<?php

namespace App\Responses;

use App\Response\Response;
use Symfony\Component\HttpFoundation\Response as SymfonyResponse;
use OpenApi\Annotations as SWG;
use Symfony\Component\Serializer\Annotation\Groups;

class UnauthorizedResponse extends Response
{
    /**
     * @var bool
     * @SWG\Property(type="boolean", description="Result of login operation", example=false)
     * @Groups({"swagger"})
     */
    public bool $result = false;
    
    /**
     * @var string
     * @SWG\Property(type="string", description="Unauthorized found message")
     * @Groups({"swagger"})
     */    
    public string $message;
    
    public function __construct(string $message)
    {
        $this->message = $message;
    }
    
    public function getResponseCode() : int
    {
        return SymfonyResponse::HTTP_UNAUTHORIZED;
    }
}