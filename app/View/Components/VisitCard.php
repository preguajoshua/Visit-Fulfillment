<?php

namespace App\View\Components;

use Illuminate\View\Component;
use App\Models\AxxessCare\Visit;

class VisitCard extends Component
{
    /**
     * The visit payload.
     *
     * @var  \App\Models\AxxessCare\Visit
     */
    public $visit;

    /**
     * A scoped slot got customizing the cards badges.
     *
     * @var  string
     */
    public $badges;

    /**
     * The threshold for a low professional count.
     */
    const LOW_PROFESSIONAL_THRESHOLD = 15;

    /**
     * Create the component instance.
     *
     * @param  \App\Models\AxxessCare\Visit  $visit
     * @return void
     */
    public function __construct(Visit $visit)
    {
        $this->visit = $visit;
    }

    /**
     * Determine the background color, based on the professional count.
     *
     * @return  string
     */
    public function bgColor()
    {
        return ($this->isLowProfessionalCount())
            ? 'bg-yellow-50'
            : 'bg-white';
    }

    /**
     * Determine the rates background color, based on the professional count.
     *
     * @return  string
     */
    public function ratesBgColor()
    {
        return ($this->isLowProfessionalCount())
            ? 'bg-yellow-100'
            : 'bg-gray-50';
    }

    /**
     * Determine if the professional count is low.
     *
     * @return  boolean
     */
    protected function isLowProfessionalCount()
    {
        if (is_null($this->visit->pCount)) {
            return false;
        }

        return ($this->visit->pCount < self::LOW_PROFESSIONAL_THRESHOLD);
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|string
     */
    public function render()
    {
        return view('components.visit-card');
    }
}
