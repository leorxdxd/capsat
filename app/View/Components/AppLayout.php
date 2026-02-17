<?php

namespace App\View\Components;

use Illuminate\View\Component;
use Illuminate\View\View;

class AppLayout extends Component
{
    public $sidebarCollapsed;

    public function __construct($sidebarCollapsed = false)
    {
        $this->sidebarCollapsed = $sidebarCollapsed;
    }

    /**
     * Get the view / contents that represents the component.
     */
    public function render(): View
    {
        return view('layouts.app');
    }
}
