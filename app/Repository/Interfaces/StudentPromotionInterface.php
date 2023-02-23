<?php


namespace App\Repository\Interfaces;

interface StudentPromotionInterface {
  public function index();
  public function storePromotion($request);
  public function destroyPromotion($request);
  public function createPromotion();
}