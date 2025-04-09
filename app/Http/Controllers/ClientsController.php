<?php

namespace App\Http\Controllers;

use App\Http\Requests\Clients\StoreRequest;
use App\Http\Requests\Clients\UpdateRequest;
use App\Models\Clients;
use App\Models\SystemLogs;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ClientsController extends Controller
{
    private function getTodayDate()
    {
        return Carbon::now()->setTimezone('America/Costa_Rica')->format('Y-m-d H:i:s');
    }

    public function index(Request $request)
    {
        // Obtener la letra seleccionada o la letra 'A' por defecto
        $selectedLetter = $request->input('letter', 'A');

        // Obtener todas las letras iniciales de los nombres en mayúsculas
        $letters = Clients::selectRaw('UPPER(LEFT(client_name, 1)) as initial')
            ->groupBy('initial')
            ->orderBy('initial')
            ->pluck('initial');

        $clients = Clients::where('client_name', 'LIKE', $selectedLetter . '%')
            ->orderBy('client_name')
            ->paginate(500);

        return view('modules.clients.index', compact(
            'clients',
            'letters',
            'selectedLetter'
        ));
    }

    public function store(StoreRequest $request)
    {
        try {
            // Obtener el último ID para generar el código
            $lastClient = Clients::latest()->first();
            $nextId = $lastClient ? $lastClient->id + 1 : 1;

            $clientCodeNumber = 'CL' . str_pad($nextId, 7, '0', STR_PAD_LEFT);

            Clients::create([
                'client_code' => $clientCodeNumber,
                'client_name' => $request->input('client_name'),
                'client_document' => $request->input('client_document'),
                'client_type' => $request->input('client_type'),
                'client_phone1' => $request->input('client_phone1'),
                'client_phone2' => $request->input('client_phone2'),
                'client_birthdate' => $request->input('client_birthdate'),
                'client_phone_home' => $request->input('client_phone_home'),
                'client_actual_job' => $request->input('client_actual_job'),
                'client_job_length' => $request->input('client_job_length'),
                'client_phone_work' => $request->input('client_phone_work'),
                'client_last_job' => $request->input('client_last_job'),
                'client_own_business' => $request->input('client_own_business'),
                'client_email' => $request->input('client_email'),
                'client_exonerated' => $request->input('client_exonerated'),
                'client_status' => 1,
                'client_address' => $request->input('client_address'),
                'created_at' => $this->getTodayDate(),
                'updated_at' => $this->getTodayDate(),
            ]);

            SystemLogs::create([
                'module_log' => 'Clientes',
                'log_description' => 'Nuevo cliente ' . $request->input('client_name') . ' registrado.'
            ]);

            return back()->with("success", "Registro creado exitosamente.");
        } catch (\Exception $e) {
            return back()->with("error", "Ocurrió un error al crear el registro.")->withInput()->withErrors($e->getMessage());
        }
    }

    public function edit($id)
    {
        $client = Clients::findOrFail($id);
        return view('modules.clients.update', compact('client'));
    }

    public function update(UpdateRequest $request, Clients $client)
    {
        try {
            //Required data
            $client->client_name = $request->input('client_name');
            $client->client_document = $request->input('client_document');
            $client->client_type = $request->input('client_type');
            $client->client_phone1 = $request->input('client_phone1');

            // No required data (nullable)
            $client->client_phone2 = $request->input('client_phone2');
            $client->client_birthdate = $request->input('client_birthdate');
            $client->client_phone_home = $request->input('client_phone_home');
            $client->client_actual_job = $request->input('client_actual_job');
            $client->client_job_length = $request->input('client_job_length');
            $client->client_phone_work = $request->input('client_phone_work');
            $client->client_last_job = $request->input('client_last_job');
            $client->client_own_business = $request->input('client_own_business');
            $client->client_email = $request->input('client_email');
            $client->client_exonerated = $request->input('client_exonerated');
            $client->client_status = $request->input('client_status');
            $client->client_address = $request->input('client_address');
            $client->updated_at = $this->getTodayDate();
            $client->update($request->all());

            SystemLogs::create([
                'module_log' => 'Clientes',
                'log_description' => 'Cliente ' . $request->input('client_name') . ' modificado.'
            ]);

            return redirect()->route("clients.index")->with("success", "Registro actualizado exitosamente.");
        } catch (\Exception $e) {
            return back()->with("error", "Ocurrió un error al actualizar el registro.")->withInput()->withErrors($e->getMessage());
        }
    }

    public function destroy($id)
    {
        $client = Clients::findOrFail($id);

        // Verifica si el cliente tiene ventas o préstamos asociadas
        if ($client->pos()->exists() || $client->loans()->exists()) {
            return back()->with("error", "No se puede eliminar el cliente porque tiene ventas o préstamos registrados.");
        }

        try {
            $client->delete();

            SystemLogs::create([
                'module_log' => 'Clientes',
                'log_description' => 'Cliente ' . $client->client_name . ' eliminado.'
            ]);
            return redirect()->route("clients.index")->with("success", "Registro eliminado exitosamente.");
        } catch (\Exception $e) {
            return back()->with("error", "Ocurrió un error al eliminar el registro.")->withInput()->withErrors($e->getMessage());
        }
    }
}
