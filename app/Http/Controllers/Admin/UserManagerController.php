<?php

namespace App\Http\Controllers\Admin;

use App\Division;
use App\Position;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Mail;
use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Illuminate\Support\Facades\DB;
use Excel;

class UserManagerController extends Controller
{
    //

    use SendsPasswordResetEmails;

    public function __construct() {
        $this->middleware('admin');
    }

    public function index() {

        $this->showListUser();
    }

    /**
     * create new user
     * @param Request $request
     * @return Response
     */

    public function newUser(Request $request) {
        //validate data
        $this->validateNewUser($request);
        //create new user
        $user = $this->storeUser($request->all());


        $this->notifyAfterCreateUser($request->all());

        return redirect()->route('admin.users')->with('message', 'create new user success');
    }

    /**
     * create new user with model
     * @return User new-user
     */
    protected function storeUser(array $data) {
        return User::create([
            'username' => $data['username'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
            'is_admin' => $data['is_admin'],
            'is_active' => '0',
            'division_id' => $data['division_id'],
            'position_id' => $data['position_id'],
        ]);
    }

    /**
     * show new user form
     * @return void
     */
    public function showNewUserForm() {
        $divisions = Division::all();
        $positions = Position::all();
        return view('admin.new-user')->with(compact('divisions', 'positions'));
    }

    /**
     *validate user information before create
     * @param Request $request
     * @return void
     */

    protected function validateNewUser(Request $request) {
        $this->validate($request, [
            'username' => 'required|string|min:6|unique:users',
            'email' => 'required|string|email|unique:users',
            'password' => 'required|string|min:6|confirmed',
            'is_admin' => 'required'
        ], [
            'username.required' =>'username required',
            'username.min'    => 'username\'s length must >= 6',
            'username.unique' => 'username exsisted!',
            'email.required' =>'email required',
            'email.email' =>'you must fill email',
            'password.required' => 'password required',
            'password.min' => 'password\'s length must >= 6',
            'password.confirmed' => 'please type same password',
        ]);
    }

    /**
     * validate new user
     * @param Request $request
     * @param  $user
     */
    public function validateUpdateUser(Request $request, User $user) {
        $this->validate($request, [
            'email' => 'required|string|email|unique:users,email,'.$user->id.',id',
        ]);
    }

    /**
     * notify after create new user
     * @param array $data : new user information
     * @return void
     */
    protected function notifyAfterCreateUser(array $data) {
        Mail::send('emails.new-user', $data, function($message) use($data){
            $message->to($data['email'])->subject('Welcome!');
        });
    }


    /**
     * show list user
     * @return void
     */
    public function showListUser() {
        $users = User::where('id', '!=', Auth::id())->paginate(5);
        return view('admin.list-user')->with(compact('users'));
    }

    /**
     * show form edit user
     * @param int $id
     * @return View
     */

    public function editUser($id) {
        try {
            $user = User::findOrFail($id);
            $divisions = Division::all();
            $positions = Position::all();
            return view('admin.edit-user')->with(compact('user', 'divisions', 'positions'));
        } catch (ModelNotFoundException $exception) {
            return view('admin.not-found');
        }

    }

    /**
     * update user information
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */

    public function updateUser(Request $request,$id) {
        //find user
        $user = User::findOrFail($id);
        if (!$user) {
            return redirect()->back()->with('message', 'User not existed!');
        }

        $this->validateUpdateUser($request, $user);


        //update user info
        if ($request->input('password')) {
            $user->password = bcrypt($request->input('password'));
        }
        $user->email = $request->input('email');
        $user->is_admin = $request->input('is_admin');
        $user->division_id = $request->input('division_id');
        $user->position_id = $request->input('position_id');
        //save the change
        $user->save();
        return redirect()->route('admin.users')->with('message', 'User has been update success!');
    }


    /**
     * Destroy user
     * @param $id
     * @return $this|\Illuminate\Http\RedirectResponse
     */

    public function destroyUser($id) {
        if ($id != Auth::user()->id) {
            try {
                $user = User::findOrFail($id);
                $user->delete();
                return redirect()->route('admin.users')->with('message', 'User has been deleted!');
            }catch (ModelNotFoundException $exception) {
                return redirect()->back()->withErrors(array('User not existed!'));
            }

        }
    }

    /**
     * Reset mail group
     * @param Request $request
     */
    public function resetMailGroup(Request $request) {

        foreach ($request->data as $id) {
            $user = User::findOrFail($id);
            $this->broker()->sendResetLink(
                ['email' => $user->email]
           );
        }

    }

    /**
     * export user list to exel
     */
    public function exportToExcel()
    {

        $export = DB::table('users')
            ->leftJoin('divisions', 'users.division_id', '=', 'divisions.id')
            ->leftJoin('positions', 'users.position_id', '=', 'positions.id')
            ->select('users.id as ID', 'users.username as USERNAME', 'users.email as EMAIL', 'divisions.name as DIVISION', 'positions.name as POSITION')
            ->get();
        $export = $export->map(function ($item) {
            return get_object_vars($item);
        });
        Excel::create('export data', function ($excel) use ($export) {
            $excel->sheet('Sheet 1', function ($sheet) use ($export) {
                $sheet->fromArray($export);
            });
        })->export('xlsx');
    }

    /**
     * Return list user in division
     * @param $division_id
     * @return \Illuminate\Contracts\View\Factory|View
     */
    public function userInDivision($division_id) {
        try {
            $division = Division::findOrFail($division_id);
            $users =  User::where('division_id','=',$division_id)->paginate(5);
            return view('admin.list-user-in-division')->with(compact('division','users'));
        } catch (ModelNotFoundException $exception) {
            return view('admin.not-found');
        }





    }



}
