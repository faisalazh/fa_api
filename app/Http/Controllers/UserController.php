<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\orders;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function store(Request $request)
    {
        // Validasi input
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|min:8',
            'name' => 'required|min:3|max:50',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors()
            ], 400);
        } else {
			$validatedData = $validator->validated();
			$user = User::create([
				'email' => $validatedData['email'],
				'password' => Hash::make($validatedData['password']),
				'name' => $validatedData['name'],
			]);
			return response()->json([
				'message' => 'User berhasil dibuat',
				'data' => [
					'email' => $request->email,
					'password' => $request->password,
					'name' => $request->name,
				]
			], 201);
		}
    }
    
	public function index(Request $request)
	{
		$search = $request->input('search', null);
		$page = $request->input('page', 1);
		$sortBy = $request->input('sortBy', 'created_at');
		$perPage = $request->input('perPage', 20);
		$sortDesc = filter_var($request->input('sortDesc', true), FILTER_VALIDATE_BOOLEAN);
		
		$validSortBy = ['name', 'email', 'created_at'];
		if (!in_array($sortBy, $validSortBy)) {
			$sortBy = 'created_at';
		}
		
		$users = User::where('active', true)
			->when($search, function ($query, $search) {
				$query->where(function ($q) use ($search) {
					$q->where('name', 'LIKE', "%{$search}%")
					  ->orWhere('email', 'LIKE', "%{$search}%");
				});
			})
			->withCount('orders')
			->orderBy($sortBy, $sortDesc ? 'desc' : 'asc')
			->paginate($perPage, ['*'], 'page', $page);
			
		$formattedUsers = $users->map(function ($user) {
			return [
				'id' => $user->id,
				'email' => $user->email,
				'name' => $user->name,
				'created_at' => $user->created_at->toIso8601String(),
				'orders_count' => $user->orders_count,
			];
		});

		return response()->json([
			'page' => $users->currentPage(),
			'users' => $formattedUsers,
		], 200);
		
	}    
    
}
