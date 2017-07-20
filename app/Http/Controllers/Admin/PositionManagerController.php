<?php

namespace App\Http\Controllers\Admin;

use App\Position;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Http\Response;
use App\User;


class PositionManagerController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin');
    }

    /**
     * show new position form
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function showNewPositionForm() {
        return view('admin.add-position');
    }

    /**
     * create new position
     * @param Request $request
     * @return Response
     */
    public function newPosition(Request $request) {
        //validate request
        $this->validateNewPosition($request);

        //create and store new division to database
        $this->store($request->all());


        return redirect()->route('admin.positions')->with('message', 'create new position success');
        //redirect to list division
    }

    /**
     * create new position and store to database
     * @param array $data
     * @return Position createdDivision
     */
    protected function store(array $data) {
        return Position::create([
            'name' => $data['name'],
            'level' => $data['level'],
            'description' => $data['description'],
        ]);
    }

    /**
     * validate new position
     * @param Request $request
     */
    public function validateNewPosition(Request $request) {
        $this->validate($request, [
            'name' => 'required|min:1|unique:positions',
            'level' => 'numeric|required',
        ], [
            'name.required' => 'You must specific division name!',
            'name.unique' => 'Division name must be unique!',
            'level.required' => 'You mus specific level of Position' ,
            'level.numeric' => 'Level must be number',
        ]);
    }


    /**
     * show list position
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function showListPosition() {
        $positions = Position::all();
        return view('admin.list-position')->with(compact('positions'));
    }

    /**
     * show edit position form
     * @param $id
     * @return View
     */
    public function edit($id) {
        try {
            $position = Position::findOrFail($id);
            return view('admin.edit-position')->with(compact('position'));
        } catch (ModelNotFoundException $exception) {
            return view('admin.not-found');
        }

    }

    /**
     * update position
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $id) {
        //validate division
        $position = Position::findOrFail($id);

        $this->validateUpdatePosition($request, $position);

        //update division
        $position = Position::findOrFail($position->id);
        $position->name = $request->input('name');
        $position->level = $request->input('level');
        $position->description = $request->input('description');
        $position->save();

        //redirect
        return redirect()->route('admin.positions')->with('message', 'Position has been update success!');

    }

    /**
     * Validate data before update position
     * @param Request $request
     * @param Position $position
     */
    protected function validateUpdatePosition(Request $request, Position $position) {
        $this->validate($request, [
            'name' => 'required|min:1|unique:positions,name,'.$position->id.',id',
            'level' => 'numeric|required',
        ], [
            'name.required' => 'You must specific position name!',
            'level.required' => 'You mus specific level of Position' ,
            'level.numeric' => 'Level must be number',
        ]);
    }

    public function destroy($id){
        $users = User::where('position_id', '=', $id)->get();

        if ($users->count() > 0 ) {
            return redirect()->back()->withErrors(array('Position still have users'));
        }

        try {
            $position = Position::findOrFail($id);
            $position->delete();
            return redirect()->route('admin.positions')->with('message', 'Position has been deleted!');
        } catch (ModelNotFoundException $exception) {
            return redirect()->back()->withErrors(array('position not existed!'));
        }

    }
}
