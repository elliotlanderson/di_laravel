<?php

namespace App\Api\Ideas;


use App\Api\Skills\Skill;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class IdeaController extends Controller
{

    public function all(Request $request)
    {
        $user = Auth::user();
        $ideas = $user->ideas()->get();

        $this->response->addData('Ideas', $ideas);
        return $this->response->response();
    }

    /**
     * Creates an Idea
     *
     * @TODO Make this controller much slimmer -- divide it up
     * @param Request $request
     * @return string
     */
    public function create(Request $request)
    {
        $this->validate($request,
            [
               'title' => 'required',
                'description' => 'required',
                'skills' => 'required'
            ]);

        $input = $request->all();

        $user = Auth::user();

        $idea = new Idea();
        $idea->title = $input['title'];
        $idea->description = $input['description'];
        $idea->owner_id = $user->id;
        $idea->save();

        $idea->users()->save($user);
        $idea->save();

        $skills = explode(',', $input['skills']);

        foreach ($skills as $skill)
        {
            $skill_string = strtolower(trim($skill));

            $matching_skill = Skill::where('name', '%LIKE%', $skill_string)->first();

            # Create Skill if not existing
            if (is_null($matching_skill))
            {
                $skill = new Skill();
                $skill->name = $skill_string;
                $skill->save();

                # Attach new skill to the user and the idea
                $skill->ideas()->save($idea);
                $skill->save();
            }
            else
            {
                # Skill exists, attach it to the idea
                $matching_skill->ideas()->save($idea);
                $matching_skill->save();
            }
        }

        $idea_with_skills = $idea->with('skills')->get();

        $this->response->addData('Idea', $idea_with_skills);
        return $this->response->response();
    }

    public function detail(Request $request, Idea $idea)
    {
        $this->response->addData('Idea', $idea->with('skills')->get());
        return $this->response->response();
    }
}