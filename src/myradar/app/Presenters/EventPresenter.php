<?php

namespace App\Presenters;

use App\Transformers\EventTransformer;
use Prettus\Repository\Presenter\FractalPresenter;

/**
 * Class EventPresenter.
 *
 * @package namespace App\Presenters;
 */
class EventPresenter extends FractalPresenter
{
    /**
     * Transformer
     *
     * @return \League\Fractal\TransformerAbstract
     */
    public function getTransformer()
    {
        return new EventTransformer();
    }
}
