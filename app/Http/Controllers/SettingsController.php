<?php

namespace App\Http\Controllers;

use App\Http\Requests\Settings\StoreRequest;
use App\Http\Requests\Settings\UpdateRequest;
use App\Models\Seller;
use App\Models\Settings;
use App\Models\SystemLogs;
use RahulHaque\Filepond\Filepond;

class SettingsController extends Controller
{
    public function index()
    {
        $setting = Settings::first();
        return view('modules.settings.index', compact('setting'));
    }

    public function create()
    {
        $sellers = Seller::get();
        return view('modules.settings.create', compact('sellers'));
    }

    public function edit($id)
    {
        $setting = Settings::findOrFail($id);
        $sellers = Seller::get();
        return view('modules.settings.update', compact('setting', 'sellers'));
    }

    public function store(StoreRequest $request)
    {
        if (Settings::first()) {
            return redirect()->route('settings.index')->with('error', 'Ya existe una configuración guardada');
        }

        try {
            // Procesar y guardar la imagen para 'logo_company'
            $logoCompany = null;
            if ($request->hasFile('logo_company')) {
                $image = $request->file('logo_company');
                $imageName = 'logo_company.' . $image->getClientOriginalExtension();
                $image->move(storage_path('app/public/sys_config/img/'), $imageName);
                $logoCompany = $imageName; // Ruta relativa para el enlace simbólico
            }

            // Procesar y guardar la imagen para 'system_icon'
            $systemIcon = null;
            if ($request->hasFile('system_icon')) {
                $icon = $request->file('system_icon');
                $iconName = 'system_icon.' . $icon->getClientOriginalExtension();
                $icon->move(storage_path('app/public/sys_config/img/'), $iconName);
                $systemIcon = $iconName; // Ruta relativa para el enlace simbólico
            }

            // Crear el registro en la base de datos
            Settings::create([
                'logo_company' => $logoCompany,
                'system_icon' => $systemIcon,
                'show_system_name' => $request->input('show_system_name'),
                'company_name' => $request->input('company_name'),
                'company_cai' => $request->input('company_cai'),
                'company_rtn' => $request->input('company_rtn'),
                'company_phone' => $request->input('company_phone'),
                'company_email' => $request->input('company_email'),
                'company_address' => $request->input('company_address'),
                'company_short_address' => $request->input('company_short_address'),
                'default_currency_symbol' => $request->input('default_currency_symbol'),
                'default_seller_id' => $request->input('default_seller_id'),
            ]);

            SystemLogs::create([
                'module_log' => 'Configuración',
                'log_description' => 'Configuración del sistema creada.'
            ]);

            return redirect()->route('settings.index')->with('success', 'Configuración guardada correctamente');
        } catch (\Exception $e) {
            return back()->with("error", "Ocurrió un error al crear el registro.")->withInput()->withErrors($e->getMessage());
        }
    }

    public function update(UpdateRequest $request, $id)
    {
        $settings = Settings::find($id);

        try {
            // Procesar el logo de la empresa (si se subió)
            $logoFilepond = app(Filepond::class)->field($request->input('logo_company'));
            $logo = $logoFilepond ? $logoFilepond->getFile() : null;

            if ($logo instanceof \Illuminate\Http\UploadedFile) {
                $imageName = 'logo_company.' . $logo->getClientOriginalExtension();

                // Crear carpeta si no existe
                $folderPath = storage_path('app/public/sys_config/img/');
                if (!file_exists($folderPath)) {
                    mkdir($folderPath, 0775, true);
                }

                // Eliminar cualquier archivo que empiece con "logo_company" en la carpeta
                foreach (glob($folderPath . 'logo_company.*') as $file) {
                    unlink($file);
                }

                $logo->move($folderPath, $imageName);
                $settings->logo_company = $imageName;
            }

            // Procesar el ícono del sistema (si se subió)
            $iconFilepond = app(Filepond::class)->field($request->input('system_icon'));
            $icon = $iconFilepond ? $iconFilepond->getFile() : null;

            if ($icon instanceof \Illuminate\Http\UploadedFile) {
                $oldIconPath = storage_path('app/public/sys_config/img/') . $settings->system_icon;
                if (file_exists($oldIconPath)) {
                    unlink($oldIconPath);
                }

                $iconName = 'system_icon.' . $icon->getClientOriginalExtension();

                // Crear carpeta si no existe
                $folderPath = storage_path('app/public/sys_config/img/');
                if (!file_exists($folderPath)) {
                    mkdir($folderPath, 0775, true);
                }

                // Eliminar cualquier archivo que empiece con "system_icon" en la carpeta
                foreach (glob($folderPath . 'system_icon.*') as $file) {
                    unlink($file);
                }

                $icon->move($folderPath, $iconName);
                $settings->system_icon = $iconName;
            }

            // Actualizar otros campos
            $settings->show_system_name = $request->input('show_system_name');
            $settings->company_name = $request->input('company_name');
            $settings->company_cai = $request->input('company_cai');
            $settings->company_rtn = $request->input('company_rtn');
            $settings->company_phone = $request->input('company_phone');
            $settings->company_email = $request->input('company_email');
            $settings->company_address = $request->input('company_address');
            $settings->company_short_address = $request->input('company_short_address');
            $settings->default_currency_symbol = $request->input('default_currency_symbol');
            $settings->default_seller_id = $request->input('default_seller_id');

            $settings->save();

            SystemLogs::create([
                'module_log' => 'Configuración',
                'log_description' => 'Configuración del sistema actualizada.'
            ]);

            return back()->with('success', 'Configuración actualizada correctamente');
        } catch (\Exception $e) {
            return back()
                ->with("error", "Ocurrió un error al actualizar el registro.")
                ->withInput()
                ->withErrors($e->getMessage());
        }
    }
}
