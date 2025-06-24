<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use App\Http\Requests\Permissions\StoreRequest;
use App\Http\Requests\Permissions\UpdateRequest;
use Proengsoft\JsValidation\Facades\JsValidatorFacade;

class PermissionsController extends Controller
{
    public function index()
    {
        $permissions = Permission::get();
        $validator = JsValidatorFacade::formRequest(StoreRequest::class);
        return view('modules.sysadmin.permissions.index', compact(
            'permissions',
            'validator',
        ));
    }

    public function edit($id)
    {
        $permission = Permission::findOrFail($id);
        $validator = JsValidatorFacade::formRequest(UpdateRequest::class);
        return view('modules.sysadmin.permissions.update', compact(
            'permission',
            'validator',
        ));
    }

    public function store(StoreRequest $request)
    {
        $permission = Permission::create([
            'name' => $request->name,
            'permission_description' => $request->permission_description,
            'guard_name' => "web",
        ]);

        return redirect()->route('permissions.index')->with('success', 'Registro creado exitosamente.');
    }

    public function update(UpdateRequest $request, Permission $permission)
    {
        $permission->update($request->all());
        return redirect()->route("permissions.index")->with("success", "Registro actualizado exitosamente.");
    }

    public function destroy($id)
    {
        $permission = Permission::findOrFail($id);
        $permission->delete();

        return redirect()->route("permissions.index")->with("success", "Registro elimnado exitosamente.");
    }
}
