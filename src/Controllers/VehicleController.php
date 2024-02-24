<?php

namespace Mpob\Syndicates\Controllers;

use App\Http\Controllers\Controller;

use Mpob\Syndicates\Models\Syndicate;
use Mpob\Syndicates\Models\Vehicle;
use Mpob\Syndicates\Models\VehicleMake;
use Mpob\Syndicates\Models\VehicleType;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Throwable;

class VehicleController extends Controller
{

    /**
     * @param $syndicateId
     * @return View
     */
    public function create($syndicateId): View
    {
        $vehicleTypes = VehicleType::pluck('NAME_','CODE_');
        $vehicleMakes = VehicleMake::pluck('NAME_','CODE_');

        return view('syndicates::vehicles.create',compact(
            'syndicateId',
            'vehicleMakes',
            'vehicleTypes'
        ));
    }

    /**
     * @param Request $request
     * @param $syndicateId
     * @return RedirectResponse
     */
    public function store(Request $request, $syndicateId): RedirectResponse
    {
        $request->validate([
            "registration_no"=>"required",
            "type"=>"required",
            "maker"=>"required",
            "colour"=>"required",
        ]);

        try {
            $vehicle = new Vehicle();
            $this->columns($vehicle, $request, $syndicateId);

            Log::info('Create new vehicle', $vehicle->toArray());
        }catch (Throwable $throwable){
            Log::error($throwable->getMessage());
            return redirect()->route('syndicates.create')->with('throwable', __($throwable->getMessage()));
        }

        return redirect()->route('syndicates.show',$syndicateId)->with('success', __('Kenderaan berjaya direkod'));
    }

    /**
     * @param $syndicateId
     * @param $vehicleId
     * @return View
     */
    public function show($syndicateId, $vehicleId): View
    {
        $vehicleTypes = VehicleType::pluck('name_','code_');
        $vehicleMakes = VehicleMake::pluck('name_','code_');
        $vehicle = Vehicle::find($vehicleId);

        return view('syndicates::vehicles.show', compact(
            'vehicle',
            'syndicateId',
            'vehicleTypes',
            'vehicleMakes'
        ));
    }

    /**
     * @param Request $request
     * @param $syndicateId
     * @param $vehicleId
     * @return RedirectResponse
     */
    public function update(Request $request, $syndicateId, $vehicleId): RedirectResponse
    {
        $request->validate([
            "registration_no"=>"required",
            "type"=>"required",
            "maker"=>"required",
            "colour"=>"required",
        ]);

        try {
            $vehicle = Vehicle::find($vehicleId);
            $this->columns($vehicle, $request, $syndicateId);

            Log::info('Update vehicle', $vehicle->toArray());
        }catch (Throwable $throwable){
            Log::error($throwable->getMessage());
            return redirect()->route('syndicates.show',$syndicateId)->with('throwable', __($throwable->getMessage()));
        }

        return redirect()->route('syndicates.show',$syndicateId)->with('success', __('Kenderaan berjaya dikemaskini'));
    }

    /**
     * @param Request $request
     * @param $syndicateId
     * @return RedirectResponse
     */
    public function destroy(Request $request, $syndicateId): RedirectResponse
    {
        try {

            $vehicle = Vehicle::find($request->input('vehicle_id'));
            $vehicle->delete();

            Log::info('Destroy vehicle', $vehicle->toArray());

        }catch (Throwable $throwable){

            Log::error($throwable->getMessage());
            return redirect()->route('syndicates.show',$syndicateId)->with('throwable', __($throwable->getMessage()));

        }

        return redirect()->route('syndicates.show',$syndicateId)->with('success', __('Kenderaan berjaya dipadamkan'));
    }

    /**
     * @param $model
     * @param $request
     * @param $syndicateId
     * @return void
     */
    protected function columns($model, $request, $syndicateId){
        $model->REG_NO = $request->input('registration_no');
        $model->VEHICLE_CODE = $request->input('type');
        $model->MAKE_ = $request->input('maker');
        $model->COLOUR = $request->input('colour');
        $model->SYNDICATE_ID_ = $syndicateId;
        $model->save();
    }
}
