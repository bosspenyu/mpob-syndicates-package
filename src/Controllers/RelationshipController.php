<?php

namespace Mpob\Syndicates\Controllers;

use App\Http\Controllers\Controller;

use Illuminate\Validation\ValidationException;
use Mpob\Syndicates\Models\Relationship;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;
use Illuminate\View\View;
use Throwable;

class RelationshipController extends Controller
{
    /**
     * @return View
     */
    public function index(): View
    {
        $relationships = Relationship::paginate();
        $trashRelationships = Relationship::onlyTrashed()->paginate();

        return view('syndicates::relationships.index', compact('relationships','trashRelationships'));
    }

    /**
     * @return View
     */
    public function create(): View
    {
        return view('syndicates::relationships.create');
    }

    /**
     * @param Request $request
     * @return RedirectResponse
     * @throws ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $this->validate($request,[
            "name_" => "required|unique:RELATIONSHIPS,NAME_"
        ]);

        try {
            DB::beginTransaction();
            $relationship = new Relationship();
            $relationship->NAME_ = $request->input('name_');
            $relationship->save();
            DB::commit();
        } catch (Throwable $throwable){
            DB::rollBack();
            Log::error($throwable->getMessage());
            return redirect()->route('relationships.index')->with('throwable', __($throwable->getMessage()));
        }

        return redirect()->route('relationships.index')->with('success', __('Hubungan berjaya dicipta'));
    }

    /**
     * @param $id
     * @return View
     */
    public function edit($id): View
    {
        $relationship = Relationship::find($id);
        return view('syndicates::relationships.edit', compact('relationship','id'));
    }

    /**
     * @param Request $request
     * @param $id
     * @return RedirectResponse
     * @throws ValidationException
     */
    public function update(Request $request, $id): RedirectResponse
    {
        $this->validate($request,[
            "name_" => "required|unique:RELATIONSHIPS,NAME_,".$id.",ID_"
        ]);

        try {
            DB::beginTransaction();
            $relationship = Relationship::find($id);
            $relationship->NAME_ = $request->input('name_');
            $relationship->save();
            DB::commit();
        } catch (Throwable $throwable){
            DB::rollBack();
            Log::error($throwable->getMessage());
            return redirect()->route('relationships.edit', $id)->with('throwable', __($throwable->getMessage()));
        }

        return redirect()->route('relationships.index')->with('success', __('Hubungan berjaya dikemaskini'));
    }

    /**
     * @param $id
     * @return RedirectResponse
     */
    public function destroy($id): RedirectResponse
    {
        try {
            DB::beginTransaction();
            $relationship = Relationship::find($id);
            $relationship->delete();
            DB::commit();
        } catch (Throwable $throwable){
            DB::rollBack();
            Log::error($throwable->getMessage());
            return redirect()->route('relationships.index')->with('throwable', __($throwable->getMessage()));
        }

        return redirect()->route('relationships.index')->with('success', __('Hubungan berjaya dipadamkan'));
    }

    /**
     * @param $id
     * @return RedirectResponse
     */
    public function restore($id): RedirectResponse
    {

        try {
            DB::beginTransaction();
            $relationship = Relationship::onlyTrashed()->find($id);
            $relationship->restore();
            DB::commit();
        } catch (Throwable $throwable){
            DB::rollBack();
            Log::error($throwable->getMessage());
            return redirect()->route('relationships.index')->with('throwable', __($throwable->getMessage()));
        }

        return redirect()->route('relationships.index')->with('success', __('Hubungan berjaya dipulihkan'));
    }
}
