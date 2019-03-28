<?php
/**
 *
 */

$data = $spreadsheet->getActiveSheet()->toArray();
$res = [];
foreach ($data as $n => $item) {
    if ($n === 0) continue;
    foreach ($item as $i => $value) {
        $res[$n][$data[0][$i]] = $value;
    }
}

?>
    <div class="col-lg-6">
        <?php var_dump($data); ?>
    </div>
    <div class="col-lg-6">
        <?php var_dump($res); ?>
    </div>

<?php
