<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\{User,Website};
class WebsiteController extends Controller
{
    public function index()
    {
        $websites = Website::with('categories')->get();
        return response()->json($websites);
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

        if ($request->has('category_id')) {
            $query->whereHas('categories', function ($q) use ($request) {
                $q->where('category_id', $request->category_id);
            });
        }

        if ($request->has('search_term')) {
            $query->where('name', 'like', '%' . $request->search_term . '%')
                  ->orWhere('description', 'like', '%' . $request->search_term . '%');
        }

        $websites = $query->with('categories')->get();
        return response()->json($websites);
    }
}
