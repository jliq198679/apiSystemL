<?php


namespace App\Services;


use App\Models\SideDish;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use phpDocumentor\Reflection\Types\Mixed_;

class SideDishService
{
    /**
     * @param $input
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function list($input): \Illuminate\Contracts\Pagination\LengthAwarePaginator
    {
        $query = SideDish::query()
            ->when(isset($input['type_side_dish_id']) && !empty($input['type_side_dish_id']), function ($q) use($input){
                $q->where('type_side_dish_id',$input['type_side_dish_id']);
            })
            ->with('typeSideDish')
            ;
        return $query->paginate(
            isset($input['per_page']) && !empty($input['per_page']) ? $input['per_page'] : 50,
            '*',
            'page',
            isset($input['page']) && !empty($input['page']) ? $input['page'] : 1
        );

    }

    /**
     * @param $input
     * @return SideDish
     */
    public function store($input):Model
    {
        return SideDish::query()->create($input);
    }

    public function find($id): Model
    {
        return SideDish::find($id);
    }

    public function update($id, $input):int
    {
        return SideDish::query()->where('id',$id)->update($input);
    }

    /**
     * @param $id
     * @return mixed
     */
    public function destroy($id)
    {
        return SideDish::query()->where('id',$id)->delete();
    }
}
