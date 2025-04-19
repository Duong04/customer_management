<?php
namespace App\Services;

use App\Models\EmployeeProfile;
use App\Models\User;
use Auth;
use App\Services\CloundinaryService;
use App\Services\FirebaseService;

class AuthService {
    private $cloundinaryService;
    private $firebaseService;
    public function __construct(CloundinaryService $cloundinaryService, FirebaseService $firebaseService) {
        $this->cloundinaryService = $cloundinaryService;
        $this->firebaseService = $firebaseService;
    }
    public function login($request) {
        try {
            $user = $request->validated();

            if (Auth::attempt($user)) {
                $userData = Auth::user();

                if (!$userData->is_active) {
                    toastr()->warning("Tài khoản của bạn chưa được kích hoạt!");
                    Auth::logout();
                    return redirect()->back(); 
                }

                $request->session()->regenerate();
                toastr()->success('Đăng nhập thành công');

                return redirect()->route('dashboard');

            }

            toastr()->error('Thông tin xác thực được cung cấp không khớp với hồ sơ của chúng tôi.');
            return redirect()->back()->withInput();

        } catch (\Throwable $th) {
            toastr()->error($th->getMessage());
            return redirect()->back();
        }
    }

    public function logout($request) {
        try {
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            toastr()->info('Đăng xuất thành công');
            return redirect()->route('login');
        } catch (\Throwable $th) {
            toastr()->error($th->getMessage());
            return redirect()->back();
        }
    }

    public function updateProfile($request) {
        try {
            $data = $request->validated();
            $user = Auth::user();

            if ($request->hasFile('avatar')) {
                $data['avatar'] = $this->firebaseService->uploadFile($request->file('avatar'), 'avatar');
            }

            $user->update($data);

            if (isset($data['staff'])) {
                if (!$user?->staff) {
                    $data['staff']['code'] = $this->generateCodeStaff();

                    $user->staff()->create($data['staff']);
                }else {
                    $user->staff->update($data['staff']);
                }
            } 

            toastr()->success('Cập nhật thông tin thành công');
            return redirect()->back();
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
}