<?php

namespace App\Exports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\FromCollection;
use App\Contract\Repositories\CarRepository;
 use Maatwebsite\Excel\Concerns\WithHeadings;
 use App\Transformers\ComplainExportTransformer;
 use Maatwebsite\Excel\Concerns\ShouldAutoSize;
 use Maatwebsite\Excel\Concerns\WithStyles;
 use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class CompainsExport implements FromCollection,WithHeadings,ShouldAutoSize,WithStyles
{
    private $complains;

    public function __construct($complains)
    {
        $this->complains = $complains;


    }

    public function collection()
    {

        return $this->complains;

    }

    public function headings(): array
    {
        return [
            [
                "Status",
                "Token",
                "Car",
                "Complainer",
                "Creator",
                "Responsible",
                "When",
                "Closed Within",
                "Type",
                "Description",
                "Comment #1",
                "Comment #2",
                "Comment #3",
                "Customer Review",
                "resolved-closed (Days)",
                "replace-investigating (Days)",
                "replace-closed (Days)",
                "investigating-closed (Days)",
                "investigating-replace (Days)",
                "investigating-open (Days)",
                "closed-closed (Days)",
                "closed-open (Days)",
                "open-investigating (Days)",
                "closed-reopen (Days)",
                "reopen-closed (Days)",
                "replace-resolved (Days)",
                "open-open (Days)",
                "investigating-resolved (Days)",
                "resolved-replace (Days)",
                "resolved-resolved (Days)",
                "open-closed (Days)",
                "investigating-investigating (Days)",
                "closed-replace (Days)",
                "replace-replace (Days)",
                "reopen-resolved (Days)",
                "resolved-investigating (Days)",
                "closed-resolved (Days)",
                "resolved-reopen (Days)",
                "reopen-replace (Days)",
                "resolved-open (Days)",
                "open-resolved (Days)"
            ]

        ];
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


