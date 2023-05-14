<?php

namespace App\Presenters;

use App\Transformers\FenceTransformer;
use Prettus\Repository\Presenter\FractalPresenter;

/**
 * Class FencePresenter
 *
 * @package namespace App\Presenters;
 */
class FencePresenter extends FractalPresenter
{
    /**
     * Transformer
     *
     * @return \League\Fractal\TransformerAbstract
     */
    public function getTransformer()
    {
        return new FenceTransformer();
    }
}
