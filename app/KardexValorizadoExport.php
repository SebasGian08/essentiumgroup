<?php

namespace BolsaTrabajo;

use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;

class KardexValorizadoExport implements
    FromCollection,
    WithHeadings,
    WithEvents,
    ShouldAutoSize
{
    protected $inicio;
    protected $fin;

    public function __construct($inicio, $fin)
    {
        $this->inicio = $inicio;
        $this->fin = $fin;
    }

    public function collection()
    {
        return collect(DB::select(
            'CALL sp_excel_kardex(?, ?)',
            [$this->inicio, $this->fin]
        ));
    }

    public function headings(): array
    {
        return [
            'Fecha Movimiento',
            'Producto',
            'Tipo Movimiento',
            'Motivo Movimiento',
            'Cantidad',
            'Cantidad Anterior',
            'Cantidad Saldo',
            'Costo Unitario',
            'Costo Total'
        ];
    }

    public function registerEvents(): array
    {
        return [

            AfterSheet::class => function (AfterSheet $event) {

                $sheet = $event->sheet->getDelegate();
                $lastRow = $sheet->getHighestRow();
                $lastCol = $sheet->getHighestColumn();

                /* =====================
                   FILTROS EXCEL
                   ===================== */
                $sheet->setAutoFilter("A1:{$lastCol}{$lastRow}");

                /* =====================
                   CONGELAR ENCABEZADO
                   ===================== */
                $sheet->freezePane('A2');

                /* =====================
                   NEGRITA ENCABEZADOS
                   ===================== */
                $sheet->getStyle("A1:{$lastCol}1")
                    ->getFont()->setBold(true);

                /* =====================
                   FORMATO NUMÉRICO
                   ===================== */
                $sheet->getStyle("E2:G{$lastRow}")
                    ->getNumberFormat()
                    ->setFormatCode(NumberFormat::FORMAT_NUMBER);

                $sheet->getStyle("H2:I{$lastRow}")
                    ->getNumberFormat()
                    ->setFormatCode('"S/ " #,##0.00');


            }
        ];
    }
}
