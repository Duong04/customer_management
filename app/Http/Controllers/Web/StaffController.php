<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Requests\StaffRequest;
use Illuminate\Http\Request;
use App\Services\UserService;
use App\Services\RoleService;

class StaffController extends Controller
{
    private $userService;
    private $roleService;
    public function __construct(UserService $userService, RoleService $roleService) {
        $this->userService = $userService;
        $this->roleService = $roleService;
    }

    public function index() {
        $users = $this->userService->getAllUser(5);

        return view('pages.staff.index', compact('users'));
    }

    public function create() {
        $roles = $this->roleService->all(5);
        return view('pages.staff.create', compact('roles'));
    }

    public function store(StaffRequest $request) {
        return $this->userService->createStaff($request);
    }

    public function show($id) {
        $roles = $this->roleService->all(5);
        $user = $this->userService->findById($id);

        if (!$user) {
            abort(404);
        }

        return view('pages.staff.update', compact('user', 'roles'));
    }

    public function update(StaffRequest $request, $id) {
        return $this->userService->updateStaff($request, $id);
    }
}
