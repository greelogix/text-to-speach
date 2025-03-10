<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Project;
use App\Models\Voice;
use Illuminate\Support\Facades\Auth;

class ProjectController extends Controller
{
    public function index($project_id)
    {
        $project = Project::where('id', $project_id)
                          ->where('user_id', Auth::id())
                          ->firstOrFail();
        $voices = $project->voices()->orderBy('id', 'desc')->paginate(12);
    
        return view('voices_list', compact('voices', 'project'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'project_name' => 'required|string|max:255|unique:projects,project_name',
        ]);

        $project = Project::updateOrCreate(
            ['id' => $request->projectid],
            [
                'user_id' => Auth::id(),
                'project_name' => $request->project_name
            ]
        );

        return response()->json([
            'success' => $project->wasRecentlyCreated ? 'Project created successfully!' : 'Project updated successfully!'
        ]);
    }

    public function projects_list()
    {
        $userId = Auth::id();
        $projects = Project::where('user_id', $userId)->withCount('voices')->orderBy('id', 'desc')->paginate(8);

        $recent_voices = Voice::whereHas('project', function ($query) use ($userId) {
                                $query->where('user_id', $userId);
                            })->orderBy('id', 'desc')->take(8)->get();
        return view('projects_list', compact('projects', 'recent_voices'));
    }
    

    public function voices_list(){
        return view('voices_list');
    }

    public function delete_project($project_id)
    {
        $project = Project::find($project_id);
        if ($project) {
            $project->delete();
            return redirect()->back()->with('success', 'Project deleted successfully.');
        }
        return redirect()->back()->with('error', 'Project not found.');
    }

    public function delete_voice($id)
    {
        $Voice = Voice::find($id);
        if ($Voice) {
            $Voice->delete();
            return redirect()->back()->with('success', 'Voice deleted successfully.');
        }
        return redirect()->back()->with('error', 'Voice not found.');
    }
}
