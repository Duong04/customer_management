<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Requests\CustomerRequest;
use Illuminate\Http\Request;
use App\Services\UserService;

class CustomerController extends Controller
{
    private $userService;

    public function __construct(UserService $userService) {
        $this->userService = $userService;
    }

    public function index() {
        $users = $this->userService->getCustomer();
        return view('pages.customer.index', compact('users'));
    }

    public function create() {
        return view('pages.customer.create');
    }

    public function store(CustomerRequest $request) {
        return $this->userService->createCustomer($request);
    }

    public function show($id) {
        $customer = $this->userService->findCustomerById($id);

        if (!$customer) {
            abort(404);
        }

        return view('pages.customer.update', compact('customer'));
    }

    public function update(CustomerRequest $request, $id) {
        return $this->userService->updateCustomer($request, $id);
    }
}
