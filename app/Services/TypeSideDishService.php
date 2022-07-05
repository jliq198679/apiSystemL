<?php


namespace App\Services;


use App\Models\TypeSideDish;

class TypeSideDishService
{
    public function list($input)
    {
        return TypeSideDish::query()->paginate(
            isset($input['per_page']) && !empty($input['per_page']) ? $input['per_page'] : 50,
            '*',
            'page',
            isset($input['page']) && !empty($input['page']) ? $input['page'] : 1
        );
    }

    public function store($input)
    {
        return TypeSideDish::query()->create($input);
    }

    public function find($id)
    {
        return TypeSideDish::find($id);
    }

    public function update($id, $input)
    {
       return TypeSideDish::query()->where('id',$id)->update($input);
    }

    public function destroy($id)
    {
        return TypeSideDish::query()->where('id',$id)->delete();
    }
}
