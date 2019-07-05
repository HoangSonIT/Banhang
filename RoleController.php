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
use App\Repositories\RoleRepository as Role;
use App\Repositories\RolePermissionRepository as RolePermission;
use Illuminate\Http\Request;
use Prettus\Validator\Exceptions\ValidatorException;

class RoleController extends Controller
{
    protected $role;
    protected $rolePermission;

    public function __construct(Request $request, LogAction $logAction, Role $role, RolePermission $rolePermission)
    {
//        $this->middleware('auth');
        parent::__construct($request, $logAction);
        $this->role = $role;
        $this->rolePermission = $rolePermission;
    }

    protected function validateData($data)
    {
        $validator = \Validator::make($data,
        [
            'NAME'=>'required',
            'CODE'=>'required',
            'STATUS'=>'required',
        ],
        [
            'required'=>'Điền thiếu thông tin'
        ]);
        return $validator;
    }
    public function getIndex()
    {
        $role = $this->role->orderBy('ROLE_ID')->paginate();

        $data = [
            'title'=>'Quản lý chức danh',
            'role' => $role
        ];
        return view('backend.staff.permission.role.index', $data);
    }
    public function insert()
    {
        $data = [
            'title'=>'Quản lý phân quyền'
        ];
        return view('backend.staff.permission.role.insert', $data);
    }
    public function insertPost()
    {     
        $data = get_request_data($this->request);

        $validator = $this->validateData($data);

        if ($validator->fails()) {
            return redirect_back_fail($validator->errors()->first());
        } else {
            $this->role->create($data);
                return redirect_with_message('role-insert-get', insert_success());
        } 
            return redirect_with_message('role-insert-get', insert_failed());   
    }
    public function update($id = 0)
    {
        $role = null;

        try {
            $role = $this->role->find($id);
        } catch (\Exception $e) {
        }

        if ($role == null) {
            return redirect_with_message('role-index', record_not_found());
        }

        $data = [
            'title' => 'Sửa chức danh',
            'role' => $role,
        ];        
        return view("backend.staff.permission.role.update", $data);
    }
    public function updatePost($id = 0)
    {
        $role = null;
        $id = $this->request->get('ROLE_ID');

        try {
            $role = $this->role->find($id);
        } catch (\Exception $e) {
        }
        if ($role == null) {
            return redirect_with_message('role-index', record_not_found());
        }
        $data = get_request_data($this->request);

        $validator = $this->validateData($data);  
        if ($validator->fails()) {
            return redirect_back_fail($validator->errors()->first());
        } else {  
            $this->role->update($data, $id);
                return redirect_with_message('role-index', update_success());
        }
            return redirect_with_message('role-index', update_failed());  
    }
    
    public function delete($id = 0)
    {
        $role = null;
        try {
            $role = $this->role->find($id);
        } catch (\Exception $e) {
        }

        if ($role == null) {
            return redirect_with_message('role-index', record_not_found());
        }else{
            $this->role->update(['STATUS' => -1], $id);
            return redirect('staff/roles')->with('success', 'Dữ liệu đã bị xóa!!');           
        }
    }
}
