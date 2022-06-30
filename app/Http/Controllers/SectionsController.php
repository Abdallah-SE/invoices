<?php

namespace App\Http\Controllers;

use App\Models\Sections;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use Session;
class SectionsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $sections = Sections::all();
        return view('sections.sections', compact('sections'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $req)
    { 
        $this->validate($req, [
            'section_name' => 'required|unique:Sections|min:6|max:50',
            'description' =>  'max:200',
        ],[
            'section_name.required' => 'يرجي عدم ترك حقل القسم فارغا!',
            'section_name.unique' => 'خطأ برجاء عدم تكرار القسم الموجود بالفعل!',
            'section_name.min' => 'يجب ان لا يقل حقل القسم عن ستة احرف',
            'description.max' => 'خطأ يجب ان لا يزيد الوصف عن مأتي حرف',
        ]);
        $data = $req->all();
        
        $section_exists = Sections::where('section_name', '=', $data['section_name'])->exists();
        
        if($section_exists){
            Session::flash('add', 'Oops while creating the section');
            return redirect('/sections');
        }else{
            $section = new Sections();
            $section->section_name = $data['section_name'];
            $section->description = $data['description'];
            $section->created_by = Auth::user()->name;
            $section->save();       
            Session::flash('success', 'Great the Section was created successfully');
            session()->flash('Add', 'Great the Section was created successfully');
            return redirect('/sections');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Sections  $sections
     * @return \Illuminate\Http\Response
     */
    public function show(Sections $sections)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Sections  $sections
     * @return \Illuminate\Http\Response
     */
    public function edit(Sections $sections)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Sections  $sections
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $id = $request->id;
        
        $this->validate($request, [
            'section_name' => 'required|min:6|max:50|unique:sections,section_name,'.$id,
            'description' =>  'max:200',
        ],[
            'section_name.required' => 'يرجي عدم ترك حقل القسم فارغا!',
            'section_name.unique' => 'خطأ برجاء عدم تكرار القسم الموجود بالفعل!',
            'section_name.min' => 'يجب ان لا يقل حقل القسم عن ستة احرف',
            'description.max' => 'خطأ يجب ان لا يزيد الوصف عن مأتي حرف',
        ]);
        
        $section = Sections::find($id);
        $section->update([
            'section_name' => $request->section_name,
            'description' => $request->description 
        ]);
        Session::flash('edit', 'Great the Section was updated successfully');
        return redirect('/sections');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Sections  $sections
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $id = $request->id;
        $status = Sections::find($id)->delete();
        if(!$status){
            Session::flash('delete', 'Oops!! error while deleting the section!');
            return redirect('/sections');
        }
         Session::flash('delete', 'Great the section was deleted successfully');
        return redirect('/sections');
    }
}
