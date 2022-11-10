<?php


namespace App\Services;


use App\Models\DeliveryPlace;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use phpDocumentor\Reflection\Types\Mixed_;

class DeliveryPlaceService
{
    /**
     * @param $input
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function list($input): \Illuminate\Contracts\Pagination\LengthAwarePaginator
    {
        $query = DeliveryPlace::query()
            ->when(isset($input['municipality_id']) && !empty($input['municipality_id']), function ($q) use($input){
                $q->where('municipality_id',$input['municipality_id']);
            })
            ->with('municipality')
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
     * @return DeliveryPlace
     */
    public function store($input):Model
    {
        return DeliveryPlace::query()->create($input);
    }

    public function find($id): Model
    {
        return DeliveryPlace::find($id);
    }

    public function update($id, $input):int
    {
        return DeliveryPlace::query()->where('id',$id)->update($input);
    }

    /**
     * @param $id
     * @return mixed
     */
    public function destroy($id)
    {
        return DeliveryPlace::query()->where('id',$id)->delete();
    }
}
