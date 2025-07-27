<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Student\StoreRequest;
use App\Models\User;
use App\Services\Admin\StudentService;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    public function __construct(protected StudentService $service)
    {
    }
    public function list(Request $request)
    {
        $data['nav'] = 'student';
        $data['sub_nav'] = '';
        $data['page_title'] = 'Student';
        $per_page = 20;
        $page =  $request->page ?? 1;
        $data['q'] = $request->q ?? '';
        $data['result'] = $this->service->list($per_page, $page, $data['q']);
        return view('admin.student.list', $data);
    }

    public function addEdit(Request $request)
    {
        $data['nav'] = 'student';
        $data['sub_nav'] = '';
        $id = $request->id ?? 0;
        $data['page_title'] =  ($id == 0) ? "Add Student" : "Edit Student";
        $data['action'] = route('admin-student-store');
        $data['row'] = User::where('id', $id)->first();
        return view('admin.student.add', $data);
    }
    public function delete(Request $request)
    {
        return $this->service->delete($request);
    }
}
