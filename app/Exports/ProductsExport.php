<?php

namespace App\Exports;

use App\Models\Products;
use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\WithProperties;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;

class ProductsExport implements FromView, WithProperties, WithEvents, WithTitle, WithColumnFormatting
{
    public function view(): View
    {
        // Obtener inventario
        $inventories = Products::orderBy('product_price', 'desc')->get();

        $inventory_total_value = Products::sum('product_price');

        return view('modules.exports.products.inventory', [
            'inventories' => $inventories,
            'inventory_total_value' => $inventory_total_value,
        ]);
    }

    public function properties(): array
    {
        return [
            'title' => 'INVENTARIO ROBENIOR SYSTEM',
            'creator' => 'ROBENIOR SYSTEM 01',
        ];
    }

    public function title(): string
    {
        return 'INVENTARIO';
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $sheet = $event->sheet->getDelegate();
                $startRow = 4; // Inicio de la fila a partir de la cual se realizará el merge
                $endRow = $sheet->getHighestRow(); // Obtener la última fila modificada
                while ($startRow <= $endRow) {
                    //$sheet->mergeCells('E' . $startRow . ':F' . $startRow);
                    $startRow += 1;
                }
            },
        ];
    }

    public function columnFormats(): array
    {
        return [
            /*
            Tipo contabilidad con simbolo L:
                Formato contable: El formato '_("L"* #,##0.00_);_("L"* $$#,##0.00$$;_("L"* "-"??_);_(@_) se utiliza para definir cómo se mostrarán los números en la columna:
                _("L"* #,##0.00_): Muestra números positivos con el símbolo "L" seguido del valor.
                _("L"* $$#,##0.00$$: Muestra números negativos entre paréntesis con el símbolo "L".
                _("L"* "0"??_): Muestra un 0 si el valor es cero.
                _(@_): Este es el formato para texto.
            */


            'B' => NumberFormat::FORMAT_TEXT, // Code
            'C' => NumberFormat::FORMAT_TEXT, // Name
            'D' => NumberFormat::FORMAT_TEXT, // Nomenclature
            'E' => NumberFormat::FORMAT_TEXT, // Brand
            'F' => NumberFormat::FORMAT_TEXT, // Brand 
            'G' => '_("L"* #,##0.00_);_("L"* #,##0.00;_("L"* "-"??_);_(@_)',    // Transfer amount
        ];
    }
}
