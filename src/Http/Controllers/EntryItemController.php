<?php

namespace Raosys\Fees\Http\Controllers;

use App\Http\Controllers\Controller;
use CreateEntryItemsTable;
use Illuminate\Http\Request;
use Raosys\Fees\Http\Requests\CreateEntryItemRequest;
use Raosys\Fees\Http\Requests\UpdateEntryItemRequest;
use Raosys\Fees\Models\EntryItem;

class EntryItemController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateEntryItemRequest $request)
    {
        return EntryItem::create($request->validated());
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
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateEntryItemRequest $request, EntryItem $entry)
    {
        $entry->update($request->validated());
        return $entry;
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(EntryItem $entry)
    {
        $entry->delete();
        return response()->json(null, 204);
    }
}
