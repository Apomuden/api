<?php
namespace App\Repositories;
interface IRepository{
    function all();
    function paginate();
    function store(array $data);

    function update(array $data, $id);

    function delete($id);

    function show($id);
    function find($id);
}
