<?php

namespace Mpob\Syndicates\Controllers;

use App\Http\Controllers\Controller;

use Mpob\Syndicates\Models\Network;
use Mpob\Syndicates\Models\RefDistrict;
use Mpob\Syndicates\Models\ExtLcn;
use Mpob\Syndicates\Models\Syndicate;
use Mpob\Syndicates\Models\Relationship;
use Mpob\Syndicates\Models\RefCountryState;
use Mpob\Syndicates\Models\SyndicateType;
use Mpob\Syndicates\Models\TrcAcc;
use Mpob\Syndicates\Models\TrcPalmTrade;
use Mpob\Syndicates\Models\TrcTxrptTrade;
use App\Traits\SyndicateTrait;
use Carbon\Carbon;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Throwable;

class NetworkController extends Controller
{
    use SyndicateTrait;

    /**
     * @param Request $request
     * @param $id
     * @return View
     */
    public function index(Request $request, $id): View
    {
        $syndicates = collect();
        $syndicate = Syndicate::find($id);

        if ($request->input('name')) {

//            $trc_acc_skeleton = $syndicate->trc_acc_skeleton;
//            $syndicate_skeleton = $syndicate->syndicate_skeleton;
//            $mergeSkeleton = $trc_acc_skeleton->merge($syndicate_skeleton);
//            $networks = collect($mergeSkeleton->all());
//            $networkIds = $networks->pluck('id_');

            $syndicates = Syndicate::query()->searchNetwork($request);
            $trc_acc = TrcAcc::query()->searchNetwork($request);
            $syndicates = $syndicates->unionAll($trc_acc)->paginate(15);

        }


        $states = RefCountryState::with('cities')->get();
        $cities = RefDistrict::with('state')->get();
        $relationships = Relationship::pluck('name_', 'id_');

        return view('syndicates::networks.index', compact(
            'syndicates',
            'states',
            'cities',
            'syndicate',
            'relationships'
        ));
    }

    /**
     * @param Request $request
     * @param $syndicateId
     * @return RedirectResponse
     */
    public function link(Request $request, $syndicateId): RedirectResponse
    {
        $request->validate(['relationship_id' => 'required']);

        //will be use redirect route with url query
        $params = $request->except(["_token", "model_id","model_type"]);
        $params["syndicate"] = $syndicateId;

        try {

            $model_prefix = "App\Models";
            $modelType = $model_prefix . '\\' . $request->input('model_type');
            $modelId = $request->input('model_id');

            //from
            $syndicate = Syndicate::find($syndicateId);
            $syndicate->networks()->syncWithPivotValues([
                "to_id"=>$modelId,
            ],[
                "relationship_id"=>$request->input('relationship_id'),
                "to_type"=>$modelType,
            ], false);

            //to
            $model = $modelType::find($modelId);
            $model->networks()->syncWithPivotValues([
                "to_id"=>$syndicate->id_,
            ],[
                "relationship_id"=>$request->input('relationship_id'),
                "to_type"=>$model_prefix. "\\" . "Syndicate",
            ], false);


        } catch (Throwable $throwable) {
            Log::error($throwable->getMessage());
            return redirect()->route('networks.index', $params)
                ->with('throwable', __($throwable->getMessage()));
        }

        return redirect()->route('networks.index', $params)
            ->with('success', __('Profile sindiket berjaya dihubung'));
    }

    /**
     * @param Request $request
     * @param $syndicateId
     * @return RedirectResponse
     */
    public function unlink(Request $request, $syndicateId): RedirectResponse
    {
        $request->validate(['model_type' => 'required', 'model_id' => 'required']);

        try {

            $model_prefix = "App\Models";
            $modelType = $model_prefix . '\\' . $request->input('model_type');
            $modelId = $request->input('model_id');

            //from
            $syndicate = Syndicate::find($syndicateId);
            $syndicate->networks()->detach(["to_id"=>$modelId]);

            //to
            $model = $modelType::find($modelId);
            $model->networks()->detach(["to_id"=>$syndicate->id_]);


        } catch (Throwable $throwable) {
            Log::error($throwable->getMessage());
            return redirect()->route('syndicates.show', $syndicateId)->with('throwable', __($throwable->getMessage()));
        }

        return redirect()->route('syndicates.show', $syndicateId)->with('success', __('Profile sindiket berjaya dinyah hubung'));
    }
}
