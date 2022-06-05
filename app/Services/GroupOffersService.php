<?php


namespace App\Services;


use App\Models\FrameWeb;
use App\Models\GroupOffer;
use PHPUnit\TextUI\XmlConfiguration\Group;

class GroupOffersService
{
    public function list($input)
    {
        $query = GroupOffer::query()->category();
        return $query->paginate(
            isset($input['per_page']) && !empty($input['per_page']) ? $input['per_page'] : 50,
            '*',
            'page',
            isset($input['page']) && !empty($input['page']) ? $input['page'] : 1

        );
    }

    public function listSubCategory($category,$input)
    {
        $query =  GroupOffer::query()->subCategory()
            ->where('category_id',$category)
            ;
        return $query->paginate(
            isset($input['per_page']) && !empty($input['per_page']) ? $input['per_page'] : 50,
            '*',
            'page',
            isset($input['page']) && !empty($input['page']) ? $input['page'] : 1

        );
    }

    public function listGroupWithOffer($input)
    {
        return GroupOffer::query()->with('offers')->paginate(
            isset($input['per_page']) && !empty($input['per_page']) ? $input['per_page'] : 50,
            '*',
            'page',
            isset($input['page']) && !empty($input['page']) ? $input['page'] : 1

        );;
    }

    public function store($input)
    {
        return GroupOffer::query()->create($input);
    }

    public function show($id)
    {
        return GroupOffer::find($id);
    }

    public function update(GroupOffer $group,$input)
    {
        GroupOffer::query()->whereKey($group->id)->update($input);
        $group->refresh();
        return $group;
    }

    public function destroy(GroupOffer $frameWeb)
    {
        return $frameWeb->delete();
    }
}
