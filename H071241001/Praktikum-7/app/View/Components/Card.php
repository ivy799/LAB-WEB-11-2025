<?php

namespace App\View\Components;

use Illuminate\View\Component;

class Card extends Component
{
    public $image;
    public $title;
    public $description;
    public $location;
    public $price;

    public function __construct($image, $title, $description, $location = null, $price = null)
    {
        $this->image = $image;
        $this->title = $title;
        $this->description = $description;
        $this->location = $location;
        $this->price = $price;
    }

    public function render()
    {
        return view('components.card');
    }
}