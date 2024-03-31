<?php

namespace Mpob\Syndicates\Controllers;

use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Auth;
use Mpob\Syndicates\Models\Note;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Throwable;

class NoteController extends Controller
{
    /**
     * @param Request $request
     * @param $syndicateId
     * @return RedirectResponse
     */
    public function store(Request $request, $syndicateId): RedirectResponse
    {
        $request->validate([
            'description'=>'required',
            'date'=>'required'
        ]);

        try{
            $note = new Note();
            $note->DESCRIPTION = $request->input('description');
            $note->INSERT_DT = $request->input('date');
            $note->CREATED_BY = Auth::id();
            $note->SYNDICATE_ID_ = $syndicateId;
            $note->save();

            Log::info('Create new note', $note->toArray());
        }catch (Throwable $throwable){
            Log::error($throwable->getMessage());

            return redirect()->route('syndicates.edit',$syndicateId)->with('throwable', __($throwable->getMessage()));
        }

        return redirect()->route('syndicates.edit',$syndicateId)->with('success', __('Nota berjaya disimpan'));
    }

    /**
     * @param Request $request
     * @param $syndicateId
     * @param $noteId
     * @return JsonResponse
     */
    public function upload(Request $request, $syndicateId, $noteId): JsonResponse
    {

        try {
            $note = Note::find($noteId);
            $note->addMediaFromRequest('file')->toMediaCollection('file');
        }catch (Throwable $throwable){
            Log::error($throwable->getMessage());

            return response()->json(
                ['message'=> $throwable->getMessage()], 500);
        }

        return response()->json(
            [
                'message'=> "Successfully upload documents",
                'media' => $note->media->last(),
                'note' => $note,
                'syndicateId' => $syndicateId
            ]);

    }

    /**
     * @param Request $request
     * @param $syndicateId
     * @param $noteId
     * @return JsonResponse
     */
    public function delete(Request $request, $syndicateId, $noteId): JsonResponse
    {
        $mediaId = $request->input('media_id');
        try{
            Note::whereHas('media', function ($query) use($mediaId){
                $query->whereId($mediaId);
            })->find($noteId)->deleteMedia($mediaId);
        }catch (Throwable $throwable){
            Log::error($throwable->getMessage());

            return response()->json(
                ['message'=> $throwable->getMessage()], 500);
        }

        return response()->json(
            [
                'message'=> "Successfully deleted documents",
            ]);

    }
}
