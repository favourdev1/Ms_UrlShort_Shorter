<?php

namespace App\Http\Controllers;

use App\Models\shortenerModel;
use Auth;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class ShortenerController extends Controller
{


    public function GenerateUrlExtension()
    {
        $url = Str::random(10);
        while (shortenerModel::where('url', $url)->exists()) {
            $url = Str::random(10);

        }
        return $url;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $user = $request->user();
        // fetch all specific user urls
        $urls = shortenerModel::all()->where("user_id", Auth::id());


        return response()->json([
            'data' => $urls,
            'code' => 200
        ]);
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $user = $request->user();
        $validate = Validator::make($request->all(), [
            'title' => 'min:3|string',
            'original_url' => 'min:10'
        ]);

        if ($validate->failed()) {
            return response()->json([
                'message' => "Validation Error",
                'data' => $validate->errors()->all(),
                'status' => false
            ], 403);

        }
        if ($request->url != null && !empty($request->url)) {
            // validate custom link 
            $validate = Validator::make(['url' => $request->url], [
                'url' => 'min:4|alpha_num'
            ]);

            if ($validate->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Validation failed',
                    'data' => $validate->errors()->messages()
                ], 400);
            }

            // check if custom link exist 
            $link = $this->checkCustomLink($request->url);
            if ($link === false) {
                return response()->json([
                    'status' => false,
                    'message' => 'Link already exists and cannot be duplicated',
                ], 422);
            }
        } else {
            // generate custom link
            $link = $this->GenerateUrlExtension();
        }
        $url = shortenerModel::create([
            'title' => $request->input('title'),
            'url' => $link,
            'user_id' => Auth::id(),
            'original_url' => $request->input('original_url')
        ]);


        return response()->json([
            'message' => 'Added successfully ',
            'data' => $url
        ], 200);
    }

    public function checkCustomLink($url)
    {

        // Check if the URL already exists in the database
        $existingUrl = shortenerModel::where('url', $url)->first();

        if ($existingUrl) {
            return false;
        }

        return $url;
    }



    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {


        $validate = Validator(['id' => $id], [
            'id' => 'min:0|numeric'

        ]);

        if ($validate->fails()) {
            return response()->json([
                'status' => false,
                'message' => "Validation failed",
                'data' => $validate->errors()->all()
            ], 403)->header('Content-Type', 'application/json');
        }

        $result = shortenerModel::where('id', $id)->get();
        return response()->json([
            'data' => $result,
            'status' => true
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validate = Validator(['id' => $id], [
            'id' => "min:1|numeric"
        ]);

        if ($validate->fails()) {
            return response()->json([
                'message' => 'Validation Failed',
                'data' => $validate->errors()->all(),
                'status' => false
            ], 403);
        }

        $validate2 = Validator($request->input(), [
            'title' => 'min:3|string',
            'original_url' => 'min:10'
        ]);


        if ($validate2->fails()) {
            return response()->json([
                'message' => 'Validation Failed',
                'data' => $validate2->errors()->all(),
                'status' => false
            ], 403);
        }

        $record = shortenerModel::find($id);
        if (!$record) {
            return response()->json([
                'message' => 'Record Not found',
                'data' => ""
                ,
                'status' => false
            ], 404);
        }

        if ($request->url != null && !empty($request->url)) {

            $validate = Validator::make(['url' => $request->url], [
                'url' => 'min:4|alpha_num'
            ]);

            if ($validate->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Validation failed',
                    'data' => $validate->errors()->messages()
                ], 400);
            }
            $link = $this->checkCustomLink($request->url);
            if ($link === false) {
                return response()->json([
                    'status' => false,
                    'message' => 'Link already exists and cannot be duplicated',
                ], 422);
            }
        } else {
            $link = $this->GenerateUrlExtension();
        }


        $update = $record->update([
            'title' => $request->input('title'),
            'url' => $link,
            'original_url' => $request->input('original_url')
        ]);


        if ($update) {

            return response()->json([
                'message' => 'Updated Successfully',
                'data' => $request->input(),
                'status' => true
            ], 200);
        } else {
            return response()->json([
                'message' => 'Update Failed',
                'data' => null,
                'status' => false
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $validate = Validator(['id' => $id], [
            'id' => "min:1|numeric"
        ]);

        if ($validate->fails()) {
            return response()->json([
                'message' => 'Validation Failed',
                'data' => $validate->errors()->all(),
                'status' => false
            ], 403);
        }

        $result = shortenerModel::find($id);
        if (!$result) {
            return response()->json([
                'message' => 'Record Not found',
                'data' => ""
                ,
                'status' => false
            ], 404);
        }

        $result->delete();

        return response()->json([
            'message' => 'Deleted Successfully',
            'data' => '',
            'status' => true
        ], 200);
    }


    public function GoToLink(string $url)
    {
        $data = shortenerModel::where('url', $url)->first();
        if ($data) {
            $originalUrl = $data->original_url;
            if (!preg_match("~^(?:f|ht)tps?://~i", $originalUrl)) {
                $originalUrl = 'http://' . $originalUrl;
            }

            return new RedirectResponse($originalUrl, 301);
        } else {
            return response()->json([
                'status' => false,
                'message' => 'link nsot found'

            ], 404);
        }
    }
}