<div class="modal fade" id="addTestimonialModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Add Testimonial</h1>
            </div>
            <div class="modal-body">
                <form id="testimonialForm" name="testimonialForm" class="form-horizontal">
                    <input type="hidden" name="testimonial_id" id="testimonial_id">
                    <div class="row">
                        <div class="col-12">
                            <div class="form-group">
                                <label for="name" class="col-sm-2 control-label">
                                    Name
                                </label>
                                <div class="col-12">
                                    <input type="text" name="name" id="name" class="form-control"
                                        placeholder="Name" value="" required="">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="testimonial" class="col-sm-2 control-label">
                                    Testimonial
                                </label>
                                <div class="col-12">
                                    <textarea rows="5" name="testimonial" id="testimonial" class="form-control" placeholder="Testimonial"
                                        value="" required=""></textarea>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="job" class="col-sm-2 control-label">
                                    Job
                                </label>
                                <div class="col-12">
                                    <input type="text" name="job" id="job" class="form-control"
                                        placeholder="Job" value="" required="">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="image" class="col-sm-2 control-label">
                                    Image
                                </label>
                                <div class="col-12">
                                    <input type="file" accept="jpg,png,svg" name="image" id="image"
                                        class="form-control" placeholder="Image" value="" required="">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="current_image" class="col-sm-2 control-label">Current Image</label>
                                <div class="col-12">
                                    <img id="current_image" src="" style="max-width: 100%; height: auto;"
                                        width="100px">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-offset-2 col-sm-10">
                            <button type="submit" class="btn btn-primary" id="saveTestimonial"><i
                                    class="far fa-save"></i> Save</button>
                            <button type="submit" class="btn btn-primary" id="updateTestimonial"><i
                                    class="far fa-save"></i> Update</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
