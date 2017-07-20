<?php

namespace App\Http\Controllers\Admin;

use App\Division;
use App\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\View\View;

class DivisionManagerController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin');
    }

    /**
     * show new division form
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function showNewDivisionForm() {
        return view('admin.add-division');
    }

    /**
     * create new divison
     * @param Request $request
     */
    public function newDivision(Request $request) {
        //validate request
        $this->validateNewDivision($request);

        //create and store new division to database
        $this->store($request->all());


        return redirect()->route('admin.divisions')->with('message', 'create new division success');
        //redirect to list division
    }

    /**
     * create new division and store to database
     * @param array $data
     * @return Division createdDivision
     */
    protected function store(array $data) {
        return Division::create([
            'name' => $data['name'],
            'description' => $data['description'],
        ]);
    }

    /**
     * validate new division
     * @param Request $request
     */
    public function validateNewDivision(Request $request) {
        $this->validate($request, [
            'name' => 'required|min:1|unique:divisions',
        ], [
            'name.required' => 'You must specific division name!',
            'name.unique' => 'Division name must be unique!'
        ]);
    }

    /**
     * show list division
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function showListDivision() {
        $divisions = Division::paginate(5);
        return view('admin.list-division', ['divisions' => $divisions]);
    }


    /**
     * show edit division form
     * @param $id
     * @return View
     */
    public function edit($id) {
        try {
            $division = Division::findOrFail($id);
            return view('admin.edit-division')->with(compact('division'));
        } catch (ModelNotFoundException $exception) {
            return view('admin.not-found');
        }

    }

    /**
     * update division
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $id) {
        //validate division
        $division = Division::findOrFail($id);

        $this->validateUpdateDivision($request, $division);

        //update division
        $division = Division::findOrFail($division->id);
        $division->name = $request->input('name');
        $division->description = $request->input('description');
        $division->save();

        //redirect
        return redirect()->route('admin.divisions')->with('message', 'Division has been update success!');

    }

    /**
     * Validate data before update division
     * @param Request $request
     * @param Division $division
     */
    protected function validateUpdateDivision(Request $request, Division $division) {
        $this->validate($request, [
            'name' => 'required|min:1|unique:divisions,name,'.$division->id.',id',
        ], [
            'name.required' => 'You must specific division name!',
        ]);
    }

    public function destroy($id){
        $users = User::where('division_id', '=', $id)->get();

        if ($users->count() > 0 ) {
            return redirect()->back()->withErrors(array('Division still have users'));
        }

        try {
            $division = Division::findOrFail($id);
            $division->delete();
            return redirect()->route('admin.divisions')->with('message', 'Division has been deleted!');
        } catch (ModelNotFoundException $exception) {
            return redirect()->back()->withErrors(array('Division not existed!'));
        }

    }
}
