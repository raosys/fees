<?php

namespace Raosys\Fees\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Raosys\Fees\Models\EntryItem;
use Raosys\Fees\Models\FeeStructure;

class FeeStructureController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $fee_structures = FeeStructure::orderBy('created_at', 'desc')->get();
        $columns  = config('fees.course_table_columns');
        return view('fees::fee_structure.index', compact('user', 'fee_structures', 'columns'));
    }

    // Store the newly created resource in the db
    public function store(Request $request)
    {
        // dd($request->all());
    }



    // show fee structure
    public function show(FeeStructure $structure)
    {
        $user = auth()->user();
        return view('fees::fee_structure.show', compact('user', 'structure'));
    }
}
