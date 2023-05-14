<?php

namespace App\Presenters;

use App\Transformers\ComplainExportTransformer;
use Prettus\Repository\Presenter\FractalPresenter;

/**
 * Class ComplainExportPresenter.
 *
 * @package namespace App\Presenters;
 */
class ComplainExportPresenter extends FractalPresenter
{
    /**
     * Transformer
     *
     * @return \League\Fractal\TransformerAbstract
     */
    public function getTransformer()
    {
        return new ComplainExportTransformer();
    }
}
