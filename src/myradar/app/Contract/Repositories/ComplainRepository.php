<?php

namespace App\Contract\Repositories;

use Prettus\Repository\Contracts\RepositoryInterface;
use Illuminate\Support\Collection;
/**
 * Interface ComplainRepository.
 *
 * @package namespace App\Contract\Repositories;
 */
interface ComplainRepository extends RepositoryInterface
{
  public function save(Collection $data);

  public function change(Collection $data);
}
