<?php 
namespace App\Services;

use App\Models\Contract;
use App\Models\ContractAccessLog;
use App\Models\ContractHistory;
use App\Models\ContractPayment;
use App\Models\ContractAttachment;
use App\Services\FirebaseService;
use Auth;

class ContractService {
    private $firebaseService;
    public function __construct(FirebaseService $firebaseService) {
        $this->firebaseService = $firebaseService;
    }

    public function all() {
        try {
            $contracts = Contract::orderByDesc('id')->get();

            return $contracts;
        } catch (\Throwable $th) {
            return $th->getMessage();
        }
    }

    public function create($request) {
        try {
            $data = $request->validated();

            $data['code'] = $this->generateCode();
            $data['created_by'] = Auth::id();
            $contract = Contract::create($data);

            if ($contract) {
                if (isset($data['payments'])) {
                    foreach ($data['payments'] as $payment) {
                        if ($payment['status'] == 'completed') {
                            $payment['payment_date'] = now();
                        }
                        $payment['contract_id'] = $contract->id;
                        ContractPayment::create($payment);
                    }
                }

                if ($request->has('attachments')) {
                    foreach ($request->attachments as $index => $attachment) {
                        $file = $request->file("attachments.$index.file");
        
                        if ($file && $file->isValid()) {
                            $path = $this->firebaseService->uploadFile($file, 'contracts');
                            ContractAttachment::create([
                                'file_path' => $path,
                                'note' => $attachment['note'] ?? null,
                                'contract_id' => $contract->id
                            ]);
                        }
                    }
                }

                ContractHistory::create([
                    'contract_id' => $contract->id,
                    'changed_by' => Auth::id(),
                    'action' => 'Create',
                    'note' => "Người dùng ". Auth::user()->name ."vừa thực hiện thao tác tạo hợp đồng!"
                ]);

                toastr()->success('Hợp đồng đã được tạo thành công!');

                return redirect()->back();
            }
        } catch (\Throwable $th) {
            toastr()->error($th->getMessage());
            return redirect()->back();
        }
    }

    public function findById($id) {
        try {
            return Contract::find($id);
        } catch (\Throwable $th) {
            return redirect()->back();
        }
    }

    public function update($request, $id) {
        try {
            $data = $request->validated();

            $contract = Contract::find($id);

            if (!$contract) {
                toastr()->error('Hợp đồng không tồn tại!');
                return redirect()->back();
            }

            $contract->update($data);

            if ($contract) {
                if (isset($data['payments'])) {
                    foreach ($data['payments'] as $payment) {
                        if ($payment['status'] == 'completed') {
                            $payment['payment_date'] = now();
                        }
                        if (isset($payment['id'])) {
                            $existingPayment = ContractPayment::find($payment['id']);
                            if ($existingPayment) {
                                $existingPayment->update($payment);
                            }
                        } else {
                            $payment['contract_id'] = $id;
                            ContractPayment::create($payment);
                        }
                    }
                }

                if ($request->has('attachments')) {
                    foreach ($request->attachments as $index => $attachment) {
                        if (isset($attachment['id'])) {
                            $existingAttachment = ContractAttachment::find($attachment['id']);
                            $file = $request->file("attachments.$index.file");

                            if ($file && $file->isValid()) {
                                $path = $this->firebaseService->uploadFile($file, 'contracts');
                                
                                $existingAttachment->update([
                                    'file_path' => $path,
                                    'note' => $attachment['note'] ?? $existingAttachment->note // Nếu không có ghi chú mới thì giữ nguyên ghi chú cũ
                                ]);
                            }

                            if ($existingAttachment) {
                                $existingAttachment->update([
                                    'note' => $attachment['note'] ?? $existingAttachment->note // Nếu không có ghi chú mới thì giữ nguyên ghi chú cũ
                                ]);
                            }
                        } else {
                            $file = $request->file("attachments.$index.file");
                
                            if ($file && $file->isValid()) {
                                $path = $this->firebaseService->uploadFile($file, 'contracts');
                                
                                ContractAttachment::create([
                                    'file_path' => $path,
                                    'note' => $attachment['note'] ?? null,
                                    'contract_id' => $id
                                ]);
                            }
                        }
                    }
                }
                

                ContractHistory::create([
                    'contract_id' => $contract->id,
                    'changed_by' => Auth::id(),
                    'action' => 'Update',
                    'note' => "Người dùng ". Auth::user()->name ."vừa thực hiện thao tác cập nhật hợp đồng!"
                ]);

                toastr()->success('Hợp đồng đã được cập nhật thành công!');

                return redirect()->route('contracts.index');
            }
        } catch (\Throwable $th) {
            toastr()->error($th->getMessage());
            return redirect()->back();
        }
    }

    public function delete($id) {
        try {
            $contract = Contract::find($id);
    
            if (!$contract) {
                toastr()->error('Hợp đồng không tồn tại!');
                return redirect()->back();
            }
    
            $contract->delete();
    
            toastr()->success('Hợp đồng đã được xóa thành công!');
    
            return redirect()->route('contracts.index');
        } catch (\Throwable $th) {
            toastr()->error($th->getMessage());
            return redirect()->back();
        }
    }

    private function generateCode()
    {
        $year = date('Y');
        $prefix = "HD$year-";

        $maxCode = Contract::where('code', 'like', $prefix . '%')->max('code');

        if ($maxCode) {
            $lastNumber = (int) substr($maxCode, strlen($prefix)); 
            $newNumber = $lastNumber + 1;
        } else {
            $newNumber = 1;
        }

        return $prefix . str_pad($newNumber, 3, '0', STR_PAD_LEFT);
    }

}