<?php

namespace App\Response;

interface ResponseInterface extends \JsonSerializable
{
    public function getResponseCode() : int;
    public function getResponseData() : array;
}
