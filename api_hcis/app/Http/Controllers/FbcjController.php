<?php

namespace App\Http\Controllers;

use Validator;

use App\Models\Fbcj;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;

class FbcjController extends Controller
{

    use Rules;

    public function index(Request $request)
    {
        $allowGet = $request->only(['id', 'q', 'limit', 'page', 'order_by']);

        $get = Fbcj::getFbcj($allowGet);
        return response()->json($get);
    }

    public function detail($idFbcj = null, Request $request)
    {
        $allowGet = $request->only(['id', 'q', 'limit', 'page', 'order_by']);

        $get = Fbcj::getFbcjDetail($allowGet, $idFbcj);
        return response()->json($get);
    }


    public function subDetail($idFbcj, Request $request)
    {
        $allowGet = $request->only(['id', 'q', 'limit', 'page', 'order_by']);

        $get = Fbcj::getFbcjSubDetail($allowGet, $idFbcj);
        return response()->json($get);
    }

    public function store(Request $request)
    {
        try {
            // set tules
            $this->rules($request);

            $allowPost = [
                'nomor'                => Fbcj::getAutoNumber(),
                'id_cost_center'       => $request->post('id_cost_center'),
                'id_unit_kerja_divisi' => $request->post('id_unit_kerja_divisi'),
                'kas_jurnal'           => $request->post('kas_jurnal'),
                'tanggal'              => $request->post('tanggal'),
            ];
            // insert
            $withId = Fbcj::insertGetId($allowPost);

            // insert detail
            $rincian = $request->post('rincian') ?? null;

            // dd($rincian);
            if ($rincian != null) {
                $rincian = json_decode($rincian, true);
                $tampung = [];
                foreach ($rincian['id_bussiness_trans'] as $key => $list) :
                    $tampung[] = [
                        'id_fbcj'                   => $withId,
                        'doc_no'                    => Fbcj::getAutoNumberDetailFbcj(),
                        'id_bussiness_transaction'  => $list,
                        'id_wbs_element'            => $rincian['id_wbs_element'][$key],
                        'amount'                    => str_replace('.', '', $rincian['amount'][$key]),
                        'id_karyawan'               => $rincian['id_karyawan'][$key],

                    ];
                endforeach;

                DB::table('rekap__fbcj_detail')->insert($tampung);
            }
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

    public function update($id, Request $request)
    {
        try {
            // set tules
            // $this->rules($request);

            $old = Jabatan::findOrFail($id);
            $nama = !empty($request->post('nama_jabatan')) ? $request->post('nama_jabatan') : $old->nama_jabatan;

            $old->update([
                'nama_jabatan'    => strtoupper($nama)
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
        } catch (\Exception | \Throwable $Error) {
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
        'id_unit_kerja_divisi.required' => 'divisi harus diisi',
        'tanggal.required'              => 'tanggal harus diisi',
        'kas_jurnal.required'           => 'kas jurnal harus diisi',
        'id_cost_center.required'       => 'cost center harus diisi',
    ];

    public function rules(Request $request)
    {
        $rules = Validator::make($request->post(), [
            'id_unit_kerja_divisi'  => 'required|max:100',
            'tanggal'               => 'required',
            'kas_jurnal'            => 'required|max:10',
            'id_cost_center'        => 'required',

        ], $this->message);
        // cek rules
        if ($rules->fails())
            throw new \Exception($rules->errors()->first());
    }
}
