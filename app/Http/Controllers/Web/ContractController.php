<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Requests\ContractRequest;
use App\Services\ContractService;
use Illuminate\Http\Request;
use App\Services\UserService;

class ContractController extends Controller
{
    private $userService;
    private $contractService;

    public function __construct(UserService $userService, ContractService $contractService) {
        $this->userService = $userService;
        $this->contractService = $contractService;
    }

    public function index() {
        $contracts = $this->contractService->all();
        return view('pages.contract.index', compact('contracts'));
    }

    public function create() {
        $customers = $this->userService->all(5);
        return view('pages.contract.create', compact('customers'));
    }

    public function store(ContractRequest $request) {
        return $this->contractService->create($request);
    }

    public function show($id) {
        $contract = $this->contractService->findById($id);

        if (!$contract) {
            abort(404);
        }

        $customers = $this->userService->all(5);

        return view('pages.contract.update', compact('contract', 'customers'));
    }

    public function update(ContractRequest $request, $id) {
        return $this->contractService->update($request, $id);
    }

    public function delete($id) {
        return $this->contractService->delete($id);
    }
}
