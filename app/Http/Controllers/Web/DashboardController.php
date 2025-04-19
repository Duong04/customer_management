<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\ContractService;

class DashboardController extends Controller
{
    private $contractService;
    public function __construct(ContractService $contractService) {
        $this->contractService = $contractService;
    }
    public function index() {
        $status_valid = $this->contractService->statsByStatus('valid'); 
        $status_expired = $this->contractService->statsByStatus('expired'); 
        $status_not_yet_valid = $this->contractService->statsByStatus('not_yet_valid'); 
        $status_total = $this->contractService->statsByStatus(); 
        return view('pages/dashboard.index', compact('status_valid', 'status_expired', 'status_not_yet_valid', 'status_total'));
    }
}
