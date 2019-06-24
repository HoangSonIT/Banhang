<?php
/**
 * Created by PhpStorm.
 * User: truongkobe
 * Date: 12/4/2018
 * Time: 5:00 PM
 */

namespace App\Http\Controllers\Backend;


use App\Http\Controllers\Controller;
use App\Repositories\LogActionRepository as LogAction;
use App\Repositories\PermissionRepository as Permission;
use App\Repositories\RolePermissionRepository as RolePermission;
use Illuminate\Http\Request;
use Prettus\Validator\Exceptions\ValidatorException;

class PermissionController extends Controller
{
    protected $permission;
    protected $rolePermission;

    public function __construct(Request $request, LogAction $logAction, Permission $permission, RolePermission $rolePermission)
    {
//        $this->middleware('auth');
        parent::__construct($request, $logAction);
        $this->permission = $permission;
        $this->rolePermission = $rolePermission;
    }

    public function importPermissions()
    {
        $data = [];
        if ($file = fopen("D:\permission.txt", "r")) {
            while (!feof($file)) {
                $line = fgets($file);
                if ($line != '') {
                    $data[] = [
                        'SLUG' => $line
                    ];
                }
            }
            fclose($file);

            $this->permission->insertBatch($data);

            echo "Done";
        }
    }

    public function importPermissionForAdmin()
    {
        $roleId = 2;
        $permissions = [50, 51, 52, 53, 54, 55, 56, 57, 58, 59, 60, 61, 62, 63, 64];
        $data = [];

        foreach ($permissions as $permission) {
            $data[] = [
                'PERMISSION_ID' => $permission,
                'ROLE_ID' => $roleId
            ];
        }

       //log_die($data);
        $this->rolePermission->insertBatch($data);

        echo "Done";
    }

    public function importPermissionForOwner()
    {
        $roleId = 3;
        $permissions = [1, 2, 3, 4, 5, 6, 7, 8, 16, 17, 18, 19, 20, 21, 22, 23, 24, 25, 26, 27, 28, 29, 30,
            31, 32, 33, 34, 35, 36, 37, 38, 39, 40, 41, 42, 43, 44, 45, 46, 47, 48, 49, 65];
        $data = [];

        foreach ($permissions as $permission) {
            $data[] = [
                'PERMISSION_ID' => $permission,
                'ROLE_ID' => $roleId
            ];
        }

//        log_die($data);
        $this->rolePermission->insertBatch($data);

        echo "Done";
    }

    public function importPermissionForTeamLeader()
    {
        $roleId = 5;
        $permissions = [1, 5, 6, 9, 10, 11, 12, 13, 14, 15, 16, 65];
        $data = [];

        foreach ($permissions as $permission) {
            $data[] = [
                'PERMISSION_ID' => $permission,
                'ROLE_ID' => $roleId
            ];
        }

//        log_die($data);
        $this->rolePermission->insertBatch($data);

        echo "Done";
    }

    public function importPermissionForShipper()
    {
        $roleId = 4;
        $permissions = [1, 5, 6, 16, 17, 18, 65];
        $data = [];

        foreach ($permissions as $permission) {
            $data[] = [
                'PERMISSION_ID' => $permission,
                'ROLE_ID' => $roleId
            ];
        }

//        log_die($data);
        $this->rolePermission->insertBatch($data);

        echo "Done";
    }

    public function importPermissionForTelesales()
    {
        $roleId = 1;
        $permissions = [1, 5, 6, 10, 12, 13, 14, 15, 16, 65];
        $data = [];

        foreach ($permissions as $permission) {
            $data[] = [
                'PERMISSION_ID' => $permission,
                'ROLE_ID' => $roleId
            ];
        }

//        log_die($data);
        $this->rolePermission->insertBatch($data);

        echo "Done";
    }

    public function importPermissionForSuperUser()
    {
        $roleId = 6;
        $data = [];
        for ($i = 1; $i <= 65; $i++) {
            $data[] = [
                'PERMISSION_ID' => $i,
                'ROLE_ID' => $roleId
            ];
        }

//        log_die($data);
        $this->rolePermission->insertBatch($data);

        echo "Done";
    }

    protected function validateData($data)
    {
        $validator = \Validator::make($data,
        [
            'SLUG'=>'required',
            'STATUS'=>'required',
        ],
        [
            'required'=>'Điền thiếu thông tin'
        ]);
        return $validator;
    }
    public function getIndex()
    {
        $permission = $this->permission->orderBy('PERMISSION_ID')->paginate();

        $data = [
            'title'=>'Quản lý phân quyền',
            'permission' => $permission
        ];
        return view('backend.staff.permission.index', $data);
    }
    public function insert()
    {
        $data = [
            'title'=>'Quản lý phân quyền'
        ];
        return view('backend.staff.permission.insert', $data);
    }
    public function insertPost()
    {     
        $data = get_request_data($this->request);

        $validator = $this->validateData($data);

        if ($validator->fails()) {
            return redirect_back_fail($validator->errors()->first());
        } else {
            $this->permission->create($data);
                return redirect_with_message('permission-insert-get', insert_success());
        } 
            return redirect_with_message('permission-insert-get', insert_failed());   
    }
    public function update($id = 0)
    {
        $permission = null;

        try {
            $permission = $this->permission->find($id);
        } catch (\Exception $e) {
        }

        if ($permission == null) {
            return redirect_with_message('permission-index', record_not_found());
        }

        $data = [
            'title' => 'Sửa quyền',
            'permission' => $permission,
        ];        
        return view("backend.staff.permission.update", $data);
    }
    public function updatePost($id = 0)
    {
        $permission = null;
        $id = $this->request->get('PERMISSION_ID');

        try {
            $permission = $this->permission->find($id);
        } catch (\Exception $e) {
        }
        if ($permission == null) {
            return redirect_with_message('permission-index', record_not_found());
        }
        $data = get_request_data($this->request);

        $validator = $this->validateData($data);  
        if ($validator->fails()) {
            return redirect_back_fail($validator->errors()->first());
        } else {  
            $this->permission->update($data, $id);
                return redirect_with_message('permission-index', update_success());
        }
            return redirect_with_message('permission-index', update_failed());  
    }
    
    public function delete($id = 0)
    {
        $permission = null;
        try {
            $permission = $this->permission->find($id);
        } catch (\Exception $e) {
        }

        if ($permission == null) {
            return redirect_with_message('permission-index', record_not_found());
        }else{
            $this->permission->update(['STATUS' => -1], $id);
            return redirect('staff/permissions')->with('success', 'Dữ liệu đã bị xóa!!');           
        }
    }
}
