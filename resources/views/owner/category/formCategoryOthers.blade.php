

<div class="col-12">
    <div class="col-md-2 mt-3">
        <h6>Parent:</h6>
    </div>
    <input type="hidden" name="level_id_params" value="<?=$data["level_params"] ?>" />
    <div class="col-md-7 mt-3">
        <select name="parent_id" class="js-states form-control parent_id"></select>
        <span id="parent-error" class="form-text font-weight-bold text-danger"></span>
    </div>
</div>
<div class="col-12">
    <div class="col-md-2">
        <h6>Title:</h6>
    </div>
    <div class="col-md-7">
        <input name="name" type="text" class="form-control" id="name"  placeholder="Enter name">
        <span class="form-text name-error font-weight-bold text-danger"></span>
        <input name="image" type="file" class="form-control" id="image">
        <span class="form-text image-error font-weight-bold text-danger"></span>
    </div>
</div>
<div class="col-12 mt-2">
    <div class="row">
        <div class="col-md-3">
            <p style="margin:0;padding:0">
                Status
            </p>
            <select name="status" class="form-control">
                <option value="1">Active</option>
                <option value="2">InActive</option>
            </select>
            <span id="name-error" class="form-text font-weight-bold text-danger"></span>
        </div>
        <div class="col-md-3">
            <p style="margin:0;padding:0">
                Home Page Status
            </p>
            <select class="form-control">
                <option class="" value="1">Show</option>
                <option value="2">Hide</option>
            </select>
        </div>
        <div class="col-md-3">
            <p style="margin:0;padding:0">
                Sort Id
            </p>
            <input class="form-control" name="sort_id" />
        </div>
    </div>    
</div>
<div class="col-12 mt-2">
    <!--onclick="subaddData()" -->
    <div class="col-md-3">
        <button id="subcreate-button" type="submit"  class="btn btn-primary px-5">Create </button>
    </div>
</div>