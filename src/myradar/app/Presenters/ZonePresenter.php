<?php

namespace App\Presenters;

use App\Transformers\ZoneTransformer;
use Prettus\Repository\Presenter\FractalPresenter;

/**
 * Class ZonePresenter.
 *
 * @package namespace App\Presenters;
 */
class ZonePresenter extends FractalPresenter
{
    /**
     * Transformer
     *
     * @return \League\Fractal\TransformerAbstract
     */
    public function getTransformer()
    {
        return new ZoneTransformer();
    }
}
