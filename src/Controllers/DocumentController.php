<?php

namespace Mpob\Syndicates\Controllers;

use App\Http\Controllers\Controller;

use Mpob\Syndicates\Models\Media;
use Mpob\Syndicates\Models\Syndicate;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Throwable;

class DocumentController extends Controller
{
    /**
     * @param Request $request
     * @param $id
     * @return JsonResponse
     */
    public function upload(Request $request, $id): JsonResponse
    {
        try {
            DB::beginTransaction();
            $syndicate = Syndicate::find($id);

            if ($request->hasFile('file') && $request->file('file')->isValid()) {
                $newName = $request->input('name');
                $newFileName = $newName . '.' . $request->file('file')->extension();
                $syndicate->addMedia($request->file('file'))
                    ->usingName($newName)
                    ->usingFileName($newFileName)
                    ->withCustomProperties([
                        'uploaded_by' => Auth::id()
                    ])
                    ->toMediaCollection('syndicate-documents');
            }

            DB::commit();
        } catch (Throwable $throwable) {
            DB::rollBack();
            Log::error($throwable->getMessage());

            return response()->json(["message" => $throwable->getMessage()], 500);
        }

        $media = Media::latest()->first();
        $media->createdAt = Carbon::parse($media->create_dt)->format('d/m/Y');

        return response()->json([
            "message" => __('Imej / Dokumen berjaya di muat naik'),
            'data'=>$media
        ]);
    }

    /**
     * @param Request $request
     * @param $syndicateId
     * @return JsonResponse
     */
    public function delete(Request $request, $syndicateId): JsonResponse
    {
        $mediaId = $request->input('media_id');
        try{
            Syndicate::whereHas('media', function ($query) use($mediaId){
                $query->whereId($mediaId);
            })->find($syndicateId)->deleteMedia($mediaId);

//            $media = Media::find($mediaId);
//            dd($mediaId,$media);
//            $model = Syndicate::find($media->model_id);
//            $model->deleteMedia($media->id);

        }catch (Throwable $throwable){
            Log::error($throwable->getMessage());

            return response()->json(
                ['message'=> $throwable->getMessage()], 500);
        }

        return response()->json(
            [
                'message'=> __("Imej / Dokumen berjaya dipadamkan"),
            ]);

    }
}
