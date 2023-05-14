<?php

namespace App\Presenters;

use App\Transformers\AssignmentTransformer;
use Prettus\Repository\Presenter\FractalPresenter;

/**
 * Class AssignmentPresenter.
 *
 * @package namespace App\Presenters;
 */
class AssignmentPresenter extends FractalPresenter
{
    /**
     * Transformer
     *
     * @return \League\Fractal\TransformerAbstract
     */
    public function getTransformer()
    {
        return new AssignmentTransformer();
    }
}
