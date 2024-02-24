<?php

namespace Mpob\Syndicates\Controllers;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

class OrgChartController extends Controller
{
    public function index(Request $request)
    {
        $model_id = $request->input('model_id');
        $model_type = $request->input('model_type');
        return view('syndicates::networks.orgchart', compact('model_id', 'model_type'));
    }

    private function getNode($model, $id){

        $model_prefix = "App\Models";
        $modelType = $model_prefix . '\\' . $model;
        $model = $modelType::find($id);
        $trc_acc_skeleton = $model->trc_acc_skeleton == null ? collect():$model->trc_acc_skeleton;
        $syndicate_skeleton = $model->syndicate_skeleton == null ? collect():$model->syndicate_skeleton;
        $mergeSkeleton = $trc_acc_skeleton->merge($syndicate_skeleton);
        return [$model,collect($mergeSkeleton->all())];
    }

    private function point($i){
        return floor(($i + 10)/10) * 5;
    }

    public function getOrgChartData(Request $request)
    {
        $model = $request->input('model_type');
        $id = $request->input('model_id');

        list($parent, $children) = $this->getNode($model, $id);
        $orgChartData = collect();
        $label = collect();
        $lx = $this->point(100);
        $ly = $this->point(50);

        foreach ($children as $child){
            $orgChartData->push([
                "key" => $child->id_,
                "text" => $child->name_,
            ]);
            $label->push([
                "from"=>$parent->id_,
                "to"=>$child->id_,
                "text"=>$child->pivot->relationship->name_
            ]);

            list($otherParent, $otherChildren) = $this->getNode(class_basename($child), $child->id_);
            if($otherChildren->count()){
                $rx = $this->point(150);
                $ry = $this->point(100);
                foreach ($otherChildren as $otherC) {
                    $orgChartData->push([
                        "key" => $otherC->id_,
                        "text" => $otherC->name_,
                    ]);
                    $label->push([
                        "from"=>$otherParent->id_,
                        "to"=>$otherC->id_,
                        "text"=>$otherC->pivot->relationship->name_
                    ]);
                    $rx+=$this->point($rx*5);
                    $ry+=$this->point($ry*5);
                }
            }

            $lx+=$this->point($lx*15);
            $ly+=$this->point($ly*15);
        }

        return response()->json(["text"=>$orgChartData,"label"=>$label]);
    }
}
