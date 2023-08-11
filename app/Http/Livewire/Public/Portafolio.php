<?php

namespace App\Http\Livewire\Public;

use App\Models\Project;
use Livewire\Component;

class Portafolio extends Component
{
    public function render()
    {
        return view('livewire.public.portafolio',[
            'projects' => Project::where('is_public',true)->paginate(9),
        ])->layout('layouts.guest');
    }

}
