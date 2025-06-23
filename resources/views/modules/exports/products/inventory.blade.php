<table>
    <thead>
        <tr class="text-center">
            <th></th>
        </tr>
    </thead>
    <tbody>
        <!-- Header text -->
        <tr style="border: 1px solid #000">
            <td></td>
            <td colspan="7"
                style="font-size: 16pt; font-weight: bold; background-color: #fff; text-align: center; text-decoration: underline;">
                INVENTARIO ROBENIOR SYSTEM 01
            </td>
        </tr>

        <!-- Blank rows -->
        <tr>
            <td></td>
            <td colspan="7" style="background-color: #fff"></td>
        </tr>

        <!-- Header table -->
        <tr>
            <td style="height: 40px"></td>
            <td style="border: 1px solid #000; color: #ffffff; background-color: #D70654; font-size: 14pt; font-weight: bold; text-align: center; width: 300px;">
                NOMBRE
            </td>
            <td style="border: 1px solid #000; color: #ffffff; background-color: #D70654; font-size: 14pt; font-weight: bold; text-align: center; width: 170px;">
                NOMENCLATURA
            </td>
            <td style="border: 1px solid #000; color: #ffffff; background-color: #D70654; font-size: 14pt; font-weight: bold; text-align: center; width: 140px;">
                MARCA
            </td>
            <td style="border: 1px solid #000; color: #ffffff; background-color: #D70654; font-size: 14pt; font-weight: bold; text-align: center; width: 180px;">
                MODELO
            </td>
            <td style="border: 1px solid #000; color: #ffffff; background-color: #D70654; font-size: 14pt; font-weight: bold; text-align: center; width: 110px;">
                ESTADO
            </td>
            <td style="border: 1px solid #000; color: #ffffff; background-color: #D70654; font-size: 14pt; font-weight: bold; text-align: center; width: 120px;">
                PRECIO
            </td>
        </tr>

        @foreach($inventories as $inventory)
        <tr>
            <td style="height: 30px;"></td>
            <td style="border: 1px solid #000; text-align: center; font-size: 12pt;">{{ $inventory->product_name }}</td>
            <td style="border: 1px solid #000; text-align: center; font-size: 12pt;">{{ $inventory->product_nomenclature }}</td>
            <td style="border: 1px solid #000; text-align: center; font-size: 12pt;">{{ $inventory->product_brand }}</td>
            <td style="border: 1px solid #000; text-align: center; font-size: 12pt;">{{ $inventory->product_model ? $inventory->product_model : '--' }}</td>
            @if($inventory->product_status == 0)
            <td style="border: 1px solid #000; text-align: center; color: red; font-size: 11pt; font-weight: bold">MALO</td>
            @elseif($inventory->product_status == 1)
            <td style="border: 1px solid #000; text-align: center; color: #9DC08B; font-size: 11pt; font-weight: bold">NUEVO</td>
            @elseif($inventory->product_status == 2)
            <td style="border: 1px solid #000; text-align: center; color: orange; font-size: 11pt; font-weight: bold">SEMINUEVO</td>
            @elseif($inventory->product_status == 3)
            <td style="border: 1px solid #000; text-align: center; color: darkgray; font-size: 11pt; font-weight: bold">USADO</td>
            @else
            <td style="border: 1px solid #000; text-align: center; background-color: #000000; color: #ffffff; font-size: 11pt; font-weight: bold">ERROR</td>
            @endif

            <td style="border: 1px solid #000; text-align: center; font-size: 12pt;">{{ $inventory->product_price }}</td>
        </tr>
        @endforeach

        <tr></tr>
        <!-- Total Project Investment Row -->
        <tr>
            <td style="height: 30px"></td>
            <td colspan="5"
                style="border: 1px solid #000; color: #ffffff; background-color: #D70654; border-top: 1px solid #000; text-align: center; font-weight: bold; font-size: 14pt;">
                TOTAL GENERAL
            </td>
            <td
                style="border: 1px solid #000; color: #ffffff; background-color: #D70654; border-top: 1px solid #000; text-align: center; font-weight: bold; font-size: 14pt;">
                {{ $inventory_total_value }} <!-- Formateo a dos decimales -->
            </td>
        </tr>

    </tbody>
</table>