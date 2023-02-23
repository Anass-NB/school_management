<?php

namespace App\Repository\Interfaces;

interface StudentRepositoryInterface {

  public function createStudent();
  public function storeStudent($request);
  public function getAllStudents();
  public function showStudent($id);
  public function editStudent($id);
  public function updateStudent($request);
  public function deleteStudent($request);
  public function uploadNewAttachment($request);
  



}