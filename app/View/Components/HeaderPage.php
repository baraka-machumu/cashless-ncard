<?php

namespace App\View\Components;

use Illuminate\View\Component;

class HeaderPage extends Component
{

    public  $title;

    public  $code;

    /**
     * Create a new component instance.
     *
     * @return void
     */

    public function __construct($title,$code)
    {

        $this->title = $title;
        $this->code= $code;

    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('components.header-page');
    }
}
