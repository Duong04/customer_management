<?php

namespace App\Http\Controllers\Apis\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    public function update(Request $request, $id) {
        try {
            $data = $request->validate([
                'email' => 'nullable|email|unique:users,email,'.$id,
                'is_active' => 'nullable',
                'name' => 'nullable'
            ]);

            $user = User::find($id);
            $user->update($data);

            return response()->json(['message' => 'Updated user successfully']);
        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage()], 400);
        }
    }
}
