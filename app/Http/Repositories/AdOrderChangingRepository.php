<?php


namespace App\Http\Repositories;

use App\Models\Ad;

class AdOrderChangingRepository
{
    public $ad;

    public $current_ad;
    public $max_ad;
    public $min_ad;
    public $next_ad;

    public function __construct($id)
    {
        $this->ad = new Ad();
        $this->current_ad = $this->ad->find($id);
        $this->max_ad = $this->ad->orderBy('priority', 'desc')->first();
        $this->min_ad = $this->ad->orderBy('priority', 'asc')->first();
    }

    public function increment()
    {
            // check if current ad exists
            if (!$this->current_ad) {
                return false;
            }

            // check if the current ad is not the max in order
            if ($this->current_ad->priority <= $this->min_ad->priority) {
                return false;
            }

            // get the next element in line
            $this->next_ad = $this->ad->where('priority', '<', $this->current_ad->priority)->orderBy('priority', 'desc')->first();
            if (!$this->next_ad) {
                return false;
            }

            $current_priority = $this->current_ad->priority;
            // then swap priorities
            $this->current_ad->update(['priority' => $this->next_ad->priority]);
            $this->next_ad->update(['priority' => $current_priority]);

            return true;
    }

    public function decrement()
    {

        // check if current ad exists
        if (!$this->current_ad) {
            return false;
        }
        // check if the current ad is not the max in order
        if ($this->current_ad->priority >= $this->max_ad->priority) {
            return false;
        }

        // get the next element in line
        $this->next_ad = $this->ad->where('priority', '>', $this->current_ad->priority)->orderBy('priority', 'asc')->first();

        if (!$this->next_ad) {
            return false;
        }

        $current_priority = $this->current_ad->priority;
        // then swap priorities
        $this->current_ad->update(['priority' => $this->next_ad->priority]);
        $this->next_ad->update(['priority' => $current_priority]);

        return true;
    }
}
