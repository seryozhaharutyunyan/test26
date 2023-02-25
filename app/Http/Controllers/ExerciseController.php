<?php

namespace App\Http\Controllers;

use App\Models\Exercise;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ExerciseController extends Controller
{
    /**
     * @param $data
     * @return JsonResponse
     */
    public function exercise2get($data)
    {
        $start = microtime(true);
        $json = Exercise::create([
            'data' => $data
        ]);
        $time = microtime(true) - $start;
        $data = [
            'token' => auth()->user()->token ?? '',
            'id' => $json->id,
            'time' => $time,
        ];
        return response()->json($data);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function exercise2post(Request $request)
    {
        $data = $request->all();
        $start = microtime(true);
        $json = Exercise::create([
            'data' => $data['data']
        ]);
        $time = microtime(true) - $start;
        $data = [
            'token' => auth()->user()->token ?? '',
            'id' => $json->id,
            'time' => $time,
        ];
        return response()->json($data);
    }

    /**
     * @param $id
     * @param $data
     * @return JsonResponse
     */
    public function exercise3get($id, $data)
    {
        $code = explode(' ', $data);

        $this->evalData($id, $code);
        $data = [
            'token' => auth()->user()->token ?? '',
        ];

        return response()->json($data);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function exercise3post(Request $request)
    {
        $data = $request->all();
        $code = explode(' ', $data['data']);
        $this->evalData($data['id'], $code);
        $data = [
            'token' => auth()->user()->token ?? '',
        ];

        return response()->json($data);
    }

    /**
     * @return JsonResponse
     */
    public function exercise()
    {
        $data = Exercise::all();
        return response()->json($data);
    }

    public function destroy($id)
    {
        $exercise=Exercise::find($id);
        $exercise->delete();
    }

    /**
     * @param $id
     * @param $code
     */
    protected function evalData($id, $code)
    {
        $exercise = Exercise::find((int)$id);
        $data = json_decode($exercise->data, false);

        foreach ($code as $value) {
            if (str_contains($value, '$data->')) {
                eval($value . ';');
            }

        }

        $exercise->update([
            'data' => json_encode($data)
        ]);
    }
}
