<?php

namespace App\Response;

use Swagger\Annotations as SWG;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\HttpFoundation\Response AS SymfonyResponse;

class NotFoundResponse extends Response
{
    const DEFAULT_MESSAGE = 'Not found';
    
    /**
     * @var bool
     * @SWG\Property(type="boolean", description="Result of operation", example=false)
     * @Groups({"swagger"})
     */
    public $result = false;

    /**
     * @var string
     * @SWG\Property(type="string", description="Not found message")
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
        return SymfonyResponse::HTTP_NOT_FOUND;
    }
}