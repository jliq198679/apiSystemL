<?php


namespace App\Services;


use App\Models\FrameWeb;
use App\Models\GroupOffer;
use PHPUnit\TextUI\XmlConfiguration\Group;

class GroupOffersService
{
    public function list()
    {
        return GroupOffer::all();
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
        return GroupOffer::query()->whereKey($group->id)->update($input);
    }

    public function destroy(FrameWeb $frameWeb)
    {
        return $frameWeb->delete();
    }
}
