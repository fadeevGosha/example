<?php

namespace App\Response;

use Swagger\Annotations as SWG;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\HttpFoundation\Response AS SymfonyResponse;

class BadRequestResponse extends Response
{
    const DEFAULT_MESSAGE = 'Bad request';
    
    /**
     * @var bool
     * @SWG\Property(type="boolean", description="Result of operation", example=false)
     * @Groups({"swagger"})
     */
    public $result = false;

    /**
     * @var string
     * @SWG\Property(type="string", description="Bad request message")
     * @Groups({"swagger"})
     */    
    public $message = self::DEFAULT_MESSAGE;
    
    public function __construct(string $message = null)
    {
        if(null !== $message)
        {
            $this->message = $message;
        }
    }
    
    public function getResponseCode() : int
    {
        return SymfonyResponse::HTTP_BAD_REQUEST;
    }
}