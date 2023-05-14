<?php

namespace App\Presenters;

use App\Transformers\FuelHistoryTransformer;
use Prettus\Repository\Presenter\FractalPresenter;

/**
 * Class FuelHistoryPresenter
 *
 * @package namespace App\Presenters;
 */
class FuelHistoryPresenter extends FractalPresenter
{
    /**
     * Transformer
     *
     * @return \League\Fractal\TransformerAbstract
     */
    public function getTransformer()
    {
        return new FuelHistoryTransformer();
    }
}
