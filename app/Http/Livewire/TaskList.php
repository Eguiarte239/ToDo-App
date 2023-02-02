<?php

namespace App\Http\Livewire;

use App\Models\Task;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Livewire\Component;
use Livewire\WithFileUploads;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class TaskList extends Component
{
    use WithFileUploads;

    public $task;
    public $openModal = false;
    public $editTask = false;

    public $title;
    public $start_time;
    public $end_time;
    public $hour_estimate;
    public $content;
    public $image;
    public $priority;
    public $imageId;
    public $path;


    protected $listeners = ['refreshComponent' => '$refresh'];

    protected $rules = [
        "title" => 'required|string|max:255',
        "start_time" => 'required|date|after_or_equal:today',
        "end_time" => 'required|date|after_or_equal:start_time',
        "hour_estimate" => 'required|integer|between:0,100.99',
        "content" => 'required|string|max:500',
        "image" => 'required|image|max:2048',
        "priority" => 'required',
    ];

    public function mount(){
        $path = public_path('/images');
        $this->imageId = rand();
    }

    public function getTasksProperty()
    {
        return Task::where('user_id', Auth::user()->id)->orderBy('order_position', 'asc')->get();
    }

    public function render()
    {
        $tasks = $this->tasks;
        return view('livewire.task-list', ['tasks' => $tasks])->layout('layouts.app');
    }

    public function setValues($id)
    {
        $this->task = Task::find($id);
        $this->title = $this->task->title;
        $this->start_time = $this->task->start_time;
        $this->end_time = $this->task->end_time;
        $this->hour_estimate = $this->task->hour_estimate;
        $this->content = $this->task->content;
        $this->priority = $this->task->priority;
    }

    public function resetValues()
    {
        $this->task = new Task();
        $this->title = "";
        $this->start_time = now()->format('Y-m-d');
        $this->end_time = "";
        $this->hour_estimate = "";
        $this->content = "";
        $this->priority = null;
        $this->imageId = rand();
    }

    public function newNote()
    {
        $this->resetValues();
        $this->resetValidation();
        $this->editTask = false;
        $this->openModal = true;
    }

    public function editNote($id)
    {
        $this->setValues($id);
        $this->editTask = true;
        $this->openModal = true;
    }

    public function saveTask()
    {
        $this->validate();
        if(!File::exists($this->path)) {
            Storage::disk('public')->makeDirectory('images');
        }

        $this->task = new Task();
        $this->task->user_id = Auth::user()->id;
        $this->task->title = $this->title;
        $this->task->start_time = $this->start_time;
        $this->task->end_time = $this->end_time;
        $this->task->hour_estimate = $this->hour_estimate;
        $this->task->content = $this->content;
        $this->task->priority = $this->priority;
        $name =  Crypt::encryptString($this->image->getClientOriginalName());
        $route = storage_path().'\app\public\images/'.$name;
        Image::make($this->image)->resize(1200, null, function ($constraint) {
            $constraint->aspectRatio();
        })->encode('jpg')->save($route);
        $url = '/storage/images/'.$name;
        $this->task->image = $url;
        $this->task->save();
        $this->openModal = false;

        return redirect()->route('notes.index');
    }

    public function editTask($id)
    {
        $this->validate();

        $this->task = Task::find($id);
        $this->task->user_id = Auth::user()->id;
        $this->task->title = $this->title;
        $this->task->start_time = $this->start_time;
        $this->task->end_time = $this->end_time;
        $this->task->hour_estimate = $this->hour_estimate;
        $this->task->content = $this->content;
        $this->task->priority = $this->priority;
        $name = Crypt::encryptString($this->image->getClientOriginalName());
        $route = storage_path().'\app\public\images/'.$name;
        Image::make($this->image)->resize(1200, null, function ($constraint) {
            $constraint->aspectRatio();
        })->encode('jpg')->save($route);
        $url = '/storage/images/'.$name;
        $this->task->image = $url;
        $this->task->save();
        $this->openModal = false;
    }

    public function deleteTask($id)
    {
        Task::destroy($id);
        $this->openModal = false;
        return redirect()->route('notes.index');
    }

    public function updateTaskOrder($items)
    {
        foreach($items as $item)
        {
            $task = Task::find($item['value']);
            $task->order_position = $item['order'];
            $task->save();
        }
    }
}
