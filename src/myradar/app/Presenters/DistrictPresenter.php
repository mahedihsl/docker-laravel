<?php

namespace App\Presenters;

use App\Transformers\DistrictTransformer;
use Prettus\Repository\Presenter\FractalPresenter;

/**
 * Class DistrictPresenter
 *
 * @package namespace App\Presenters;
 */
class DistrictPresenter extends FractalPresenter
{
    /**
     * Transformer
     *
     * @return \League\Fractal\TransformerAbstract
     */
    public function getTransformer()
    {
        return new DistrictTransformer();
    }
}
