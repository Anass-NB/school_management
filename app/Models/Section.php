<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class Section extends Model
{
    use HasFactory;
    use HasTranslations;
    protected $table = "sections";
    public $translatable = ['Name_section'];
    protected $fillable = ["Name_section", "Status", "Grade_id ", "Class_id"];

    // علاقة بين الاقسام والصفوف لجلب اسم الصف في جدول الاقسام

    public function My_class()
    {
        return $this->belongsTo(Classroom::class, "Class_id");
    }
    // علاقة الاقسام مع المعلمين
    public function teachers()
    {
        return $this->belongsToMany(Teacher::class, 'teacher_section');
    }
}
