<?php
namespace App\Repositories;
interface IRepository{
    function all($sort,$order);
    function paginate();
    function store(array $data);

    function update(array $data, $id);

    function delete($id);

    function show($id);
    function find($id);
    function showWhere(array $where);
    function findWhere($where);
    function findOrFail($id);
    function getInstanceWith($with);
}
