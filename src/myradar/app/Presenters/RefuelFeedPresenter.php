<?php

namespace App\Presenters;

use App\Transformers\RefuelFeedTransformer;
use Prettus\Repository\Presenter\FractalPresenter;

/**
 * Class RefuelFeedPresenter.
 *
 * @package namespace App\Presenters;
 */
class RefuelFeedPresenter extends FractalPresenter
{
    /**
     * Transformer
     *
     * @return \League\Fractal\TransformerAbstract
     */
    public function getTransformer()
    {
        return new RefuelFeedTransformer();
    }
}
