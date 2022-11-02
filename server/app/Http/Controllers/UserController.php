<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use App\Models\Inventory;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{

    public function register(Request $request): JsonResponse{

        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'employee_id' => 'required',
            'type' => 'required',
            'branch' => 'required',
            'password' => 'required|min:6'
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 400);
        }

        $user = User::create([
            'name' => $request->name,
            'employeeId' => $request->employee_id,
            'type' => $request->type,
            'branch' => $request->branch,
            'password' => Hash::make($request->password),
        ]);

        $user->save();
        if($request->type == User::HO){
            $branch = Branch::find($request->branch);
            $branch->HOId = $user->id;
            $branch->save();

            $inventory = Inventory::create([
                'branchId' => $branch->id,
            ]);

            $inventory->save();
        }
        return response()->json(["user" => $user]);
    }

    public function login(Request $request): JsonResponse{

        $validator = Validator::make($request->all(), [
            'employee_id' => 'required|string',
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 400);
        }

        $user = User::where('employeeId',$request->employee_id)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json(['message' => "Invalid credentials"], 401);
        }
        $token = $user->createToken('apiToken')->plainTextToken;

        $inventory = Inventory::where('branchId', $user->branch)->first();

        $user->inventory = $inventory;

        $res = [
            'user' => $user,
            'token' => $token
        ];
        return response()->json($res, 200);

    }

    public function getUser(Request $request): JsonResponse{

        return response()->json(['message' => "ok"], 200);

    }

}
