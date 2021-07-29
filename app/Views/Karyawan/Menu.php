<?php
$library = new App\Libraries\Library;
$accessKaryawan = [
    $library->activeIf('karyawan', 'active'),
    $library->activeIfRoutes('KaryawanController/detail', 'active'),
];

$accessBuatAkun = [
    $library->activeIfRoutes('UserController/tambah', 'active'),
];
$menuBuatAkun = [$library->activeIfRoutes('UserController/tambah', 'active')];
?>
<div class='data-tabs'>
    <div class='tabs-item d-flex align-items-center  <?= in_array('active', $accessKaryawan) ? 'active'  : '' ?>' onclick="document.location='<?= base_url('karyawan') ?>' ">
        <span class="material-icons-outlined">
            format_list_bulleted
        </span>
        <div class='margin-left-2'>Data karyawan</div>
    </div>
    <div class='tabs-item d-flex align-items-center <?= $library->activeIf('karyawan/tambah', 'active') ?>' onclick="document.location='<?= base_url('karyawan/tambah') ?>' ">
        <span class="material-icons-outlined">
            add
        </span>
        <div class='margin-left-2'>Tambah karyawan</div>
    </div>
    <?php if (in_array('active', $menuBuatAkun)) : ?>
        <div class='tabs-item d-flex align-items-center  <?= in_array('active', $accessBuatAkun) ? 'active'  : '' ?>' onclick="document.location='' ">
            <span class="material-icons-outlined">
                add
            </span>
            <div class='margin-left-2'>Buat Akun</div>
        </div>
    <?php endif; ?>

    <?php
    if (isset($menu) && $menu == 'Ubah Karyawan') : ?>
        <div class='tabs-item d-flex align-items-center active' onclick="document.location='<?= current_url() ?>' ">
            <span class="material-icons-outlined">
                edit
            </span>
            <div class='margin-left-2'><?= $menu ?></div>
        </div>

    <?php endif; ?>
</div>