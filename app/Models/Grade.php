<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;
use App\Models\Section;
class Grade extends Model
{


  use HasTranslations;
  protected $table = 'Grades';
  public $timestamps = true;

  public $translatable = ['Name'];

  protected $fillable = ["Name", "Notes"];



  public function Sections(){
    return $this->hasMany(Section::class,"Grade_id");
  }
}
