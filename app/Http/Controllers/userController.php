<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\User;
use Datatables;
use URL;
use Form;

class userController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('user');
    }

    // get data for datatable
    public function getdatauser(){
        $query = User::orderBy('opr_id','DESC')->select();

        return Datatables::of($query)
        ->editColumn('opr_status',function($row){
            $array = array('TRUE' => 'Aktif',
                            TRUE => '<span class="">Aktif',
                            'FALSE' => 'Non Aktif',
                            FALSE => 'Non Aktif');
            return $array[$row->opr_status];
        })
        ->addColumn('aksi', function ($row) {
            $button = "<div class='btn-group-vertical'>";
            $button .= "<a type='button' class='btn btn-warning btn-xs' href='". URL::to('user/'.$row->opr_id.'/edit') ."'><i class='fa fa-pencil'></i>&nbsp; EDIT</a>";
            $button .=  Form::open(array('url' => 'user/' .$row->opr_id . '', 'class' => 'pull-right')).
                        ''. Form::hidden("_method", "DELETE") .
                        ''. Form::submit("DELETE", array("class" => "btn btn-danger btn-delete btn-xs")) .
                        ''. Form::close();
            $button .= "</div>";
            return $button;
        })  
        ->make(true);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('user-create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $del = User::find($id);
        $del->delete();

        flash('Data Berhasil Dihapuskan !', 'success');
        return redirect('user');
    }
}
