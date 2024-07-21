<?php

namespace App\Services;

use App\Repositories\CategoryRepositoryInterface;
use App\Traits\ResponseTrait;

class CategoryService
{
    use ResponseTrait;

    protected CategoryRepositoryInterface $categoryRepository;

    public function __construct(CategoryRepositoryInterface $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
    }



    public function index()
    {
        try {
            $categories = $this->categoryRepository->index();

            return self::successWithData($categories, 'all categories fetched successfully');
        }catch (\Exception $e){
            return self::failed($e->getMessage());
        }
    }

}
