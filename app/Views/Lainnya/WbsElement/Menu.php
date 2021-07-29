<?php
$library = new App\Libraries\Library;
?>
<div class='data-tabs'>
    <div class='tabs-item d-flex align-items-center <?= $library->activeIf('wbs_element', 'active') ?>' onclick="document.location='<?= base_url('wbs_element') ?>' ">
        <span class="material-icons-outlined">
            format_list_bulleted
        </span>
        <div class='margin-left-2'>Data Wbs Element</div>
    </div>
    <div class='tabs-item d-flex align-items-center <?= $library->activeIf('wbs_element/tambah', 'active') ?>' onclick="document.location='<?= base_url('wbs_element/tambah') ?>' ">
        <span class="material-icons-outlined">
            add
        </span>
        <div class='margin-left-2'>Tambah Wbs Element</div>
    </div>


    <?php
    if (isset($menu) && $menu == 'Ubah Wbs Element') : ?>
        <div class='tabs-item d-flex align-items-center active' onclick="document.location='<?= current_url() ?>' ">
            <span class="material-icons-outlined">
                edit
            </span>
            <div class='margin-left-2'><?= $menu ?></div>
        </div>

    <?php endif; ?>
</div>