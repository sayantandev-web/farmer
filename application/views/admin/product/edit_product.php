<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
<link rel="stylesheet" type="text/css" href="//cdnjs.cloudflare.com/ajax/libs/codemirror/3.20.0/codemirror.css">
<link rel="stylesheet" type="text/css" href="//cdnjs.cloudflare.com/ajax/libs/codemirror/3.20.0/theme/monokai.css">
<script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/codemirror/3.20.0/codemirror.js"></script>
<script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/codemirror/3.20.0/mode/xml/xml.js"></script>
<script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/codemirror/2.36.0/formatting.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-tagsinput/0.8.0/bootstrap-tagsinput.css" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-tagsinput/0.8.0/bootstrap-tagsinput.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.5/css/select2.min.css" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.5/js/select2.full.min.js"></script>
<div class="main-content">
    <div class="page-content">
        <div class="container-fluid">
            <section class="bg-light-gray">
                <div class="container">
                    <div class="row">
                        <div class="col-12">
                            <div class="page-title-box d-flex align-items-center justify-content-between">
                                <h4 class="mb-0"><?= $title ?></h4>
                                <div class="page-title-right">
                                    <ol class="breadcrumb m-0">
                                        <li class="breadcrumb-item"><a href="<?= base_url('dashboard') ?>">Dashboard</a>
                                        </li>
                                        <li class="breadcrumb-item active"><?= $title ?></li>
                                    </ol>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12 mb-3">
                            <div class="card shadow rounded">
                                <div class="card-body">
                                    <form id="submitform" method="POST" enctype="multipart/form-data" action="<?= base_url('admin/product/edit_product/'.$product->id) ?>">
                                        <div class="form-group mb-2">
                                            <label class="fw-semibold text-black">Liste des Bio agresseurs</label>
                                            <select class="form-control" name="category_name[]" multiple="multiple" id="category_name" required>
                                                <option value="">Select Bio Agressor</option>
                                                <?php
                                                $category_list = $this->db->query("SELECT * FROM category WHERE status = '1'")->result();
                                                foreach($category_list as $category) {?>
                                                    <option value="<?php echo $category->id; ?>"
                                                    <?php if(!empty($product->category_id)){
                                                        $catType = explode(",", $product->category_id);
                                                        for($i=0; $i<count($catType); $i++) {
                                                            if($catType[$i] == $category->id){
                                                                echo "selected";
                                                            }
                                                        }
                                                    } ?>><?php echo $category->category_name;?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                        <small id="event_name_err"></small>
                                        <div class="form-group mb-2">
                                            <label class="fw-semibold  text-black">Nom de la culture</label>
                                            <input type="text" class="form-control" name="product_name" id="product_name" autocomplete="off" value="<?= $product->prod_name?>" required>
                                        </div>
                                        <small id="event_name_err"></small>
                                        <div class="form-group mb-2">
                                            <label class="fw-semibold  text-black">Description de la culture</label>
                                            <textarea class="form-control" name="product_description" id="product_description" autocomplete="off"><?= $product->prod_description?></textarea>
                                        </div>
                                        <!-- <div class="form-group mb-2">
                                            <label class="fw-semibold  text-black">Fertilizer</label>
                                            <textarea class="form-control" name="fertilizer" id="fertilizer" autocomplete="off"><?= $product->engrais?></textarea>
                                        </div> -->
                                        <div class="col-lg-12">
                                            <label>Fertilizer</label>
                                            <div class="panel panel-default">
                                                <div class="panel-body">
                                                    <table class="table jobsites" id="purchaseTableclone1">
                                                        <tr class="color">
                                                            <th><label class="fw-semibold text-black">Title</label></th>
                                                            <th></th>
                                                            <th style="text-align: end;"><button type="button" class="btn btn-info addMoreBtn" onclick="add_row()" >Add Fertilizer</button></th>
                                                        </tr>
                                                        <tbody id="clonetable_feedback1">
                                                            <?php if(!empty($product->engrais)) {
                                                            $portfolio_content = unserialize(@$product->engrais);
                                                            $rows=1;
                                                            foreach ($portfolio_content as $key) { ?>
                                                            <tr>
                                                                <td style="width: 33.33%;">
                                                                    <input type="text" name="content_title[]" id="content_title<?= $rows; ?>" class="form-control" value="<?= $key['content_title']; ?>">
                                                                </td>
                                                                <td style="width: 33.33%;">
                                                                    <input type="text" name="content_desc[]" id="content_desc<?= $rows; ?>" class="form-control" value="<?= $key['content_desc']; ?>">
                                                                </td>
                                                                <td>
                                                                    <select name="icon_file[]" id="icon_file1" class="form-control">
                                                                        <option value=""> Choose an option</option>
                                                                        <option value="uploads/icons/azote.jpeg" <?php if($key['icon_file'] == 'uploads/icons/azote.jpeg') {echo "selected";}?>>Azote</option>
                                                                        <option value="uploads/icons/eau.jpeg" <?php if($key['icon_file'] == 'uploads/icons/eau.jpeg') {echo "selected";}?>>Eau</option>
                                                                        <option value="uploads/icons/organic_matter.jpeg" <?php if($key['icon_file'] == 'uploads/icons/organic_matter.jpeg') {echo "selected";}?>>Organic Matter</option>
                                                                        <option value="uploads/icons/phosphore.jpeg" <?php if($key['icon_file'] == 'uploads/icons/phosphore.jpeg') {echo "selected";}?>>Phosphore</option>
                                                                        <option value="uploads/icons/potassium.jpeg" <?php if($key['icon_file'] == 'uploads/icons/potassium.jpeg') {echo "selected";}?>>Potassium</option>
                                                                    </select>
                                                                </td>
                                                                <td><a href="javascript:void(0)" title="Delete" class="text-danger" onclick="return removeRow(this)">X</a></td>
                                                            </tr>
                                                            <?php } } else { ?>
                                                            <tr>
                                                                <td style="width: 33.33%;">
                                                                    <input type="text" name="content_title[]" id="content_title1" class="form-control" placeholder="Content Title">
                                                                </td>
                                                                <td style="width: 33.33%;">
                                                                    <input type="text" name="content_desc[]" id="content_desc1" class="form-control">
                                                                </td>
                                                                <td>
                                                                    <select name="icon_file[]" id="icon_file1" class="form-control">
                                                                        <option value="">Choose an option</option>
                                                                        <option value="uploads/icons/azote.jpeg">Azote</option>
                                                                        <option value="uploads/icons/eau.jpeg">Eau</option>
                                                                        <option value="uploads/icons/organic_matter.jpeg">Organic Matter</option>
                                                                        <option value="uploads/icons/phosphore.jpeg">Phosphore</option>
                                                                        <option value="uploads/icons/potassium.jpeg">Potassium</option>
                                                                    </select>
                                                                </td>
                                                                <td>
                                                                    <a href="javascript:void(0)" title="Delete" class="text-danger" onclick="return removeRow(this)">X</a>
                                                                </td>
                                                            </tr>
                                                            <?php } ?>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group mb-2">
                                            <label class="fw-semibold  text-black">Observations</label>
                                            <textarea class="form-control" name="bio_aggressors" id="bio_aggressors" autocomplete="off"><?= $product->bio_aggresseurs?></textarea>
                                        </div>
                                        <div class="form-group mb-2">
                                            <label class="fw-semibold  text-black">Liens annexes</label>
                                            <textarea class="form-control" name="maladies" id="maladies" autocomplete="off"><?= $product->maladies?></textarea>
                                        </div>
                                        <div class="form-group mb-2">
                                            <label class="fw-semibold  text-black">Début de période de plantation</label>
                                            <div id="months-container">
                                            <?php 
                                            if(!empty($product->start_period)){
                                            $selectedMonths = array_map('trim', explode(',', $product->start_period));
                                            $month_data = $this->db->query("SELECT * FROM month_data")->result(); // Fetch months from DB
                                            foreach ($month_data as $key => $month) { 
                                                $isChecked = in_array($month->id, $selectedMonths) ? 'checked' : ''; 
                                                ?>
                                                <label>
                                                    <input type="checkbox" value="<?= htmlspecialchars($month->id); ?>" <?= $isChecked; ?> /> 
                                                    <?= htmlspecialchars($month->month_name); ?>
                                                </label>
                                            <?php } } else {
                                                $month_data = $this->db->query("SELECT * FROM month_data")->result();
                                                foreach ($month_data as $key => $month) { ?>
                                                <label><input type="checkbox" value="<?= $month->id; ?>"/> <?= $month->month_name; ?></label>
                                                <?php } } ?>
                                            </div>
                                            <input type="hidden" name="period_list1" id="period_list1" value="<?= @$product->start_period?>">
                                        </div>

                                        <div class="form-group mb-2">
                                            <label class="fw-semibold  text-black">Fin de période de plantation</label>
                                            <div id="months-container1">
                                            <?php 
                                            if(!empty($product->end_period)){
                                            $selectedMonths = array_map('trim', explode(',', $product->end_period));
                                            $month_data = $this->db->query("SELECT * FROM month_data")->result(); // Fetch months from DB
                                            foreach ($month_data as $key => $month) { 
                                                $isChecked = in_array($month->id, $selectedMonths) ? 'checked' : ''; 
                                                ?>
                                                <label>
                                                    <input type="checkbox" value="<?= htmlspecialchars($month->id); ?>" <?= $isChecked; ?> /> 
                                                    <?= htmlspecialchars($month->month_name); ?>
                                                </label>
                                            <?php } } else {
                                                $month_data = $this->db->query("SELECT * FROM month_data")->result();
                                                foreach ($month_data as $key => $month) { ?>
                                                <label><input type="checkbox" value="<?= $month->id; ?>"/> <?= $month->month_name; ?></label>
                                                <?php } } ?>
                                            </div>
                                            <input type="hidden" name="period_list2" id="period_list2" value="<?= @$product->end_period?>">
                                        </div>
                                        <div class="form-group mb-2">
                                            <label class="fw-semibold  text-black">Nombre de jours de recolte</label>
                                            <input type="text" class="form-control" name="harvest_days" id="harvest_days" autocomplete="off" value="<?= $product->harvest_days?>">
                                        </div>
                                        <div class="form-group mb-2">
                                            <label class="fw-semibold  text-black">Nombre de jours fin recolte</label>
                                            <input type="text" class="form-control" name="harvest_end" id="harvest_end" autocomplete="off" value="<?= $product->harvest_end?>">
                                        </div>
                                        <div class="form-group mb-2">
                                            <label class="fw-semibold  text-black">Duré/ nombre de recolte</label>
                                            <textarea class="form-control" name="number_harvest" id="number_harvest" autocomplete="off"><?= $product->number_harvest?></textarea>
                                        </div>
                                        <small id="event_name_err"></small>
                                        <div class="form-group mb-2 files col-6" style="display: inline-block; float: left; margin-right: 100px;">
                                            <label class="fw-semibold  text-black">Product Image</label>
                                            <input type="file" class="form-control" name="product_image" id="product_image" >
                                            <?php if(!empty(@$product->product_image) && file_exists('uploads/product/'.@$product->product_image)) { ?>
                                            <input type="hidden" name="old_image" id="old_image" value="<?= @$product->product_image?>">
                                            <img src="<?= base_url('uploads/product/'.@$product->product_image)?>" style="width: 160px; height: 100px; margin-top: 10px;">
                                            <?php } ?>
                                        </div>
                                        <div class="form-group mb-2 col-6">
                                            <label class="fw-semibold text-black">Status</label>
                                            <select class="form-control" name="product_status" id="product_status" required>
                                                <option value="">Select Status</option>
                                                <option value="1" <?php if(@$product->status=='1'){echo "selected";}?>>Active</option>
                                                <option value="0" <?php if(@$product->status=='0'){echo "selected";}?>>Inactive</option>
                                            </select>
                                        </div>
                                        <small id="event_status_err"></small>
                                        <div class="form-group mt-3 mb-2">
                                            <button class="btn btn-success text-uppercase px-5 shadow">Submit</button>
                                            <a class="btn btn-danger waves-effect waves-light m-l-30" href="javascript:history.go(-1)">Back</a>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>
</div>
<script>
$(document).ready(function(){
    $('#product_description').summernote({
        height: 150, //set editable area's height
        codemirror: { // codemirror options
            theme: 'monokai'
        }
    })
    $('#fertilizer').summernote({
        height: 150, //set editable area's height
        codemirror: { // codemirror options
            theme: 'monokai'
        }
    })
    $('#bio_aggressors').summernote({
        height: 150, //set editable area's height
        codemirror: { // codemirror options
            theme: 'monokai'
        }
    })
    $('#maladies').summernote({
        height: 150, //set editable area's height
        codemirror: { // codemirror options
            theme: 'monokai'
        }
    })
    $('.content_title1').summernote({
        height: 150, //set editable area's height
        codemirror: { // codemirror options
            theme: 'monokai'
        }
    })
    $('.content_desc1').summernote({
        height: 150, //set editable area's height
        codemirror: { // codemirror options
            theme: 'monokai'
        }
    })
    $('#months-container input[type="checkbox"]').change(function () {
        const selectedMonths = $('#months-container input[type="checkbox"]:checked')
            .map(function () {
                return $(this).val();
            })
            .get(); // Get an array of selected values

        // Update the text in the #selected-list container
        $('#period_list1').val(selectedMonths.join(', '));
    });

    $('#months-container1 input[type="checkbox"]').change(function () {
        const selectedMonths = $('#months-container1 input[type="checkbox"]:checked')
            .map(function () {
                return $(this).val();
            })
            .get(); // Get an array of selected values

        // Update the text in the #selected-list container
        $('#period_list2').val(selectedMonths.join(', '));
    });

    $('#category_name').select2({
        //tags: true,
        tokenSeparators: [','],
        placeholder: "Select or Type Bio Agressor",
    });
})
let rowCount = 1;

function add_row() {
    rowCount++;
    const table = document.getElementById("clonetable_feedback1");
    const row = table.insertRow();
    row.innerHTML = `<td style="width: 33.33%;"><input type="text" name="content_title[]" id="content_title${rowCount}" class="form-control" placeholder="Content Title"></td><td style="width: 33.33%;"><input type="text" name="content_desc[]" id="content_desc${rowCount}" class="form-control" placeholder="Content Description"></td><td><select name="icon_file[]" id="icon_file${rowCount}" class="form-control"><option value=""> Choose an option</option><option value="one"> One</option><option value="two"> Two</option><option value="three"> Three</option><option value="four"> Four</option></select></td><td><a href="javascript:void(0)" title="Delete" class="text-danger" onclick="return removeRow(this)">X</a></td>`;
}

function removeRow(element) {
    const row = element.parentElement.parentElement;
    row.remove();
}
</script>