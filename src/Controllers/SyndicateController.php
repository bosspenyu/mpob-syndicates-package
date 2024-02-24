<?php

namespace Mpob\Syndicates\Controllers;

use App\Http\Controllers\Controller;

use Mpob\Syndicates\Models\RefDistrict;
use Mpob\Syndicates\Models\RefCountryState;
use Mpob\Syndicates\Models\RefStrSts;
use Mpob\Syndicates\Models\Syndicate;
use Mpob\Syndicates\Models\SyndicateCategory;
use Mpob\Syndicates\Models\SyndicateType;
use Mpob\Syndicates\Models\Tag;
use Mpob\Syndicates\Traits\SyndicateTrait;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Throwable;

class SyndicateController extends Controller
{
    use SyndicateTrait;

    /**
     * @param Request $request
     * @return View
     */
    public function index(Request $request): View
    {
        $query = Syndicate::query();

        if ($request->input('name')) {
            $bindings = explode(" ", $request->input('name'));
            foreach ($bindings as $binding) {
                $query->where('NAME_', 'LIKE', '%' . $binding . '%');
                $query->orWhereHas('trc_acc_skeleton', function ($q) use ($binding) {
                    return $q->where('NAME_', 'LIKE', '%' . $binding . '%');
                });
            }
        }

        if ($request->input('city_id')) {
            $city_id = $request->input('city_id');
            $query->where('CITY_CODE_', $city_id);
            $query->orWhereHas('trc_acc_skeleton', function ($q) use ($city_id) {
                return $q->whereHas('location', function ($q) use ($city_id) {
                    return $q->where('OP_ADDR_DISTRICT', $city_id);
                });
            });

        }

        if ($request->input('state_id')) {
            $state_id = $request->input('state_id');
            $query->whereHas('city', function ($city) use ($state_id) {
                return $city->whereHas('state', function ($state) use ($state_id) {
                    return $state->where('CODE_', $state_id);
                });
            });

            $query->orWhereHas('trc_acc_skeleton', function ($q) use ($state_id) {
                return $q->whereHas('location', function ($q) use ($state_id) {
                    return $q->where('OP_ADDR_STATE', $state_id);
                });
            });
        }

        if ($request->input('reg_no')) {
            $reg_no = $request->input('reg_no');
            $query->whereHas('vehicles', function ($q) use ($reg_no) {
                $q->where('REG_NO', $reg_no);
            });

            $query->orWhereHas('trc_acc_skeleton', function ($q) use ($reg_no) {
                return $q->whereHas('vehicles', function ($q) use ($reg_no) {
                    return $q->where('REG_NO', $reg_no);
                });
            });
        }

        if ($request->input('note')) {
            $note = $request->input('note');
            $query->whereHas('notes', function ($q) use ($note) {
                return $q->where('DESCRIPTION', 'LIKE', '%' . $note . '%');
            });
        }

        if ($request->input('license_no')) {
            $license_no = $request->input('license_no');
            $query->where('ID_NO', $license_no);
            $query->orWhereHas('trc_acc_skeleton', function ($q) use ($license_no) {
                return $q->where('LCN_NO', $license_no);
            });
        }

        $syndicates = $query->paginate(10);
        $cities = collect();//RefDistrict::with('state')->get();
        $states = collect();//RefCountryState::pluck('NAME_', 'CODE_');

        return view('syndicates::syndicates.index', compact(
            'syndicates',
            'cities',
            'states'
        ));
    }

    /**
     * Create syndicate
     *
     * @return View
     */
    public function create(): View
    {
        $cities = collect();//RefDistrict::with('state')->get();
        $tags = Tag::pluck('NAME_', 'ID_');
        $syndicateTypes = SyndicateType::whereIn('ID', [1, 2])->pluck('NAME', 'ID');
        $syndicateCategories = SyndicateCategory::pluck('NAME', 'ID');

        return view('syndicates::syndicates.create', compact(
            'cities',
            'tags',
            'syndicateTypes',
            'syndicateCategories'
        ));
    }

    /**
     * @param Request $request
     * @return RedirectResponse
     */
    public function store(Request $request): RedirectResponse
    {

        $request->validate([
            'name' => $request->input('syndicate_category_id') == 1 ? "unique:syndicates,name_" : "" | 'required',
            'since' => 'required',
            'city_code' => 'required',
            'identity_no' => $request->input('syndicate_category_id') == 2 ? 'required' : '',
        ]);

        $requestTags = $request->input('tags');

        try {

            DB::beginTransaction();
            //tags processing
            $this->setTags($requestTags);

            //syndicate processing
            $syndicate = new Syndicate();
            $this->attributes($request, $syndicate);
            $syndicate->save();

            Log::info('Create new syndicate', $syndicate->toArray());

            $syndicate->tags()->sync($this->tags);
            Log::info('Add tag to syndicate', $this->tags);

            if ($request->hasFile('syndicate-profile-image') && $request->file('syndicate-profile-image')->isValid()) {
                $syndicate->addMediaFromRequest('syndicate-profile-image')
                    ->withCustomProperties([
                        'uploaded_by' => Auth::id()
                    ])->toMediaCollection('syndicate-profile-image');
            }

            DB::commit();

        } catch (Throwable $throwable) {
            DB::rollBack();
            Log::error($throwable->getMessage());

            return redirect()->route('syndicates.create')->with('throwable', __($throwable->getMessage()));
        }

        return redirect()->route('syndicates.index')->with('success', __('Sindiket berjaya dicipta'));
    }

    /**
     * Create syndicate
     *
     * @param $id
     * @return View
     */
    public function show($id): View
    {
        $syndicate = Syndicate::find($id);
        $trc_acc_skeleton = $syndicate->trc_acc_skeleton;
        $syndicate_skeleton = $syndicate->syndicate_skeleton;
        $mergeSkeleton = $trc_acc_skeleton->merge($syndicate_skeleton);
        $networks = $mergeSkeleton->all();

        $cities = RefDistrict::with('state')->get();
        $tags = Tag::pluck('NAME_', 'ID_');
        $syndicateCategories = SyndicateCategory::all();
        $syndicateTypes = SyndicateType::pluck('NAME', 'ID');
        $confirmation = RefStrSts::pluck('NAME_', 'CODE_');

        return view('syndicates::syndicates.show', compact(
            'syndicate',
            'networks',
            'cities',
            'tags',
            'syndicateCategories',
            'syndicateTypes',
            'confirmation'
        ));
    }

    /**
     * Create syndicate
     *
     * @param $id
     * @return View
     */
    public function edit($id): View
    {
        $syndicate = Syndicate::find($id);
        $trc_acc_skeleton = $syndicate->trc_acc_skeleton;
        $syndicate_skeleton = $syndicate->syndicate_skeleton;
        $mergeSkeleton = $trc_acc_skeleton->merge($syndicate_skeleton);
        $networks = $mergeSkeleton->all();

        $cities = RefDistrict::with('state')->get();
        $tags = Tag::pluck('NAME_', 'ID_');
        $syndicateCategories = SyndicateCategory::all();
        $syndicateTypes = SyndicateType::pluck('NAME', 'ID');
        $confirmation = RefStrSts::pluck('NAME_', 'CODE_');


        return view('syndicates::syndicates.edit', compact(
            'syndicate',
            'networks',
            'cities',
            'tags',
            'syndicateCategories',
            'syndicateTypes',
            'confirmation'
        ));
    }

    /**
     * @param Request $request
     * @param $id
     * @return RedirectResponse
     */
    public function update(Request $request, $id): RedirectResponse
    {
        $request->validate([
            'name' => 'required',
            'since' => 'required',
            'city_code' => 'required',
            'id_no' => $request->input('syndicate_type_id') == 2 ? 'required' : '',
        ]);

        $requestTags = $request->input('tags') ? $request->input('tags') : [];

        try {

            DB::beginTransaction();
            //tags processing
            $this->setTags($requestTags);

            //profile processing
            $syndicate = Syndicate::find($id);
            $this->attributes($request, $syndicate);
            $syndicate->REF_STR_STS_CODE_ = $request->input('ref_str_sts_code_');
            $syndicate->STATUS = $request->input('status') == "on" ? 1 : 0;
            $syndicate->save();

            Log::info('Update Profile Syndicate', $syndicate->toArray());

            $syndicate->tags()->sync($this->tags);
            Log::info('Update tag to syndicate', $this->tags);

            if ($request->hasFile('syndicate-profile-image') && $request->file('syndicate-profile-image')->isValid()) {
                $syndicate->media()->delete();
                $syndicate->addMediaFromRequest('syndicate-profile-image')->toMediaCollection('syndicate-profile-image');
            }
            DB::commit();
        } catch (Throwable $throwable) {
            DB::rollBack();
            Log::error($throwable->getMessage());
            return redirect()->route('syndicates.edit', $id)->with('throwable', __($throwable->getMessage()));
        }
        return redirect()->route('syndicates.edit', $id)->with('success', __('Profile sindiket berjaya dikemaskini'));
    }

    /**
     * @param $id
     * @return RedirectResponse
     */
    public function archive($id): RedirectResponse
    {
        try {
            $syndicate = Syndicate::find($id);
            $syndicate->delete();
        } catch (Throwable $throwable) {
            Log::error($throwable->getMessage());
            return redirect()->route('syndicates.show', $id)->with('throwable', __($throwable->getMessage()));
        }

        return redirect()->route('syndicates.index')->with('success', __('Profile sindiket berjaya diarkib'));
    }

    /**
     * @param $id
     * @return RedirectResponse
     */
    public function destroy($id): RedirectResponse
    {
        try {
            $syndicate = Syndicate::find($id);
            $syndicate->forceDelete();
        } catch (Throwable $throwable) {
            Log::error($throwable->getMessage());
            return redirect()->route('syndicates.show', $id)->with('throwable', __($throwable->getMessage()));
        }

        return redirect()->route('syndicates.index')->with('success', __('Profile sindiket berjaya dipadam'));
    }
}
