<?php


namespace App\Services;


use App\Models\Setting;

class SettingService
{
    public function get()
    {
        return Setting::first();
    }

    public function store($input)
    {
        return Setting::query()->create($input);
    }

    public function update($input)
    {
       return Setting::first()->update($input);
    }
}
