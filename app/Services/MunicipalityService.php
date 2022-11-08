<?php

namespace App\Services;

use App\Models\Municipality;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use phpDocumentor\Reflection\Types\Mixed_;

class MunicipalityService
{
    /**
     * @param $input
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function list($input): \Illuminate\Contracts\Pagination\LengthAwarePaginator
    {
        return Municipality::query()->paginate(
            isset($input['per_page']) && !empty($input['per_page']) ? $input['per_page'] : 50,
            '*',
            'page',
            isset($input['page']) && !empty($input['page']) ? $input['page'] : 1
        );
    }

    /**
     * @param $input
     * @return Municipality
     */
    public function store($input):Model
    {
        return Municipality::query()->create($input);
    }

    public function find($id): Model
    {
        return Municipality::find($id);
    }

    public function update($id, $input):int
    {
        return Municipality::query()->where('id',$id)->update($input);
    }

    /**
     * @param $id
     * @return mixed
     */
    public function destroy($id)
    {
        return Municipality::query()->where('id',$id)->delete();
    }
}
