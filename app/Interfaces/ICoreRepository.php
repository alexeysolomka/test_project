<?php


namespace App\Interfaces;


interface ICoreRepository
{
    public function getAll();

    public function create($data);

    public function update($id, $data);
}
