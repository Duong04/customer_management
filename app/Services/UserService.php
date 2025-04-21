<?php 
namespace App\Services;

use App\Models\EmployeeProfile;
use App\Models\User;
use App\Models\Customer;
use App\Models\CustomerContact;
use App\Services\FirebaseService;

class UserService {
    private $firebaseService;

    public function __construct(FirebaseService $firebaseService) {
        $this->firebaseService = $firebaseService;
    }

    public function all($role = null) {
        try {
            $users = User::with('customer');
    
            if ($role) {
                $users->where('role_id', $role);
            }
    
            $users = $users->orderByDesc('id')->get(); 
    
            return $users;
        } catch (\Throwable $th) {
            toastr()->error($th->getMessage());
            return redirect()->back();
        }
    }

    public function getCustomer() {
        try {
            $customers = Customer::query();
    
            $customers = $customers->orderByDesc('id')->get(); 
    
            return $customers;
        } catch (\Throwable $th) {
            toastr()->error($th->getMessage());
            return redirect()->back();
        }
    }
    
    public function getAllUser($not_role_id = null) {
        try {
            $users = User::orderByDesc('id')->whereHas('role', function ($query) {
                $query->where('name', '!=', 'Supper Admin');
            });

            if ($not_role_id) {
                $users->where('role_id', '!=', $not_role_id);
            }
            
            return $users->get();
        } catch (\Throwable $th) {
            toastr()->error($th->getMessage());
            return redirect()->back();
        }
    }

    public function createCustomer($request) {
        try {
            $data = $request->validated();

            $data['code'] = $this->generateCodeCustomer();
            if ($request->hasFile('file')) {
                $file = $request->file('file');
                $path = $this->firebaseService->uploadFile($file, 'contracts');
                $data['file'] = $path;
            }
            $customer = Customer::create($data);


            if ($customer) {
                $data['contact']['customer_id'] = $customer->id;
                CustomerContact::create($data['contact']);

                toastr()->success('Khách hàng đã được tạo thành công!');
                return redirect()->back();
            }
        } catch (\Throwable $th) {
            toastr()->error($th->getMessage());
            return redirect()->back();
        }
    }

    public function createStaff($request) {
        try {
            $data = $request->validated();

            $user = User::create($data);
            if ($user) {
                $data['staff']['user_id'] = $user->id;
                $data['staff']['code'] = $this->generateCodeStaff();
                EmployeeProfile::create($data['staff']);

                toastr()->success('Người dùng đã được tạo thành công!');
                return redirect()->back();
            }
        } catch (\Throwable $th) {
            toastr()->error($th->getMessage());
            return redirect()->back();
        }
    }

    public function findById($id) {
        try {
            return User::find($id);
        } catch (\Throwable $th) {
            return redirect()->back();
        }
    }

    public function findCustomerById($id) {
        try {
            return Customer::find($id);
        } catch (\Throwable $th) {
            return redirect()->back();
        }
    }


    public function updateCustomer($request, $id) {
        try {
            $data = $request->validated();
            $redirect = $request->query('redirect');
            $customer = Customer::find($id);

            if (!$customer) {
                toastr()->error('Khách hàng không tồn tại!');
                return redirect()->back();
            }

            if ($request->hasFile('file')) {
                $file = $request->file('file');
                $path = $this->firebaseService->uploadFile($file, 'contracts');
                $data['file'] = $path;
            }

            $customer->update($data);

            if (isset($data['contact'])) {
                $customer->customerContact->update($data['contact']);
            }
            
            if ($redirect == 'back') {
                toastr()->success('Khách hàng đã được cập nhật thành công!');
                return redirect()->back();
            }
            toastr()->success('Khách hàng đã được cập nhật thành công!');
            return redirect()->route('customers.index');
        } catch (\Throwable $th) {
            toastr()->error($th->getMessage());
            return redirect()->back();
        }
    }

    public function updateStaff($request, $id) {
        try {
            $data = $request->validated();
            $redirect = $request->query('redirect');

            if (isset($data['password']) && !$data['password']) {
                unset($data['password']);
            }

            $user = User::find($id);

            if (!$user) {
                toastr()->error('Người dùng không tồn tại!');
                return redirect()->back();
            }

            $user->update($data);
            if ($data['staff']) {
                $user->staff->update($data['staff']);
            }

            if ($redirect == 'back') {
                toastr()->success('Người dùng đã được cập nhật thành công!');
                return redirect()->back();
            }

            toastr()->success('Người dùng đã được cập nhật thành công!');
            return redirect()->route('staffs.index');

        } catch (\Throwable $th) {
            toastr()->error($th->getMessage());
            return redirect()->back();
        }
    }

    private function generateCodeStaff()
    {
        $max_code = EmployeeProfile::max('code');
        if ($max_code) {
            $lastNumber = (int) substr($max_code, 3);
            return 'MNV' . sprintf('%05d', $lastNumber + 1);
        }

        return 'MNV00001';
    }

    public function deleteCustomer($id) {
        try {
            $customer = Customer::find($id);

            $customer->delete();

            toastr()->success('Khách hàng đã xóa thành công!');

            return redirect()->route('customers.index');
        } catch (\Throwable $th) {
            toastr()->error($th->getMessage());
            return redirect()->back();
        }
    }

    private function generateCodeCustomer()
    {
        $max_code = Customer::max('code');
        if ($max_code) {
            $lastNumber = (int) substr($max_code, 3);
            return 'KH' . sprintf('%05d', $lastNumber + 1);
        }

        return 'KH00001';
    }
}