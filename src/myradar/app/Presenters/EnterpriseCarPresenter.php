<?php

namespace App\Presenters;

use App\Transformers\EnterpriseCarTransformer;
use Prettus\Repository\Presenter\FractalPresenter;


/**
 * Class EnterpriseCarPresenter
 *
 * @package namespace App\Presenters;
 */
class EnterpriseCarPresenter extends FractalPresenter
{
  /**
   * Transformer
   *
   * @return \League\Fractal\TransformerAbstract
   */
  public function getTransformer()
  {
      return new EnterpriseCarTransformer();
  }
}


 ?>
