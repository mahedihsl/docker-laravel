<?php

namespace App\Contract\Repositories;

use Prettus\Repository\Contracts\RepositoryInterface;
use Illuminate\Support\Collection;
use App\Entities\Car;
use App\Entities\User;

/**
 * Interface SettingRepository
 * @package namespace App\Contract\Repositories;
 */
interface SettingRepository extends RepositoryInterface
{
    public function change($id, Collection $data);
    public function enterSave(User $user, Car $car);
}
