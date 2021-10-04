
<div class="col-12">
    <div class="col-md-2">
        <h6>Department:</h6>
    </div>
    <input type="hidden" name="level_id_params" value="<?=$data["level_params"] ?>" />
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
        </div>
        <div class="col-md-3">
            <p style="margin:0;padding:0">
                Home Page Status
            </p>
            <select class="form-control" name="home_page_status">
                <option class="" value="1">Show</option>
                <option value="2">Hide</option>
            </select>
        </div>
        <div class="col-md-3">
            <p style="margin:0;padding:0">
                Sort Id
            </p>
            <input class="form-control" name="sort_id" class="sort_id" />
        </div>
    </div>
    </div>
<div class="col-12 mt-2">
    <div class="col-md-3">
        <input  type="submit" id="create-button" class="btn btn-primary px-5" value="Create">
    </div>
</div>