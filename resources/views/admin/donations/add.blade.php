<div class="modal fade" id="addDonationModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Add Donation</h1>
            </div>
            <div class="modal-body">
                <form id="donationForm" name="donationForm" class="form-horizontal">
                    <input type="hidden" name="donation_id" id="donation_id">
                    <div class="row">
                        <div class="col-12">
                            <div class="form-group">
                                <label for="title" class="col-sm-2 control-label">
                                    Title
                                </label>
                                <div class="col-12">
                                    <input type="text" name="title" id="title" class="form-control"
                                        placeholder="Title" value="" required="">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="description" class="col-sm-2 control-label">
                                    Description
                                </label>
                                <div class="col-12">
                                    <textarea rows="4" name="description" id="description" class="form-control" placeholder="Description"
                                        value="" required=""></textarea>
                                    <div id="charCountDescription">0/200</div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="donation_target" class="col-sm-2 control-label">
                                    Donation Target
                                </label>
                                <div class="col-12">
                                    <input type="number" name="donation_target" id="donation_target"
                                        class="form-control" placeholder="Donation Target" value=""
                                        required="">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="start_date" class="col-sm-2 control-label">
                                    Start Date
                                </label>
                                <div class="col-12">
                                    <input type="date" name="start_date" id="start_date" class="form-control"
                                        placeholder="Start Date" value="" required="">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="end_date" class="col-sm-2 control-label">
                                    End Date
                                </label>
                                <div class="col-12">
                                    <input type="date" name="end_date" id="end_date" class="form-control"
                                        placeholder="End Date" value="" required="">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="image" class="col-sm-2 control-label">Image</label>
                                <div class="col-12">
                                    <input class="mb-2" type="file" id="images" name="image" value="" required="">
                                    <div id="upload-demo"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-offset-2 col-sm-10">
                            <button type="submit" class="btn btn-primary" id="saveDonation"><i class="far fa-save"></i>
                                Save</button>
                            <button type="submit" class="btn btn-primary" id="updateDonation"><i
                                    class="far fa-save"></i> Update</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
