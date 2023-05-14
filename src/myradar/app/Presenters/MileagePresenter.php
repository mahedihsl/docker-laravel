<?php

namespace App\Presenters;

use App\Transformers\MileageTransformer;
use Prettus\Repository\Presenter\FractalPresenter;

/**
 * Class MileagePresenter
 *
 * @package namespace App\Presenters;
 */
class MileagePresenter extends FractalPresenter
{
    /**
     * Transformer
     *
     * @return \League\Fractal\TransformerAbstract
     */
    public function getTransformer()
    {
        return new MileageTransformer();
    }
}
