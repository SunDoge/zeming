<?php

namespace App\Http\Controllers;

use App\App;
use Illuminate\Http\Request;

class AppController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function index()
    {
        $apps = App::select('name', 'version', 'change_log', 'install_url')->get();
        if (!$apps) {
            return response()->json(['error' => 'No app'], 404);
        }
        return response()->json($apps);
    }

    public function show($name)
    {
        $app = App::select('name', 'version', 'change_log', 'install_url')
            ->where('name', $name)
            ->get();
        if (!$app) {
            return response()->json(['error' => 'No such app'], 404);
        }
        return response()->json($app);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|unique:apps',
            'version' => 'required',
            'change_log' => 'required',
            'install_url' => 'required',
        ]);
        $input = $request->only(['name', 'version', 'change_log', 'install_url']);
        $result = App::create($input);
        if (!$result) {
            return response()->json(['error' => 'Create failed'], 400);
        }
        return response()->json($result, 201);
    }

    public function replace(Request $request, $name)
    {
        $this->validate($request, [
            'name' => 'required',
            'version' => 'required',
            'change_log' => 'required',
            'install_url' => 'required',
        ]);
        $input = $request->only('name', 'version', 'change_log', 'install_url');
        $app = App::where('name', $name)
            ->first();
        if (!$app) {
            return response()->json(['error' => 'App not found'], 404);
        }
        $app->fill($input);
        $result = $app->save();
        if (!$result) {
            return response()->json(['error' => 'Put failed'], 400);
        }
        return response()->json($app, 201);
    }

    public function update(Request $request, $name)
    {
        $input = $request->only('name', 'version', 'change_log', 'install_url');
        $input = array_filter($input);
        $app = App::where('name', $name)
            ->first();
        if (!$app) {
            return response()->json(['error' => 'App not found'], 404);
        }
        foreach ($input as $key => $item) {
            $app->$key = $item;
        }
        $result = $app->save();
        if (!$result) {
            return response()->json(['error' => 'Patch failed'], 400);
        }
        return response()->json($app, 201);
    }

    public function destroy($name)
    {
        $app = App::where('name', $name);
        if (!$app) {
            return response()->json(['error' => 'App not found'], 404);
        }
        $result = $app->delete();
        if (!$result) {
            return response()->json(['error' => 'Delete failed'], 400);
        }
        return response()->json($result, 204);
    }
}
