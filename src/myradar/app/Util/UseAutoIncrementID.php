<?php
namespace App\Traits;
trait UseAutoIncrementID {
    /**
     * Increment the counter and get the next sequence
     *
     * @param $collection
     * @return mixed
     */
    private static function getID($collection) {
        $seq = \DB::getCollection('_data_counters')->findOneAndUpdate(
            array('_id' => $collection),
            array('$inc' => array('seq' => 1)),
            array('new' => true, 'upsert' => true, 'returnDocument' => \MongoDB\Operation\FindOneAndUpdate::RETURN_DOCUMENT_AFTER)
        );
        return $seq->seq;
    }
    /**
     * Boot the AutoIncrementID trait for the model.
     *
     * @return void
     */
    public static function bootUseAutoIncrementID() {
        static::creating(function ($model) {
            $model->incrementing = false;
            $model->{$model->getKeyName()} = self::getID($model->getTable());
        });
    }
    /**
     * Get the casts array.
     *
     * @return array
     */
    public function getCasts() {
        return $this->casts;
    }
}