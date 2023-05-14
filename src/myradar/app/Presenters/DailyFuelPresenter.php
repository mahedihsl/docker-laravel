<?php

namespace App\Presenters;

use App\Transformers\DailyFuelTransformer;
use Prettus\Repository\Presenter\FractalPresenter;

/**
 * Class DailyFuelPresenter
 *
 * @package namespace App\Presenters;
 */
class DailyFuelPresenter extends FractalPresenter
{
    /**
     * Transformer
     *
     * @return \League\Fractal\TransformerAbstract
     */
    public function getTransformer()
    {
        return new DailyFuelTransformer();
    }
}
