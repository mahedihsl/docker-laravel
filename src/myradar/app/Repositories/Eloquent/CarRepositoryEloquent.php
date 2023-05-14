<?php

namespace App\Repositories\Eloquent;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Contract\Repositories\CarRepository;
use App\Entities\Car;
use App\Events\CarCreated;
use Illuminate\Support\Collection;
use Carbon\Carbon;

/**
 * Class CarRepositoryEloquent
 * @package namespace App\Repositories\Eloquent;
 */
class CarRepositoryEloquent extends BaseRepository implements CarRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Car::class;
    }

    public function save(Collection $data)
    {
        $vehicleType = intval($data->get('type'));
        $metaInfo = [
            'cng_type' => intval($data->get('cng')),
            'fuel_group' => $data->get('fuel_group', null),
        ];

        if ($vehicleType == Car::TYPE_GENERATOR) {
            $metaInfo['volume'] = floatval($data->get('volume'));
        }

        $car = $this->create([
            'name'        => $data->get('name'),
            'model'       => $data->get('model'),
            'reg_no'      => $data->get('reg_no'),
            'user_id'     => $data->get('user_id'),
            'type'        => $vehicleType,
            'services'    => $data->get('services'),
            'meta_data'   => $metaInfo,
            'new_service' => intval($data->get('new_service')),
            'voice_service'  => intval($data->get('voice_service')),
            'billing_type'  => $data->get('billing_type'),
        ]);

        if ( ! is_null($car)) {
            $activation_key = $data->get('activation_key');
            $promo_key = $data->get('promo_key');
            event(new CarCreated($car, $activation_key, $promo_key));
        }

        return $car;
    }

    public function change(Collection $data)
    {
        $vehicleType = intval($data->get('type'));
        $props = [
            'name'     => $data->get('name'),
            'model'    => $data->get('model'),
            'type'     => intval($data->get('type')),
            'meta_data.fuel_group' => $data->get('fuel_group', null),
            'meta_data.cng_type' => intval($data->get('cng')),
            'new_service' => intval($data->get('new_service')),
            'voice_service' => intval($data->get('voice_service')),
            'bill'        => $data->get('bill'),
            'billing_type'  => $data->get('billing_type'),
        ];

        if ($data->has('services')) {
            $props['services'] = $data->get('services');
        }
        if ($data->has('reg_no')) {
            $props['reg_no'] = $data->get('reg_no');
        }

        if ($vehicleType == Car::TYPE_GENERATOR) {
            $props['meta_data.volume'] = floatval($data->get('volume'));
        }

        $car = $this->update($props, $data->get('id'));
        $device = $car->device;
        if ( ! is_null($device)) {
            $device->update([
                'engine_control' => $data->get('engine_control'),
            ]);
        }
        return $car;
    }

    public function updateDates($car, Collection $dates)
    {
        $fields = collect([
            'reg_date' => 'reg_date',
            'tax_date' => 'tax_date',
            'fit_date' => 'fitness_date',
            'ins_date' => 'insurance_date',
        ]);

        foreach ($fields as $key => $value) {
            if ($dates->has($key)) {
                $car->update([ $value => Carbon::createFromFormat('j/n/Y', $dates->get($key)) ]);
            }
        }
    }

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
}
