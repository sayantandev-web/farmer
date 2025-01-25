<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
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
                        <div class="col-lg-6 mb-3">
                            <div class="card shadow rounded">
                                <div class="card-body">
                                    <form id="submitform" method="POST" enctype="multipart/form-data" action="<?= base_url('admin/category/add_category') ?>">
                                        <div class="form-group mb-2">
                                            <label class="fw-semibold  text-black">Category Name</label>
                                            <input type="text" class="form-control" name="category_name" id="category_name" autocomplete="off" required>
                                        </div>
                                        <small id="event_name_err"></small>
                                        <div class="form-group mb-2">
                                            <label class="fw-semibold  text-black">Category Description</label>
                                            <textarea class="form-control" name="category_description" id="category_description" autocomplete="off"></textarea>
                                        </div>
                                        <small id="event_name_err"></small>
                                        <div class="form-group mb-2 files">
                                            <label class="fw-semibold  text-black">Category Image</label>
                                            <input type="file" class="form-control" name="category_image"  id="category_image" >
                                        </div>
                                        <div class="form-group mb-2">
                                            <label class="fw-semibold  text-black">Status</label>
                                            <select class="form-control" name="category_status" id="category_status" required>
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