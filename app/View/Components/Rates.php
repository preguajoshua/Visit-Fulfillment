<?php

namespace App\View\Components;

use Illuminate\Support\Str;
use Illuminate\View\Component;
use App\Models\AxxessCare\Visit;

class Rates extends Component
{
    /**
     * The visit payload.
     *
     * @var  \App\Models\AxxessCare\Visit
     */
    public $visit;

    /**
     * Rates Bits.
     */
    const NO_BIT = 0;
    const RN_BIT = 1;
    const PT_BIT = 2;
    const OASIS_BIT = 4;

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
     * Get the first discipline label.
     *
     * @return  string
     */
    public function disciplineOneLabel()
    {
        return match ($this->oasisBit() | $this->disciplineBit()) {
            0b001 => 'RN',
            0b010 => 'PT',
            0b101 => 'OASIS RN',
            0b110 => 'OASIS PT',
            default => '-',
        };
    }

    /**
     * Get the first discipline visit rates.
     *
     * @return  integer
     */
    public function disciplineOneVisitRate()
    {
        return match ($this->oasisBit() | $this->disciplineBit()) {
            0b001 => $this->visit->visitRateRn,
            0b010 => $this->visit->visitRatePt,
            0b101 => $this->visit->oasisRnCost,
            0b110 => $this->visit->oasisPtCost,
            default => null,
        };
    }

    /**
     * Get the first discipline custom rates.
     *
     * @return  integer
     */
    public function disciplineOneCustomRate()
    {
        return match ($this->oasisBit() | $this->disciplineBit()) {
            0b001 => $this->visit->customRateRn,
            0b010 => $this->visit->customRatePt,
            0b101 => $this->visit->customRateOasisRn,
            0b110 => $this->visit->customRateOasisPt,
            default => null,
        };
    }

    /**
     * Get the second discipline label.
     *
     * @return  string
     */
    public function disciplineTwoLabel()
    {
        return match ($this->oasisBit() | $this->disciplineBit()) {
            0b001 => 'LVN',
            0b010 => 'PTA',
            default => '-',
        };
    }

    /**
     * Get the second discipline visit rates.
     *
     * @return  integer
     */
    public function disciplineTwoVisitRate()
    {
        return match ($this->oasisBit() | $this->disciplineBit()) {
            0b001 => $this->visit->visitRateLvn,
            0b010 => $this->visit->visitRatePta,
            default => null,
        };
    }

    /**
     * Get the second discipline custom rates.
     *
     * @return  integer
     */
    public function disciplineTwoCustomRate()
    {
        return match ($this->oasisBit() | $this->disciplineBit()) {
            0b001 => $this->visit->customRateLvn,
            0b010 => $this->visit->customRatePta,
            default => null,
        };
    }

    /**
     * Get the discipline bit.
     *
     * @return  integer
     */
    protected function disciplineBit()
    {
        if ($this->visit->discipline === 'Nursing') {
            return self::RN_BIT;
        }

        if ($this->visit->discipline === 'PT') {
            return self::PT_BIT;
        }

        return self::NO_BIT;
    }

    /**
     * Get the OASIS bit.
     *
     * @return  integer
     */
    protected function oasisBit()
    {
        return (Str::is('*OASIS*', $this->visit->disciplineTask))
            ? self::OASIS_BIT
            : self::NO_BIT;
    }

    /**
     * Determine of the visit has any rates.
     *
     * @return  boolean
     */
    public function hasRates()
    {
        return
            $this->disciplineOneVisitRate() ||
            $this->disciplineTwoVisitRate() ||
            $this->disciplineOneCustomRate() ||
            $this->disciplineTwoCustomRate();
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|string
     */
    public function render()
    {
        return <<<'blade'
            <div>
                {{ $slot }}
            </div>
        blade;
    }
}
