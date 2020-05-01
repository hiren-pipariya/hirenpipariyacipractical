<?php

namespace App\Http\Controllers;

//Laravel Packages
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Config;
use Validator;

//Package for datatable
use Yajra\Datatables\Datatables;

//Models
use App\Skill;

class SkillController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('skill.index');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function datatable(Request $request)
    {
        $getdata =  Skill::get();
        return Datatables::of($getdata)->make(true);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('skill.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $input = $request->all();
        $dataArr = array(
            'skill'          => $input['skill'],
            'slug'          => Str::of($input['skill'])->slug('-'),
        );
        $validCheck = Validator::make($dataArr, [
            'skill' => ['required', 'string', 'max:255','unique:skills'],
            'slug' => ['required', 'max:255','unique:skills'],
        ]);
        if($validCheck->fails()){
            return redirect()->back()->withErrors($validCheck)->withInput();
        }
        $tag = Skill::create($dataArr);
        return redirect('/skill')->with("success", "Project tags added successfully");

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Skill  $skill
     * @return \Illuminate\Http\Response
     */
    public function show(Skill $skill)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $form = Skill::find($id);
        $form = $form->toArray();
        if(empty($form)){
            return redirect('/admin/skill')->with("error", "Project tags not found.");
        }
        $dataArr = array('id' => $id);
        $dataArr['skill'] = $form['skill'];
        return view('skill.edit')->with('form', (object)$dataArr);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,$id)
    {
        $input = $request->all();
        $skill = Skill::find($id);
        if($input['skill'] == $skill->skill){
            return redirect('/skill')->with("success", "skill updated successfully");
        }
        $dataArr = array(
            'skill'          => $input['skill'],
            'slug'          => Str::of($input['skill'])->slug('-'),
        );
        $validCheck = Validator::make($dataArr, [
            'skill' => ['required', 'string', 'max:255','unique:skills'],
            'slug' => ['required', 'max:255','unique:skills'],
        ]);
        if($validCheck->fails()){
            return redirect()->back()->withErrors($validCheck)->withInput();
        }
        $skill->update($dataArr);
        return redirect('/skill')->with("success", "skill updated successfully");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Skill  $skill
     * @return \Illuminate\Http\Response
     */
    public function destroy(Skill $skill)
    {
        $skill->delete();
        DB::table('user_skills')->where('skill_id',$skill->id)->delete();
        return response()->json(["message" => 'Skill deleted!'], 200);
    }
}
