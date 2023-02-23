<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Livewire\WithFileUploads;

class ParentAttachment extends Model
{
    use HasFactory;

    protected $fillable = ["file_name","parent_id"];
}
