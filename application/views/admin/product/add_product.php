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
                                    <form id="submitform" method="POST" enctype="multipart/form-data" action="<?= base_url('admin/product/add_product') ?>">
                                        <div class="form-group mb-2">
                                            <label class="fw-semibold text-black">Liste des Bio agresseurs</label>
                                            <select class="form-control" name="category_name[]" multiple="multiple" id="category_name" required>
                                                <option value="">Select Bio Aggressors</option>
                                                <?php 
                                                if(!empty($category_list)) { 
                                                foreach($category_list as $cat) { ?>
                                                <option value="<?= $cat->id?>"><?= $cat->category_name?></option>
                                                <?php } } ?>
                                            </select>
                                        </div>
                                        <small id="event_name_err"></small>
                                        <div class="form-group mb-2">
                                            <label class="fw-semibold  text-black">Nom de la culture</label>
                                            <input type="text" class="form-control" name="product_name" id="product_name" autocomplete="off" required>
                                        </div>
                                        <small id="event_name_err"></small>
                                        <div class="form-group mb-2">
                                            <label class="fw-semibold  text-black">Description de la culture</label>
                                            <textarea class="form-control" name="product_description" id="product_description" autocomplete="off"></textarea>
                                        </div>
                                        <!-- <div class="form-group mb-2">
                                            <label class="fw-semibold  text-black">Fertilizer</label>
                                            <textarea class="form-control" name="fertilizer" id="fertilizer" autocomplete="off"></textarea>
                                        </div> -->
                                        <div class="col-lg-12">
                                            <label>Fertilizer</label>
                                            <div class="panel panel-default">
                                                <div class="panel-body">
                                                    <table class="table jobsites" id="purchaseTableclone1">
                                                        <tr class="color">
                                                            <th><label class="fw-semibold text-black">Title</label></th>
                                                            <th></th>
                                                            <th style="text-align: end;"><button type="button" class="btn btn-info addMoreBtn" onclick="add_row()">Add Fertilizer</button></th>
                                                        </tr>
                                                    </table>
                                                    <table id="clonetable_feedback1" style="width: 100%;">
                                                        <tr>
                                                            <td style="width: 33.33%;">
                                                                <input type="text" name="content_title[]" id="content_title1" class="form-control" placeholder="Content Title">
                                                            </td>
                                                            <td style="width: 33.33%;">
                                                                <input type="text" name="content_desc[]" id="content_desc1" class="form-control" placeholder="Content Description">
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
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group mb-2">
                                            <label class="fw-semibold  text-black">Observations</label>
                                            <textarea class="form-control" name="bio_aggressors" id="bio_aggressors" autocomplete="off"></textarea>
                                        </div>
                                        <div class="form-group mb-2">
                                            <label class="fw-semibold  text-black">Liens annexes</label>
                                            <textarea class="form-control" name="maladies" id="maladies" autocomplete="off"></textarea>
                                        </div>
                                        <div class="form-group mb-2">
                                            <label class="fw-semibold  text-black">Début de période de plantation</label>
                                            <div id="months-container">
                                                <?php
                                                $month_data = $this->db->query("SELECT * FROM month_data")->result();
                                                foreach ($month_data as $key => $month) { ?>
                                                <label><input type="checkbox" value="<?= $month->id; ?>"/> <?= $month->month_name; ?></label>
                                                <?php } ?>
                                            </div>
                                            <input type="hidden" name="period_list1" id="period_list1" >
                                        </div>
                                        <div class="form-group mb-2">
                                            <label class="fw-semibold  text-black">Fin de période de plantation</label>
                                            <div id="months-container1">
                                                <?php
                                                $month_data = $this->db->query("SELECT * FROM month_data")->result();
                                                foreach ($month_data as $key => $month) { ?>
                                                <label><input type="checkbox" value="<?= $month->id; ?>"/> <?= $month->month_name; ?></label>
                                                <?php } ?>
                                            </div>
                                            <input type="hidden" name="period_list2" id="period_list2" >
                                        </div>
                                        <div class="form-group mb-2">
                                            <label class="fw-semibold  text-black">Nombre de jours de recolte</label>
                                            <input type="text" class="form-control" name="harvest_days" id="harvest_days" autocomplete="off"></textarea>
                                        </div>
                                        <div class="form-group mb-2">
                                            <label class="fw-semibold  text-black">Nombre de jours fin recolte</label>
                                            <input type="text" class="form-control" name="harvest_end" id="harvest_end" autocomplete="off"></textarea>
                                        </div>
                                        <div class="form-group mb-2">
                                            <label class="fw-semibold  text-black">Duré/ nombre de recolte</label>
                                            <textarea class="form-control" name="number_harvest" id="number_harvest" autocomplete="off"></textarea>
                                        </div>
                                        <small id="event_name_err"></small>
                                        <div class="form-group mb-2 files col-6" style="display: inline-block; float: left; margin-right: 100px;">
                                            <label class="fw-semibold  text-black">Auxillaire Potentiels Image</label>
                                            <input type="file" class="form-control" name="product_image" id="product_image" >
                                        </div>
                                        <div class="form-group mb-2 col-6">
                                            <label class="fw-semibold text-black">Status</label>
                                            <select class="form-control" name="product_status" id="product_status" required>
                                                <option value="">Select Status</option>
                                                <option value="1">Active</option>
                                                <option value="0">Inactive</option>
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