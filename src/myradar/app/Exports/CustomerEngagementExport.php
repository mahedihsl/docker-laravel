<?php

namespace App\Exports;


use Maatwebsite\Excel\Concerns\FromCollection;
 use Maatwebsite\Excel\Concerns\WithHeadings;
 use Maatwebsite\Excel\Concerns\ShouldAutoSize;
 use Maatwebsite\Excel\Concerns\WithStyles;
 use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class CustomerEngagementExport implements FromCollection,ShouldAutoSize,WithStyles,WithHeadings
{
    private $data;

    public function __construct($data)
    {
        $this->data = $data;


    }

    public function collection()
    {

        return $this->data;

    }

    public function headings(): array
    {
       return array_keys($this->data[0]);
    }






    public function styles(Worksheet $sheet)
    {
        $sheet->getStyle('1')->applyFromArray([
            'font' => [
                'bold' => true,
            ],
            'fill' => [
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                'startColor' => [
                    'rgb' => 'BAD4D2',
                ],
            ],
        ]);
    }



}


