<?php

namespace App\View\Components;

use Avatar;
use Illuminate\View\Component;

class ProfileBadge extends Component
{
    /**
     * The users profile name.
     *
     * @var  string
     */
    public $name;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($name)
    {
        $this->name = $name;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|string
     */
    public function render()
    {
        return view('components.profile-badge', [
            'image' => Avatar::create($this->name)->toBase64(),
        ]);
    }
}
