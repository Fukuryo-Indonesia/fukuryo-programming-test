<?php

namespace App\Http\Controllers;

use App\Models\Author;
use Cviebrock\EloquentSluggable\Services\SlugService;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class AuthorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('author.index', [
            'title' =>  'Master Author',
            'pageTitle' =>  'Master Author',
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
            'dob'  =>  'required',
        ], [
            'name.required' =>  'Author Name is required',
            'dob.required' =>  'Author DOB is required'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'data'  =>  [
                    'status'    =>  false,
                    'message'   =>  $validator->errors(),
                ]
            ]);
        }

        $slug = SlugService::createSlug(Author::class, 'slug', $request->name, ['unique' => false]);

        $validator = Validator::make(['slug'    =>  $slug], [
            'slug'  =>  'unique:authors,slug'
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
            'dob'  =>  Carbon::parse($request->dob),
            'address'  =>  Str::title($request->address),
            'description'   =>  Str::title($request->description)
        ];

        if (Author::create($data)) {
            return response()->json([
                'data'  =>  [
                    'status'    =>  true,
                    'message'   =>  'Success save author'
                ]
            ]);
        }

        return response()->json([
            'data'  =>  [
                'status'    =>  false,
                'message'   =>  'Failed save author'
            ]
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Author $author)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Author $author)
    {
        return response()->json($author);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Author $author)
    {
        $validator = Validator::make($request->all(), [
            'name'  =>  'required',
            'dob'  =>  'required',
        ], [
            'name.required' =>  'Author Name is required',
            'dob.required' =>  'Author DOB is required'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'data'  =>  [
                    'status'    =>  false,
                    'message'   =>  $validator->errors(),
                ]
            ]);
        }

        $slug = SlugService::createSlug(Author::class, 'slug', $request->name, ['unique' => false]);

        if ($author->slug != $slug) {
            $validator = Validator::make(['slug'    =>  $slug], [
                'slug'  =>  'unique:authors,slug'
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
            'dob'  =>  Carbon::parse($request->dob),
            'address'  =>  Str::title($request->address),
            'description'   =>  Str::title($request->description)
        ];

        if (Author::find($author->id)->update($data)) {
            return response()->json([
                'data'  =>  [
                    'status'    =>  true,
                    'message'   =>  'Success update author'
                ]
            ]);
        }

        return response()->json([
            'data'  =>  [
                'status'    =>  false,
                'message'   =>  'Failed update author'
            ]
        ]);
    }

    public function activated(Author $author)
    {
        $data = [
            'is_active' =>  $author->is_active ? false : true,
        ];

        if (Author::find($author->id)->update($data)) {
            $message = $author->is_active ? 'Success disabled author' : 'Success enable Author';
            return response()->json([
                'data'  =>  [
                    'status'    =>  true,
                    'message'   =>  $message
                ]
            ]);
        }

        $message = $author->is_active ? 'Failed disabled author' : 'Failed enable Author';

        return response()->json([
            'data'  =>  [
                'status'    =>  false,
                'message'   =>  $message
            ]
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Author $author)
    {
        if (Author::find($author->id)->delete()) {
            return response()->json([
                'data'  =>  [
                    'status'    =>  true,
                    'message'   =>  'Success delete author'
                ]
            ]);
        }

        return response()->json([
            'data'  =>  [
                'status'    =>  false,
                'message'   =>  'Failed delete author'
            ]
        ]);
    }

    function getAllData(Request $request)
    {
        $totalAuthor = Author::orderBy('name')
            ->count();

        $filteredAuthor = Author::search(['search' => $request->search['value']])
            ->orderBy('name')
            ->count();

        $author = Author::search(['search' => $request->search['value']])
            ->skip($request->start)
            ->limit($request->length)
            ->orderBy('name')
            ->get();

        $authorChunk = array_chunk($author->toArray(), 10);

        $results = array();

        $no = $request->start + 1;

        if ($authorChunk) {
            foreach ($authorChunk as $key => $chunk) {
                foreach ($chunk as $key => $value) {
                    $btnAction = '<div class="d-flex gap-3">
                                    <button class="btn btn-warning" title="Edit Author" onclick="fnAuthor.onEdit(\'' . $value['slug'] . '\')">
                                        <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-edit"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M7 7h-1a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-1" /><path d="M20.385 6.585a2.1 2.1 0 0 0 -2.97 -2.97l-8.415 8.385v3h3l8.385 -8.415z" /><path d="M16 5l3 3" /></svg>
                                    </button>
                                    <button class="btn btn-danger" title="Delete Author" onclick="fnAuthor.onDelete(\'' . $value['slug'] . '\',\'' . csrf_token() . '\')">
                                        <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-eraser"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M19 20h-10.5l-4.21 -4.3a1 1 0 0 1 0 -1.41l10 -10a1 1 0 0 1 1.41 0l5 5a1 1 0 0 1 0 1.41l-9.2 9.3" /><path d="M18 13.3l-6.3 -6.3" /></svg>
                                    </button>
                                </div>';

                    $results[] = [
                        $no,
                        $value['name'],
                        Carbon::parse($value['dob'])->isoFormat("DD MMMM YYYY"),
                        Carbon::parse($value['dob'])->age . ' Years Old',
                        Str::title($value['address']),
                        $btnAction
                    ];

                    $no++;
                }
            }
        }

        return response()->json([
            'draw'  =>  $request->draw,
            'data'  =>  $results,
            'recordsTotal'  =>  $totalAuthor,
            'recordsFiltered'   =>  $filteredAuthor
        ]);
    }
}
