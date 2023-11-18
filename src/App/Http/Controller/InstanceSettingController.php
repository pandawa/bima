<?php

declare(strict_types=1);

namespace Bima\App\Http\Controller;

use Bima\Environment\Model\Environment;
use Bima\Instance\Model\Instance;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Inertia\Inertia;

/**
 * @author  Iqbal Maulana <iq.bluejack@gmail.com>
 */
class InstanceSettingController
{
    public function show(int $instance)
    {
        return Inertia::render('Instance/Pages/Setting', [
            'instance'     => Instance::findOrFail($instance),
            'environments' => Environment::oldest('id')->get(),
        ]);
    }

    public function update(int $id, Request $request)
    {
        $data = Validator::make($request->all(), [
            'name'           => 'required|string',
            'url'            => 'required|url',
            'environment_id' => 'required|exists:environments,id',
        ])->validateWithBag('updateInstance');

        Instance::findOrfail($id)->fill($data)->save();

        return back();
    }

    public function regenerate(int $id)
    {
        $instance = Instance::findOrfail($id);
        $instance->secret = Instance::generateSecret();
        $instance->save();

        return back();
    }

    public function delete(int $id)
    {
        Instance::findOrFail($id)->delete();

        return to_route('instance.list');
    }
}
