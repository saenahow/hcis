<?php

namespace App\Http\Controllers\Lainnya;

use Validator;

use App\Models\PerdinJenisPekerjaan;
use Illuminate\Http\Request;
use Laravel\Lumen\Routing\Controller;
use Illuminate\Database\QueryException;

class JenisPekerjaanController extends Controller
{

    use Rules;

    public function index(Request $request)
    {
        $allowGet = $request->only(['id', 'limit', 'page']);

        $get = PerdinJenisPekerjaan::getJenisPekerjaan($allowGet);
        return response()->json($get);
    }

    public function store(Request $request)
    {
        try {
            // set tules
            $this->rules($request);

            $allowPost = [
                'nama' => strtoupper($request->post('nama')),
            ];
            // insert
            PerdinJenisPekerjaan::create($allowPost);

            $response = [
                'status_code' => 201,
                'message'     => 'data telah ditambahkan',
            ];
        } catch (\Exception | \Throwable $error) {
            $response = [
                'status_code' => 400,
                'message'     => $error->getMessage(),
            ];
        } catch (QueryException $Error) {
            $response = [
                'status_code' => 400,
                'message'     => $Error->getMessage(),
            ];
        } finally {
            return response()->json($response);
        }
    }
    public function delete($id)
    {
        try {

            PerdinJenisPekerjaan::findOrFail($id)->delete();
            $response = [
                'status_code' => 200,
                'message'     => 'data telah dihapus',
            ];
        } catch (\Illuminate\Database\QueryException $error) {
            $response = [
                'status_code' => 400,
                'message'     => 'Sedang terjadi kesalahan, silahkan coba beberapa saat lagi',
            ];
        } catch (\Exception $error) {
            $response = [
                'status_code' => 400,
                'message'     => $error->getMessage(),
            ];
        } finally {
            return response()->json($response);
        }
    }

    public function update($id, Request $request)
    {
        try {

            // set tules
            // $this->rules($request);

            $old = PerdinJenisPekerjaan::findOrFail($id);
            $nama = !empty($request->post('nama')) ? $request->post('nama') : $old->nama;

            $old->update([
                'nama'    => $nama,
            ]);
            $response = [
                'status_code' => 200,
                'message'     => 'Data telah diperbarui',
                'response'    => $old,
            ];
        } catch (QueryException $Error) {
            $response = [
                'status_code' => 400,
                'message'     => $Error->getMessage(),

            ];
        } catch (\Exception $Error) {
            $response = [
                'status_code' => 400,
                'message'     => $Error->getMessage(),
            ];
        } finally {
            return response()->json($response);
        }
    }
}


trait Rules
{
    private $message = [
        'required'      => ':attribute harus diisi',
        'nama.max'      => 'kolom nama maksimal 100 karakter',

    ];

    public function rules(Request $request)
    {
        $rules = Validator::make($request->post(), [
            'nama'  => 'required|max:100'
        ], $this->message);
        // cek rules
        if ($rules->fails())
            throw new \Exception($rules->errors()->first());
    }
}
