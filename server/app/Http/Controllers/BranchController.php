<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use App\Models\Product;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class BranchController extends Controller
{
    public function getAllBranches(Request $request): JsonResponse{

        $branches = Branch::all();
        return response()->json(["branches" => $branches]);
    }
}
