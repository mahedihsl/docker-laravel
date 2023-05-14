<?php

namespace App\Presenters;

use App\Transformers\DailyGasTransformer;
use Prettus\Repository\Presenter\FractalPresenter;

/**
 * Class DailyGasPresenter
 *
 * @package namespace App\Presenters;
 */
class DailyGasPresenter extends FractalPresenter
{
    /**
     * Transformer
     *
     * @return \League\Fractal\TransformerAbstract
     */
    public function getTransformer()
    {
        return new DailyGasTransformer();
    }
}
