<?php

namespace App\Http\Controllers;

use App\Http\Requests\Users\StoreRequest;
use App\Http\Requests\Users\UpdateRequest;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Proengsoft\JsValidation\Facades\JsValidatorFacade;
use RahulHaque\Filepond\Filepond;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    public function index()
    {
        $users = User::get();
        $roles = Role::all();
        $validator = JsValidatorFacade::formRequest(StoreRequest::class);

        return view('modules.sysadmin.users.index', compact(
            'users',
            'roles',
            'validator',
        ));
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);
        $roles = Role::all();
        $validator = JsValidatorFacade::formRequest(UpdateRequest::class);
        return view('modules.sysadmin.users.update', compact(
            'user',
            'roles',
            'validator',
        ));
    }

    public function store(StoreRequest $request)
    {
        DB::beginTransaction();

        try {
            // Guardar el nombre de la imagen directamente
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => bcrypt($request->password),
            ]);

            // Manejo de imagen con FilePond
            $imageFilepond = app(Filepond::class)->field($request->input('profile_photo'));
            $image = $imageFilepond?->getFile();

            if ($image instanceof \Illuminate\Http\UploadedFile) {
                $fileName = uniqid() . '.' . $image->getClientOriginalExtension();
                $folderPath = storage_path('app/public/uploads/users/');
                if (!file_exists($folderPath)) {
                    mkdir($folderPath, 0775, true);
                }
                $image->move($folderPath, $fileName);
                $user->profile_photo = $fileName;
                $user->save();
            }

            // Asignar el rol al usuario
            $user->assignRole($request->role);

            DB::commit();

            return redirect()->route('users.index')->with('success', 'Registro creado exitosamente.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->withErrors(['error' => $e->getMessage()])->withInput();
        }
    }

    public function update(UpdateRequest $request, $id)
    {
        $user = User::findOrFail($id);

        DB::beginTransaction();

        try {
            // Manejo de imagen con FilePond
            $imageFilepond = app(Filepond::class)->field($request->input('profile_photo'));
            $image = $imageFilepond ? $imageFilepond->getFile() : null;

            if ($image instanceof \Illuminate\Http\UploadedFile) {
                // Eliminar imagen anterior si existe
                if ($user->profile_photo && $user->profile_photo !== 'no_image_available.png') {
                    $oldImagePath = storage_path('app/public/uploads/users/') . $user->profile_photo;
                    if (file_exists($oldImagePath)) {
                        unlink($oldImagePath);
                    }
                }

                // Guardar nueva imagen
                $fileName = uniqid() . '.' . $image->getClientOriginalExtension();
                $folderPath = storage_path('app/public/uploads/users/');

                if (!file_exists($folderPath)) {
                    mkdir($folderPath, 0775, true);
                }

                $image->move($folderPath, $fileName);
                $user->profile_photo = $fileName;
            }
            // Si no se sube imagen, mantener la existente

            // Actualizar otros campos del usuario según sea necesario
            $user->name = $request->name;
            $user->email = $request->email;

            // Solo actualizar la contraseña si se proporciona una nueva
            if ($request->filled('password')) {
                $user->password = bcrypt($request->password);
            }

            // Asignar el nuevo rol al usuario
            // Primero, eliminar roles existentes (si es necesario)
            $user->syncRoles([$request->role]);

            // Guardar los cambios
            $user->save();

            DB::commit();

            return redirect()->route('users.index')->with('success', 'Registro actualizado exitosamente.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->withErrors(['error' => $e->getMessage()])->withInput();
        }
    }

    public function show($id)
    {
        $user = User::findOrFail($id);

        return view('modules.users.show', compact(
            'user',
        ));
    }

    public function destroy($id)
    {
        $userToDelete = User::findOrFail($id);
        $currentUser = auth()->user();

        // Verificar si el usuario a eliminar es el mismo que el usuario autenticado
        if ($userToDelete->id === $currentUser->id) {
            return redirect()->back()->withErrors(['error' => 'No puede eliminar su propio usuario.']);
        }

        // Proceder con la eliminación
        $userToDelete->delete();
        return redirect()->route('users.index')->with('success', 'Registro eliminado correctamente.');
    }
}
