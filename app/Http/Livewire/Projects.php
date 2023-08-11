<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Project;

class Projects extends Component
{
    use WithFileUploads;

    public $projects, $title, $description, $image, $is_public, $project_id, $message, $delete_id;
    public bool $modalOpen = false;
    public bool $modalDeleteOpen = false;


    public function render()
    {
        $this->projects = Project::all();
        return view('livewire.projects');
    }

    public function create(): void
    {
        $this->resetForm();
        $this->openModal();
    }

    public function openModal(): void
    {
        $this->modalOpen = true;
    }

    public function openDeleteModal(): void
    {
        $this->modalDeleteOpen = true;
    }

    public function closeModal(): void
    {
        $this->modalOpen = false;
        $this->modalDeleteOpen = false;
        $this->resetForm();
    }

    private function resetForm(): void
    {
        $this->project_id = '';
        $this->title = '';
        $this->description = '';
        $this->image = '';
        $this->is_public = false;
        $this->dispatchBrowserEvent('editProject', ['description' => $this->description]);
        $this->resetErrorBag();
    }

    public function store(): void
    {
        $this->validate([
            'title' => 'required',
            'description' => 'required',
            'image' => 'required|mimes:jpg,jpeg,png,bmp,gif,svg,webp|max:1024',
            'is_public' => 'required',
        ]);

        $name = md5($this->image . microtime()).'.'.$this->image->extension();
        $this->image->storeAs('projects', $name);

        Project::create([
            'title' => $this->title,
            'description' => $this->description,
            'image' => $name,
            'is_public' => $this->is_public,
        ]);

        session()->flash('message', 'Project created!');

        $this->closeModal();
        $this->resetForm();
    }

    public function update(): void
    {
        $this->validate([
            'title' => 'required',
            'description' => 'required',
            'is_public' => 'required',
        ]);

        $project = Project::find($this->project_id);
        $name = $project->image;

        if(!is_string($this->image)){

            $this->validate([
                'image' => 'required|mimes:jpg,jpeg,png,bmp,gif,svg,webp|max:2048'
            ]);
            $this->unlinkOldImage($name);
            $name = md5($this->image . microtime()).'.'.$this->image->extension();
            $this->image->storeAs('projects', $name);
        }

        $project->update([
            'title' => $this->title,
            'description' => $this->description,
            'image' => $name,
            'is_public' => $this->is_public,
        ]);

        session()->flash('message', 'Project Updated!');

        $this->closeModal();
        $this->resetForm();
    }

    public function edit($id): void
    {
        $project = Project::findOrFail($id);
        $this->project_id = $id;
        $this->title = $project->title;
        $this->description = $project->description;
        $this->image = $project->image;
        $this->is_public = $project->is_public;

        $this->dispatchBrowserEvent('editProject', ['description' => $this->description]);
        $this->openModal();
    }

    public function deleteId($id)
    {
        $this->delete_id = $id;
        $this->openDeleteModal();
    }

    public function delete():void
    {
        Project::find($this->delete_id)->delete();
        $this->closeModal();
        session()->flash('message', 'Project deleted!');
    }

    public function unlinkOldImage(string $path): void
    {
        $path = public_path('images/projects/').$path;
        if(\File::exists($path))
            unlink($path);
    }

    public function dehydrate()
    {
        $this->dispatchBrowserEvent('createCKEditor');
    }
}
