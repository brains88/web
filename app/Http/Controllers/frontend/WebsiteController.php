<?php
namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request; // Correctly import the Request class
use App\Models\User;
use App\Models\Website;

class WebsiteController extends Controller
{
    public function index()
{
    $websites = Website::with('categories')->paginate(10);
    return response()->json([
        'success' => true,
        'data' => $websites
    ]);
}

    

    //save new website
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'url' => 'required|url',
            'category_ids' => 'required|array'
        ]);

        $website = Website::create($request->only('name', 'url', 'description'));
        $website->categories()->sync($request->category_ids);

        return response()->json($website, 201);
    }

    //delete website
    public function destroy(Website $website)
    {
        $website->delete();
        return response()->json(null, 204);
    }

    //Search function
    public function search(Request $request)
{
    $query = Website::query();

    // Filter by category_id
    if ($request->has('category_id')) {
        $query->whereHas('categories', function ($q) use ($request) {
            $q->where('category_id', $request->category_id);
        });
    }

    // Search by website_name or description
    if ($request->has('website_name')) {
        $query->where(function ($q) use ($request) {
            $q->where('name', 'like', '%' . $request->website_name . '%')
              ->orWhere('description', 'like', '%' . $request->website_name . '%');
        });
    }

    $websites = $query->with('categories')->get();
    return response()->json($websites);
}

}