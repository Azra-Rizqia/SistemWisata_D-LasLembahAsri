<?php

namespace App\View\Components;

use Illuminate\View\Component;

class deletemodal extends Component
{
    public $id;
    public $title;
    public $message;

    public function __construct(
        $id = 'deleteModal',
        $title = 'Apakah Anda Yakin Untuk Menghapus?',
        $message = 'Jika anda menghapus data ini, maka anda tidak dapat memulihkannya lagi.'
    ) {
        $this->id = $id;
        $this->title = $title;
        $this->message = $message;
    }

    public function render()
    {
        return view('components.delete-confirm-modal');
    }
}
