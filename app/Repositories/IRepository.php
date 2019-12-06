<?php
namespace App\Repositories;
interface IRepository{
    function all();

    function create(array $data);

    function update(array $data, $id);

    function delete($id);

    function show($id);
}
