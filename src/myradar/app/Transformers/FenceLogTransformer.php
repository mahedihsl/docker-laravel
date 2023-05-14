<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Entities\FenceLog;
use App\Entities\Car;

/**
 * Class FenceLogTransformer
 * @package namespace App\Transformers;
 */
class FenceLogTransformer extends TransformerAbstract
{
    /**
     * @var App\Entities\Car
     */
    private $car;

    public function __construct(Car $car)
    {
        $this->car = $car;
    }

    private function isSelected($fence_id) {
        return isset($this->car->fence_ids)
            && is_array($this->car->fence_ids)
            && in_array($fence_id, $this->car->fence_ids);
    }

    private function getFullName($fence)
    {
        if ($fence->thana_id) {
            $thana = $fence->thana;
            $district = $thana->district;
            return implode(', ', [$fence->name, $thana->name, $district->name]);
        }

        return $fence->name;
    }

    /**
     * Transform the \FenceLog entity
     * @param \FenceLog $model
     *
     * @return array
     */
    public function transform(FenceLog $model)
    {
        return [
            'id' => $model->fence->id,
            'name' => $this->getFullName($model->fence),
            'selected' => $this->isSelected($model->fence->id),
        ];
    }
}
