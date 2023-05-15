<?php

namespace App\Presenters;

use App\Transformers\GasHistoryTransformer;
use Prettus\Repository\Presenter\FractalPresenter;

/**
 * Class GasHistoryPresenter
 *
 * @package namespace App\Presenters;
 */
class GasHistoryPresenter extends FractalPresenter
{
    /**
     * Transformer
     *
     * @return \League\Fractal\TransformerAbstract
     */
    public function getTransformer()
    {
        return new GasHistoryTransformer();
    }
}
