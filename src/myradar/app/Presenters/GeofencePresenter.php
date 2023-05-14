<?php

namespace App\Presenters;

use App\Transformers\GeofenceTransformer;
use Prettus\Repository\Presenter\FractalPresenter;

/**
 * Class GeofencePresenter
 *
 * @package namespace App\Presenters;
 */
class GeofencePresenter extends FractalPresenter
{
    /**
     * Transformer
     *
     * @return \League\Fractal\TransformerAbstract
     */
    public function getTransformer()
    {
        return new GeofenceTransformer();
    }
}
