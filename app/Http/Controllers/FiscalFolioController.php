<?php

namespace App\Http\Controllers;

use App\Http\Requests\FiscalFolios\StoreRequest;
use App\Models\FiscalFolio;
use App\Models\SystemLogs;
use Carbon\Carbon;

class FiscalFolioController extends Controller
{
    private function getTodayDate()
    {
        return Carbon::now()->setTimezone('America/Costa_Rica')->format('Y-m-d H:i:s');
    }

    public function index()
    {
        $fiscal_folios = FiscalFolio::get();
        return view('modules.fiscal_folios.index', compact('fiscal_folios'));
    }

    public function store(StoreRequest $request)
    {
        try {
            FiscalFolio::create($request->all());

            SystemLogs::create([
                'module_log' => 'Folios',
                'log_description' => 'Nuevo folio fiscal ' . $request->input('folio_authorized_range_start') . ' al ' . $request->input('folio_authorized_range_end') . ' (fecha límite ' . $request->input('folio_authorized_emission_date') . ').'
            ]);

            return redirect()->route('fiscalfolio.index')->with('success', 'Registro creado exitosamente.');
        } catch (\Exception $e) {
            return back()->with("error", "Ocurrió un error al crear el registro.")->withInput()->withErrors($e->getMessage());
        }
    }

    public function use_folio($id)
    {
        $folio = FiscalFolio::findOrFail($id);
        $folio_days_validation = number_format(Carbon::now()->diffInDays($folio->folio_authorized_emission_date, 0));

        if ($folio->folio_validation_status == 0 || $folio_days_validation == 0) {
            return back()->with("error", "El folio seleccionado no está vigente para su uso.")->withInput();
        }

        try {
            // Actualiza todos los folios a folio_status = 0
            FiscalFolio::where('folio_status', 1)->update(['folio_status' => 0]);

            // Establece el folio seleccionado a folio_status = 1
            $folio->folio_status = 1;
            $folio->update();

            SystemLogs::create([
                'module_log' => 'Folios',
                'log_description' => 'Cambio de folio fiscal ' . $folio->folio_authorized_range_start . ' al ' . $folio->folio_authorized_range_end . ' (fecha límite ' . $folio->folio_authorized_emission_date . ').'
            ]);

            return redirect()->route('fiscalfolio.index')->with('success', 'Registro actualizado exitosamente.');
        } catch (\Exception $e) {
            return back()->with("error", "Ocurrió un error al actualizar el registro.")->withInput()->withErrors($e->getMessage());
        }
    }
}
