<?php
$str_data = "";
foreach ($data as $row) {
    $str_data .= implode(',', $row) . "==";
}
?>
<div class="w-full flex justify-between text-white">
    <form action="<?php echo BaseURL_admin . 'fileload.php' ?>" method="post">
        <input type="hidden" name="data" value="<?php echo $str_data ?>">
        <button class="p-2 rounded bg-blue-500" type="submit" name="submit_export">Export To CSV File</button>
    </form>
    <form action="<?php echo BaseURL_admin . 'fileload.php' ?>" method="post" enctype="multipart/form-data">
        <label class="p-2 rounded cursor-pointer bg-blue-500 " for="upload" >Import CSV File</label>
        <input type="file" id="upload" name="csv_file" class="hidden" onchange="document.getElementById('import').click()" >
        <button  class="hidden" id="import" type="submit" name="submit_import"></button>
    </form>
</div>