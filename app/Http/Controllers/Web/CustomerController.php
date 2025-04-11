<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\UserService;

class CustomerController extends Controller
{
    private $userService;

    public function __construct(UserService $userService) {
        $this->userService = $userService;
    }

    public function index() {
        $users = $this->userService->all(5);

        return view('pages.customer.index', compact('users'));
    }

    public function create() {
        return view('pages.customer.create');
    }
}
