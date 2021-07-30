<?php
$library = new App\Libraries\Library();
?>
<?= $this->extend('Layout/Page') ?>
<?= $this->section('css_files') ?>
<link rel="stylesheet" href="<?= base_url('template/vendors/select2/select2.min.css') ?>">
<link rel="stylesheet" href="<?= base_url('template/vendors/LightPick/lightpick.css') ?>">
<style>
    .nav-link {
        padding: 20px;
        color: #6c757d;
    }

    .nav-link.active {
        background: transparent !important;
        color: black;
        font-weight: 700;

    }

    .nav-tabs .nav-link.active:after {
        width: 50%;
        left: 52%;
        transform: translate(-50%, -50%);
        height: 3px;
    }

    .list-none {
        list-style: none;
    }

    .list-style li {
        list-style: none;
    }

    tfoot tr,
    tfoot tr td {
        border: none;
    }
</style>
<?= $this->endSection() ?>
<?= $this->section('content') ?>
<div id='id-fbcj' data-id="<?= $id_fbcj ?>"></div>
<div class="row">
    <div class="col">
        <div class="card">
            <?= $this->include('Rekap/MenuFbcj') ?>

            <div class="card-body padding-top-3 padding-bottom-9 padding-x-6">

                <br />
                <div class="row margin-top-5">
                    <div class="col-lg-6">

                        <div class="row margin-top-2">
                            <div class="col-lg-2 d-flex justify-content-between align-items-center">
                                <div class='fweight-700'>Nomor</div>
                                <div class='d-lg-block d-xl-block d-md-block d-sm-none d-xs-none d-none'>:</div>
                            </div>
                            <div class="col-lg-4">
                                <?= $fbcj->nomor ?>
                            </div>
                        </div>

                    </div>
                    <div class="col-lg-6"></div>

                    <div class="col-lg-6">

                        <div class="row margin-top-2">
                            <div class="col-lg-2 d-flex justify-content-between align-items-center">
                                <div class='fweight-700'>Tanggal</div>
                                <div class='d-lg-block d-xl-block d-md-block d-sm-none d-xs-none d-none'>:</div>
                            </div>
                            <div class="col-lg-4">
                                <?= $fbcj->tanggal ?>
                            </div>
                        </div>

                        <div class="row  margin-top-2">
                            <div class="col-lg-2 d-flex justify-content-between  align-items-center">
                                <div class='fweight-700'>Divisi</div>
                                <div class='d-lg-block d-xl-block d-md-block d-sm-none d-xs-none d-none'>:</div>
                            </div>
                            <div class="col-lg-7">
                                <?= $fbcj->nama_divisi ?> / <?= $fbcj->kode_divisi ?>
                            </div>
                        </div>

                    </div>
                    <div class="col-lg-6">
                        <div class="row  margin-top-2">
                            <div class="col-lg-2 d-flex justify-content-between align-items-center">
                                <div class='fweight-700'>Kas Jurnal</div>
                                <div class='d-lg-block d-xl-block d-md-block d-sm-none d-xs-none d-none'>:</div>
                            </div>
                            <div class="col-lg-4">
                                <?= $fbcj->kas_jurnal ?>
                            </div>
                        </div>

                        <div class="row margin-top-2">
                            <div class="col-lg-2 d-flex justify-content-between  align-items-center">
                                <div class='fweight-700'>Cost Center</div>
                                <div class='d-lg-block d-xl-block d-md-block d-sm-none d-xs-none d-none'>:</div>
                            </div>
                            <div class="col-lg-7">
                                <?= $fbcj->kode_cost_center ?>
                            </div>
                        </div>
                    </div>
                </div>


                <!-- PRINT -->
                <br /><br />
                <div class='margin-top-7'>
                    <table class='table table-bordered'>
                        <tr>
                            <th>No</th>
                            <th>Doc No</th>
                            <th>Bussiness Transaction</th>
                            <th>Wbs Element</th>
                            <th style="text-align:right">Amount</th>
                            <th>Recepient</th>
                        </tr>

                        <?php
                        $no = 1;
                        $totalAmount = 0;
                        foreach ($detail as $list) :
                            $totalAmount += $list->amount;
                        ?>
                            <tr>
                                <td><?= $no++ ?></td>
                                <td><?= $list->doc_no ?></td>
                                <td><?= $list->kode_bussiness_trans . ' ' . $list->nama_bussiness_trans ?></td>
                                <td><?= $list->kode_wbs_element ?></td>
                                <td style="text-align:right"><?= number_format($list->amount, 0, ',', '.') ?></td>
                                <td><?= strtoupper($list->nama_karyawan) ?></td>

                            </tr>
                        <?php endforeach; ?>
                        <tfoot>
                            <tr style='border:none'>
                                <td colspan=4 style="text-align:right" class="fweight-700">TOTAL AMOUNT</td>
                                <td class='d-flex justify-content-between padding-3'>
                                    <div class="fweight-700">Rp.</div>
                                    <div class="fweight-700"><?= number_format($totalAmount, 0, ',', '.') ?></div>
                                </td>
                                <td></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>


                <!-- PRINT -->

                <br /><Br /><br />

                <!-- SUB DETAIL -->
                <?php if ($empty_sub_detail == true) : ?>
                    <div class="row">

                        <form id='form-fbcj-subdetail'>
                            <!-- DOKUMEN -->
                            <div class='box-shadow padding-x-7 padding-top-5 padding-bottom-3 dokumen margin-y-5 border-radius'>
                                <div class="row margin-bottom-5">
                                    <div class="col-lg-4 col-xl-4 col-12">
                                        <div class="form-group">
                                            <label class="fweight-700 margin-bottom-2">Doc No</label>
                                            <select name="id_fbcj_detail[]" data-name="id_fbcj_detail" class='w-100'></select>
                                        </div>
                                    </div>
                                </div>
                                <table class='table table-borderless'>
                                    <thead>
                                        <tr>
                                            <th class='text-center'>No</th>
                                            <th class='padding-left-5'>Keterangan</th>
                                            <th class='padding-left-4'>Tanggal BON</th>
                                            <th style="text-align:right" class='padding-right-5'>Amount Detail</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody class='tbody-isi'>
                                        <tr class='box-shadow'>
                                            <td class='padding-3 text-center'>1</td>
                                            <td class='padding-3'><input type='text' name='subdetail[keterangan][]' class='form-control' placeholder='Keterangan'></td>
                                            <td class='padding-3'>
                                                <input type='text' name='subdetail[tanggal_bon][]' class='form-control tglbon' placeholder='Tanggal BON'>
                                            </td>
                                            <td class='padding-3'><input type='text' dir="rtl" name='subdetail[amount_detail][]' class='form-control currency-number currency-number amount_detail' placeholder='Amount Detail'></td>

                                            <td class='padding-3 text-center'>
                                                <button class='no-border no-background text-muted padding-x-1 hapus-baris d-flex align-items-center justify-content-center padding-top-1 w-100'>
                                                    <span class='material-icons-outlined'>
                                                        highlight_off
                                                    </span>
                                                </button>
                                            </td>
                                        </tr>
                                    </tbody>
                                    <tfoot>
                                        <tr style="border:none">
                                            <td colspan=5 style="border:none">
                                                <div class='margin-top-2 w-100'>
                                                    <button class='btn btn-primary padding-y-2 fweight-700 d-flex mx-auto justify-content-center tambah-baris'>
                                                        <span class="material-icons-outlined">
                                                            add_circle_outline
                                                        </span>
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr style='border:none'>
                                            <td style="text-align:right; border:none" class=' padding-3 fweight-700 text-md-2' colspan=3>TOTAL AMOUNT</td>
                                            <td class='text-center fweight-700 padding-right-6' style="border:none">
                                                <div class=' d-flex justify-content-between'>
                                                    <div>Rp.</div>
                                                    <div class='total-amount'>0</div>
                                                </div>
                                            </td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                            <!-- DOKUMEN -->


                        </form>


                    </div>


                    <div class='position-fixed' style="bottom:10px; left:50%; transform: translate(-50%, -50%);">
                        <button class='btn btn-success d-flex align-items-center rounded-pill box-shadow btn-lg padding-x-3 padding-y-2' name="tambah-dokumen" id="tambah-dokumen">
                            <span class="material-icons-outlined icon-title">
                                add
                            </span>
                            <div class='fweight-700 text-md-4 margin-left-2'>Tambah Dokumen</div>
                            <div></div>
                        </button>
                    </div>

                    <div class='row margin-top-4'>
                        <div class="col d-flex flex-column justify-content-center align-items-center">
                            <h5>GRAND TOTAL AMOUNT</h5>
                            <div class='d-flex fweight-700 text-md-2'>
                                <div>Rp.</div>
                                <div id='grandtotal-amount'>0</div>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>
                <!-- /SUB DETAIL -->

            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('js_files') ?>
<script src="<?= base_url('template/vendors/select2/select2.min.js') ?>"></script>
<script src="<?= base_url('template/vendors/JqueryMask/jquery.mask.min.js') ?>"></script>
<script src="<?= base_url('template/vendors/LightPick/moment.min.js') ?>"></script>
<script src="<?= base_url('template/vendors/LightPick/lightpick.js') ?>"></script>

<script src="<?= base_url('js/Rekap/RekapFbcjSubDetail.js') ?>"></script>
<?= $this->endSection() ?>