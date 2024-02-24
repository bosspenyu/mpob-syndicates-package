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
        $syndicate->NAME_ = $request->input('name');
        $syndicate->SINCE = $request->input('since');
        $syndicate->ID_NO = $request->input('identity_no');
        $syndicate->SYNDICATE_CATEGORY_ID = $request->input('syndicate_category_id');
        $syndicate->SYNDICATE_TYPE_ID = $request->input('syndicate_category_id') == 1 ? 4:$request->input('syndicate_type_id');
        $syndicate->IS_RESTRICTED = $request->input('is_restricted') == "on" ? 1 : 0;
        $syndicate->CITY_CODE_ = $request->input('city_code');
        $syndicate->CREATED_BY = Auth::id();
        $syndicate->REGION_CODE = Auth::user()->region;
        $syndicate->LONGITUDE = $request->input('longitude');
        $syndicate->LATITUDE = $request->input('latitude');
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
                        $newTag->NAME_ = "#".$tag;
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
