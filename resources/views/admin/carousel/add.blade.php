<div class="modal fade" id="addCarouselModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Add Carousel</h1>
            </div>
            <div class="modal-body">
                <form id="carouselForm" name="carouselForm" class="form-horizontal">
                    <input type="hidden" name="carousel_id" id="carousel_id">
                    <div class="row">
                        <div class="col-12">
                            <div class="form-group">
                                <label for="title" class="col-sm-2 control-label">
                                    Title
                                </label>
                                <div class="col-12">
                                    <input type="text" name="title" id="title" class="form-control" placeholder="Title" value="" required="">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="image" class="col-sm-2 control-label">
                                    Image
                                </label>
                                <div class="col-12">
                                    <input type="file" accept="jpg,png,svg" name="image" id="image" class="form-control" placeholder="Image" value="" required="">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="current_image" class="col-sm-2 control-label">Current Image</label>
                                <div class="col-12">
                                    <img id="current_image" src="" style="max-width: 100%; height: auto;" width="100px">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-offset-2 col-sm-10">
                            <button type="submit" class="btn btn-primary" id="saveCarousel"><i class="far fa-save"></i> Save</button>
                            <button type="submit" class="btn btn-primary" id="updateCarousel"><i class="far fa-save"></i> Update</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
