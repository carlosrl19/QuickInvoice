<?php

namespace App\Http\Controllers;

use App\Http\Requests\Banks\StoreRequest;
use App\Http\Requests\Banks\UpdateRequest;
use App\Models\Banks;
use App\Models\SystemLogs;
use Carbon\Carbon;

class BanksController extends Controller
{
    private function getTodayDate()
    {
        return Carbon::now()->setTimezone('America/Costa_Rica')->format('Y-m-d H:i:s');
    }

    public function index()
    {
        $banks = Banks::get();
        return view("modules.banks.index", compact("banks"));
    }


    public function store(StoreRequest $request)
    {
        try {

            Banks::create([
                'account_name' => $request->input('account_name'),
                'bank_name' => $request->input('bank_name'),
                'bank_account_number' => $request->input('bank_account_number'),
                'created_at' => $this->getTodayDate(),
                'updated_at' => $this->getTodayDate(),
            ]);

            SystemLogs::create([
                'module_log' => 'Clientes',
                'log_description' => 'Nuevo cliente ' . $request->input('client_name') . ' registrado.'
            ]);

            return redirect()->route("banks.index")->with("success", "Registro creado exitosamente.");
        } catch (\Exception $e) {
            return back()->with("error", "Ocurrió un error al crear el registro.")->withInput()->withErrors($e->getMessage());
        }
    }

    public function update(UpdateRequest $request, $id)
    {
        $bank = Banks::findOrFail($id);
        
        try {
            $bank->account_name = $request->input('account_name');
            $bank->bank_name = $request->input('bank_name');
            $bank->bank_account_number = $request->input('bank_account_number');
            $bank->update($request->all());

            SystemLogs::create([
                'module_log' => 'Bancos',
                'log_description' => 'Banco ' . $bank->bank_account_number . ' modificado.'
            ]);

            return redirect()->route("banks.index")->with("success", "Registro actualizado exitosamente.");
        } catch (\Exception $e) {
            return back()->with("error", "Ocurrió un error al actualizar el registro.");
        }
    }

    public function destroy($id)
    {
        $bank = Banks::findOrFail($id);

        // Verifica si el cliente tiene ventas o préstamos asociadas
        if ($bank->pos()->exists()) {
            return back()->with("error", "No se puede eliminar la cuenta de banco porque tiene ventas registradas.");
        }

        try {
            $bank->delete();

            SystemLogs::create([
                'module_log' => 'Bancos',
                'log_description' => 'Banco ' . $bank->bank_name . ' - ' . $bank->bank_account_number . ' eliminado.'
            ]);
            return redirect()->route("clients.index")->with("success", "Registro eliminado exitosamente.");
        } catch (\Exception $e) {
            return back()->with("error", "Ocurrió un error al eliminar el registro.");
        }
    }
}
