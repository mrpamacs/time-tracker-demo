<?php

namespace App\Livewire;

use App\Models\Project;
use Livewire\Component;
use Livewire\Attributes\Validate;

class ProjectList extends Component
{
    public $projects ;

    #[Validate('required|string|max:255')]
    public $newProjectName = '';


    public function mount()
    {
        $this->projects = Project::all();
    }

    public function createProject()
    {
        $this->validate();
        Project::create(['name' => $this->newProjectName]);

        $this->reset();
        $this->projects = Project::all();
    }

    public function render()
    {
        return view('livewire.project-list');
    }
}
