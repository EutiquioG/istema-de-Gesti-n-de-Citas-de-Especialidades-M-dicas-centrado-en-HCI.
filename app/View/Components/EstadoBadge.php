<?php

namespace App\View\Components;

use Illuminate\View\Component;

class EstadoBadge extends Component
{
    public function __construct(public string $estado) {}

    public function render()
    {
        return view('components.estado-badge');
    }
}
