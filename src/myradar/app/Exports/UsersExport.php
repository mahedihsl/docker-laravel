<?php

namespace App\Exports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\FromCollection;
use App\Contract\Repositories\CarRepository;

class UsersExport implements FromCollection
{
    private $repository;

    public function __construct(CarRepository $repository)
    {
        $this->repository = $repository;
    }

    public function collection()
    {

        return $this->repository->all();

        $collection = collect([
            (object) [
                'website' => 'twitter',
                'url' => 'twitter.com'
            ],
            (object) [
                'website' => 'google',
                'url' => 'google.com'
            ]
        ]);
        return $collection;

        //return User::all();
    }
}
