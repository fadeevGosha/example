<?php


namespace App\Repository;


interface IUserRepository
{
    public function findAllSortedByName():array;
}