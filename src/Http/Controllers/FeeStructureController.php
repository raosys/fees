<?php

namespace Raosys\Fees\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\App;
use Raosys\Fees\Http\Requests\CreateFeeStructureRequest;
use Raosys\Fees\Models\FeeStructure;

class FeeStructureController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $fee_structures = FeeStructure::orderBy('created_at', 'desc')->with('course')->get();
        $columns  = config('fees.course_table_columns');
        $courses =  ($this->getCoursesModel())::all();
        return view('fees::fee_structure.index', compact('user', 'fee_structures', 'columns', 'courses'));
    }

    // Store the newly created resource in the db
    public function store(CreateFeeStructureRequest $request)
    {
        $st =  FeeStructure::create([
            'course_id' => $request->course,
            'serial_code' => $request->serial_code,
            'status' => 'active'
        ]);
        $st->load('course');
        return response()->json($st, 201);
    }



    // show fee structure
    public function show(FeeStructure $structure)
    {
        $user = auth()->user();
        return view('fees::fee_structure.show', compact('user', 'structure'));
    }

    // delete fee structure
    public function destroy(FeeStructure $structure)
    {
        $structure->delete();
        return response()->json(null, 204);
    }

    // get the courses model from config file
    private function getCoursesModel()
    {
        $model = is_array(config('fees.courses_model')) ? config('fees.courses_model')[intval(App::version())] : config('fees.courses_model');
        return  $model;
    }
}
