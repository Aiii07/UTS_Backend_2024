<?php

namespace App\Http\Controllers;
use App\Models\Alumni;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class AlumniController extends Controller
{
    public function index()
    {
        $alumni = Alumni::all();

        if (count($alumni)) {
            $data = [
                "message" => "Get All Resource",
                "data" => $alumni
            ];
        } else {
            $data = [
                "message" => "Data is empty"
            ];
        }

        return response()->json($data, 200);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'phone' => 'required',
            'address' => 'required',
            'graduation_year' => 'required|numeric',
            'status' => 'required',
            'company_name' => 'required',
            'position' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation errors',
                'errors' => $validator->errors()
            ], 422);
        }

        $alumni = Alumni::create($request->all());

        $data = [
            "message" => "Resource is added successfully",
            "data" => $alumni
        ];

        return response()->json($data, 201);
    }

    public function show($id)
    {
        $alumni = Alumni::find($id);

        if ($alumni) {
            $data = [
                'message' => 'Get Detail Resource',
                'data' => $alumni
            ];

            return response()->json($data, 200);
        } else {
            $data = [
                'message' => 'Resource not found'
            ];

            return response()->json($data, 404);
        }
    }

    public function update(Request $request, $id)
    {
        $alumni = Alumni::find($id);

        if (!$alumni) {
            $data = [
                "message" => "Resource not found"
            ];
            return response()->json($data, 404);
        }

        $input = [
            'name' => $request->name ?? $alumni->name,
            'phone' => $request->phone ?? $alumni->phone,
            'address' => $request->address ?? $alumni->address,
            'graduation_year' => $request->graduation_year ?? $alumni->graduation_year,
            'status' => $request->status ?? $alumni->status,
            'company_name' => $request->company_name ?? $alumni->company_name,
            'position' => $request->position ?? $alumni->position
        ];

        $alumni->update($input);

        $data = [
            "message" => "Resource is update successfully",
            "data" => $alumni
        ];

        return response()->json($data, 200);
    }

    public function destroy($id)
    {
        $alumni = Alumni::find($id);

        if (!$alumni) {
            $data = [
                "message" => "Resource not found"
            ];
            return response()->json($data, 404);
        }

        $alumni->delete();

        $data = [
            "message" => "Resource is delete successfully"
        ];

        return response()->json($data, 200);
    }

    public function search($name)
    {
        $alumni = Alumni::where('name', 'like', "%{$name}%")->get();

        if (count($alumni) > 0) {
            $data = [
                'message' => 'Get searched resource',
                'data' => $alumni
            ];
            return response()->json($data, 200);
        } else {
            $data = [
                'message' => 'Resource not found'
            ];
            return response()->json($data, 404);
        }
    }

    public function freshGraduate()
    {
        $alumni = Alumni::where('status', 'fresh-graduate')->get();

        $data = [
            'message' => 'Get fresh graduate resource',
            'total' => count($alumni),
            'data' => $alumni
        ];

        return response()->json($data, 200);
    }

    public function employed()
    {
        $alumni = Alumni::where('status', 'employed')->get();

        $data = [
            'message' => 'Get employed resource',
            'total' => count($alumni),
            'data' => $alumni
        ];

        return response()->json($data, 200);
    }

    public function unemployed()
    {
        $alumni = Alumni::where('status', 'unemployed')->get();

        $data = [
            'message' => 'Get unemployed resource',
            'total' => count($alumni),
            'data' => $alumni
        ];

        return response()->json($data, 200);
    }
}