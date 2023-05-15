<?php

namespace App\Presenters;

use App\Transformers\TripTransformer;
use Prettus\Repository\Presenter\FractalPresenter;

/**
 * Class TripPresenter.
 *
 * @package namespace App\Presenters;
 */
class TripPresenter extends FractalPresenter
{
    /**
     * Transformer
     *
     * @return \League\Fractal\TransformerAbstract
     */
    public function getTransformer()
    {
        return new TripTransformer();
    }
}
