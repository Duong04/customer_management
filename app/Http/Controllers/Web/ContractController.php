<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\UserService;

class ContractController extends Controller
{
    private $userService;

    public function __construct(UserService $userService) {
        $this->userService = $userService;
    }

    public function index() {
        return view('pages.contract.index');
    }

    public function create() {
        $customers = $this->userService->all(5);
        return view('pages.contract.create', compact('customers'));
    }
}
