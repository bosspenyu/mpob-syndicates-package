<?php

namespace Mpob\Syndicates\Traits;

use Mpob\Syndicates\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

trait SyndicateTrait
{
    public array $tags = [];

    /**
     * @param Request $request
     * @param $syndicate
     * @return void
     */
    protected function attributes(Request $request, $syndicate): void
    {
        $syndicate->name_ = $request->input('name');
        $syndicate->since = $request->input('since');
        $syndicate->id_no = $request->input('identity_no');
        $syndicate->syndicate_category_id = $request->input('syndicate_category_id');
        $syndicate->syndicate_type_id = $request->input('syndicate_category_id') == 1 ? 4:$request->input('syndicate_type_id');
        $syndicate->is_restricted = $request->input('is_restricted') == "on" ? 1 : 0;
        $syndicate->city_code_ = $request->input('city_code');
        $syndicate->created_by = Auth::id();
        $syndicate->region_code = Auth::user()->region;
        $syndicate->longitude = $request->input('longitude');
        $syndicate->latitude = $request->input('latitude');
    }

    protected function setTags($requestTags)
    {
        if (!is_null($requestTags)) {
            foreach ($requestTags as $tag) {
                if (is_numeric($tag)) {
                    $this->tags[] = $tag;
                } else { //create new tag if not exists
                    try{
                        $newTag = new Tag();
                        $newTag->name_ = "#".$tag;
                        $newTag->save();

                        $this->tags[] = $newTag->id_;

                        Log::info('Create New Tag', $newTag->toArray());
                    }catch (\Throwable $throwable){

                        Log::info($throwable->getMessage());
                    }

                }
            }
        }
    }
}
