<?php

declare(strict_types=1);

namespace Bima\App\Http\Controller;

use Bima\Environment\Model\Environment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Inertia\Inertia;
use Inertia\Response;

/**
 * @author  Iqbal Maulana <iq.bluejack@gmail.com>
 */
class EnvironmentController
{
    public function index(): Response
    {
        return Inertia::render('Environment/Pages/Index', [
            'environments' => Environment::oldest('id')->get(),
        ]);
    }

    public function store(Request $request)
    {
        Validator::make($request->all(), [
            'name' => 'required|string|unique:environments'
        ])->validateWithBag('createEnvironment');

        Environment::create(['name' => $request->get('name')]);

        return back()->with(['message' => 'Environment created successfully!', 'alert-type' => 'success']);
    }

    public function update(string $environment, Request $request)
    {
        Validator::make($request->all(), [
            'name' => 'required|string|unique:environments'
        ])->validateWithBag('updateEnvironment');

        $environment = Environment::findOrFail($environment);
        $environment->name = $request->get('name');

        $environment->save();

        return back()->with(['message' => 'Environment updated successfully!', 'alert-type' => 'success']);
    }
}
