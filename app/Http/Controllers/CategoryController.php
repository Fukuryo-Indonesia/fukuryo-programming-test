<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Cviebrock\EloquentSluggable\Services\SlugService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('category.index', [
            'title' =>  'Master Category',
            'pageTitle' =>  'Master Category',
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name'  =>  'required',
        ], [
            'name.required' =>  'Category Name is required'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'data'  =>  [
                    'status'    =>  false,
                    'message'   =>  $validator->errors(),
                ]
            ]);
        }

        $slug = SlugService::createSlug(Category::class, 'slug', $request->name, ['unique' => false]);

        $validator = Validator::make(['slug'    =>  $slug], [
            'slug'  =>  'unique:categories,slug'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'data'  =>  [
                    'status'    =>  false,
                    'message'   =>  $validator->errors(),
                ]
            ]);
        }

        $data = [
            'name'  =>  Str::upper($request->name),
            'slug'  =>  $slug,
            'description'   =>  Str::title($request->description)
        ];

        if (Category::create($data)) {
            return response()->json([
                'data'  =>  [
                    'status'    =>  true,
                    'message'   =>  'Success save category'
                ]
            ]);
        }

        return response()->json([
            'data'  =>  [
                'status'    =>  false,
                'message'   =>  'Failed save category'
            ]
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Category $category)
    {
        return response()->json($category);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Category $category)
    {
        $validator = Validator::make($request->all(), [
            'name'  =>  'required',
        ], [
            'name.required' =>  'Category Name is required'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'data'  =>  [
                    'status'    =>  false,
                    'message'   =>  $validator->errors(),
                ]
            ]);
        }

        $slug = SlugService::createSlug(Category::class, 'slug', $request->name, ['unique' => false]);

        if ($category->slug != $slug) {
            $validator = Validator::make(['slug'    =>  $slug], [
                'slug'  =>  'unique:categories,slug'
            ]);
        }

        if ($validator->fails()) {
            return response()->json([
                'data'  =>  [
                    'status'    =>  false,
                    'message'   =>  $validator->errors(),
                ]
            ]);
        }

        $data = [
            'name'  =>  Str::upper($request->name),
            'slug'  =>  $slug,
            'description'   =>  Str::title($request->description)
        ];

        if (Category::find($category->id)->update($data)) {
            return response()->json([
                'data'  =>  [
                    'status'    =>  true,
                    'message'   =>  'Success update category'
                ]
            ]);
        }

        return response()->json([
            'data'  =>  [
                'status'    =>  false,
                'message'   =>  'Failed update category'
            ]
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function activated(Category $category)
    {
        $data = [
            'is_active' =>  $category->is_active ? false : true,
        ];

        if (Category::find($category->id)->update($data)) {
            $message = $category->is_active ? 'Success disabled category' : 'Success enable Category';
            return response()->json([
                'data'  =>  [
                    'status'    =>  true,
                    'message'   =>  $message
                ]
            ]);
        }

        $message = $category->is_active ? 'Failed disabled category' : 'Failed enable Category';

        return response()->json([
            'data'  =>  [
                'status'    =>  false,
                'message'   =>  $message
            ]
        ]);
    }

    public function destroy(Category $category)
    {
        if (Category::find($category->id)->delete()) {
            return response()->json([
                'data'  =>  [
                    'status'    =>  true,
                    'message'   =>  'Success delete category'
                ]
            ]);
        }

        return response()->json([
            'data'  =>  [
                'status'    =>  false,
                'message'   =>  'Failed delete category'
            ]
        ]);
    }

    function getAllData(Request $request)
    {
        $totalCategory = Category::orderBy('name')
            ->count();

        $filteredCategory = Category::search(['search' => $request->search['value']])
            ->orderBy('name')
            ->count();

        $category = Category::search(['search' => $request->search['value']])
            ->skip($request->start)
            ->limit($request->length)
            ->orderBy('name')
            ->get();

        $categoryChunk = array_chunk($category->toArray(), 10);

        $results = array();

        $no = $request->start + 1;

        if ($categoryChunk) {
            foreach ($categoryChunk as $key => $chunk) {
                foreach ($chunk as $key => $value) {
                    $btnStatus = '<button class="btn btn-info" title="Disabled Category" onclick="fnCategory.onDisable(\'' . $value['slug'] . '\',\'' . csrf_token() . '\')">
                                    <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-bookmarks-off"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M11 7h2a2 2 0 0 1 2 2v2m0 4v6l-5 -3l-5 3v-12a2 2 0 0 1 2 -2" /><path d="M9.265 4a2 2 0 0 1 1.735 -1h6a2 2 0 0 1 2 2v10" /><path d="M3 3l18 18" /></svg>
                                </button>';

                    if ($value['is_active'] == false) {
                        $btnStatus = '<button class="btn btn-success" title="Enabled Category" onclick="fnCategory.onEnable(\'' . $value['slug'] . '\',\'' . csrf_token() . '\')">
                                                    <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-check"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M5 12l5 5l10 -10" /></svg>
                                                </button>';
                    }
                    $btnAction = '<div class="d-flex gap-3">
                                    ' . $btnStatus . '
                                    <button class="btn btn-warning" title="Edit Category" onclick="fnCategory.onEdit(\'' . $value['slug'] . '\')">
                                        <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-edit"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M7 7h-1a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-1" /><path d="M20.385 6.585a2.1 2.1 0 0 0 -2.97 -2.97l-8.415 8.385v3h3l8.385 -8.415z" /><path d="M16 5l3 3" /></svg>
                                    </button>
                                    <button class="btn btn-danger" title="Delete Category" onclick="fnCategory.onDelete(\'' . $value['slug'] . '\',\'' . csrf_token() . '\')">
                                        <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-eraser"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M19 20h-10.5l-4.21 -4.3a1 1 0 0 1 0 -1.41l10 -10a1 1 0 0 1 1.41 0l5 5a1 1 0 0 1 0 1.41l-9.2 9.3" /><path d="M18 13.3l-6.3 -6.3" /></svg>
                                    </button>
                                </div>';

                    $results[] = [
                        $no,
                        $value['name'],
                        $value['description'],
                        $value['is_active'] ? '<span class="badge bg-green text-green-fg">Enable</span>' : '<span class="badge bg-danger text-danger-fg">Disable</span>',
                        $btnAction
                    ];

                    $no++;
                }
            }
        }

        return response()->json([
            'draw'  =>  $request->draw,
            'data'  =>  $results,
            'recordsTotal'  =>  $totalCategory,
            'recordsFiltered'   =>  $filteredCategory
        ]);
    }
}
