<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;

class PermissionController extends Controller
{


    function __construct()
    {
        $this->middleware('permission:permission-list|permission-create|permission-edit|permission-delete', ['only' => ['index', 'store']]);
        $this->middleware('permission:permission-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:permission-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:permission-delete', ['only' => ['destroy']]);
    }


    public function index(Request $request)
    {
        try {
            $permission = Permission::select('id', 'name')->get();
            return response()->json([
                'status' => 'success',
                'permissions' => $permission
            ], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|unique:permissions,name',
        ]);

        try {
            Permission::create(['name' => $request->input('name')]);
            return response()->json([
                'status' => 'success',
                'message' => "Permission created successfully"
            ], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }

    public function show($id)
    {
        try {
            $permission = Permission::find($id);
            return response()->json([
                'status' => 'success',
                'permission' => $permission
            ], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }


    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name' => 'required',
        ]);

        try {
            $permission = Permission::find($id);
            $permission->name = $request->input('name');
            $permission->save();

            return response()->json([
                'status' => 'success',
                'message' => "Permission updated successfully"
            ], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }

    public function destroy($id)
    {
        try {
            Permission::where('id', $id)->delete();
            return response()->json([
                'status' => 'success',
                'message' => "Permission deleted successfully"
            ], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }
}
