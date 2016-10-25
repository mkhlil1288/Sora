<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\User;
use App\Permission;
use App\Http\Requests;

class ApiUserController extends Controller
{
     public function index()
    {
        $permissions = Permission::select('id','name')->get();
        $data = User::paginate(20);
        return response()->json([
            'data' => $data,
            'permissions' => $permissions
        ]);
        // $items = User::latest()->paginate(20);
        // $response = [
        //     'pagination' => [
        //         'total' => $items->total(),
        //         'per_page' => $items->perPage(),
        //         'current_page' => $items->currentPage(),
        //         'last_page' => $items->lastPage(),
        //         'from' => $items->firstItem(),
        //         'to' => $items->lastItem()
        //     ],••••••••••••••••••••••
        //     'data' => $items
        // ];
        // return $response
    }
    public function store(Request $request)
    {
        $input = $request->all();
        $input['password'] = bcrypt($input['password']);
        User::create($input);
    }
    public function show($id)
    {
        return User::findOrFail($id);
    }
    public function update(Request $request, $id)
    {
      $input = $request->all();
        if(!empty($input['password'])){
            $input['password'] =  bcrypt($input['password']);
        }else{
            $input = array_except($input,array('password'));
        }
        User::findOrFail($id)->update($input);
        // return Response::json($request->all()); //response()->json()
    }
    public function destroy($id)
    {
        return User::destroy($id);
    }
}
