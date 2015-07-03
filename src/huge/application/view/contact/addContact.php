<div class="well">
    <nav id="mainContainerPanel">
        <form class="form-horizontal" action="javascript:void(0);" method="post">
            <fieldset>
                <legend>Insert a new contact!</legend>
                <div class="col-sm-12">
                    <div class="panel-default">
                        <div class="panel-body">
                            <div class="form-group">
                                <label for="contactPrefix" class="col-lg-2 control-label">Prefix</label>
                                <div class="col-lg-10">
                                    <input type="text" class="form-control" id="contactPrefix" name="contactPrefix" placeholder="Prefix">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="contactFirstName" class="col-lg-2 control-label">First Name</label>
                                <div class="col-lg-10">
                                    <input type="text" class="form-control" id="contactFirstName" name="contactFirstName" placeholder="First Name" required />
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="contactMiddleName" class="col-lg-2 control-label">Middle Name</label>
                                <div class="col-lg-10">
                                    <input type="text" class="form-control" id="contactMiddleName" name="contactMiddleName" placeholder="Middle Name">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="contactLastName" class="col-lg-2 control-label">Last Name</label>
                                <div class="col-lg-10">
                                    <input type="text" class="form-control" id="contactLastName" name="contactLastName" placeholder="Last Name" required />
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="contactSuffix" class="col-lg-2 control-label">Suffix</label>
                                <div class="col-lg-10">
                                    <input type="text" class="form-control" id="contactSuffix" name="contactSuffix" placeholder="Suffix">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-12">
                    <div class="panel-default">
                        <div class="panel-body">
                            <!--<div class="form-group">
                                <div class="col-lg-2"></div>
                                <div class="col-lg-10">
                                    <div class="checkbox">
                                        <label>
                                            <input type="checkbox" name="contactIsCompany" value="true">Show as Company
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="contactCompany" class="col-lg-2 control-label">Company</label>
                                <div class="col-lg-10">
                                    <input type="text" class="form-control" id="contactCompany" name="contactCompany" placeholder="Company name">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="contactDepartment" class="col-lg-2 control-label">Department</label>
                                <div class="col-lg-10">
                                    <input type="text" class="form-control" id="contactDepartment" name="contactDepartment" placeholder="Department">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="contactJobTitle" class="col-lg-2 control-label">Job title</label>
                                <div class="col-lg-10">
                                    <input type="text" class="form-control" id="contactJobTitle" name="contactJobTitle" placeholder="Job title">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="contactJobRole" class="col-lg-2 control-label">Job role</label>
                                <div class="col-lg-10">
                                    <input type="text" class="form-control" id="contactJobRole" name="contactJobRole" placeholder="Job role">
                                </div>
                            </div>-->
                            <div class="form-group">
                                <label for="contactBirthDate" class="col-lg-2 control-label">Birthday</label>
                                <div class="col-lg-10">
                                    <input type="date"class="form-control" id="contactBirthDate" name="contactBirthDate">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-12">
                    <div class="panel panel-primary">
                        <div class="panel-heading">Phone</div>
                        <div class="panel-body">
                            <div class="form-group">
                                <div class="col-lg-2">
                                    <select name="phoneType" id="phoneType">
                                        <option value="HOME">Home</option>
                                        <option value="WORK">Work</option>
                                    </select>
                                </div>
                                <div class="col-lg-10">
                                    <input type="text" class="form-control" id="phoneValue" name="phoneValue" placeholder="Phone number">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-12">
                    <div class="panel panel-primary">
                        <div class="panel-heading">Mail</div>
                        <div class="panel-body">
                            <div class="form-group">
                                <div class="col-lg-2">
                                    <select name="mailType" id="mailType">
                                        <option value="HOME">Home</option>
                                        <option value="WORK">Work</option>
                                    </select>
                                </div>
                                <div class="col-lg-10">
                                    <input type="text" class="form-control" id="mailValue" name="mailValue" placeholder="Mail">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-12">
                    <div class="panel panel-primary">
                        <div class="panel-heading">Street Address</div>
                        <div class="panel-body">
                            <div class="form-group">
                                <div class="col-lg-2">
                                    <select name="addressType" id="addressType">
                                        <option value="HOME">Home</option>
                                        <option value="WORK">Work</option>
                                    </select>
                                </div>
                                <div class="col-lg-10">
                                    <input type="text" class="form-control" id="addressStreet" name="addressStreet" placeholder="Street">
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-lg-2"></div>
                                <div class="col-lg-10">
                                    <input type="text" class="form-control" id="addressCity" name="addressCity" placeholder="City">
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-lg-2"></div>
                                <div class="col-lg-10">
                                    <input type="text" class="form-control" id="addressRegion" name="addressRegion" placeholder="Region">
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-lg-2"></div>
                                <div class="col-lg-10">
                                    <input type="text" class="form-control" id="addressPostalCode" name="addressPostalCode" placeholder="Postal code">
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-lg-2"></div>
                                <div class="col-lg-10">
                                    <input type="text" class="form-control" id="addressCountry" name="addressCountry" placeholder="Country">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-12">
                    <div class="panel panel-primary">
                        <div class="panel-heading">Internet</div>
                        <div class="panel-body">
                            <div class="form-group">
                                <div class="col-lg-2">
                                    <select name="internetType" id="internetType">
                                        <option value="HOME">Home</option>
                                        <option value="WORK">Work</option>
                                    </select>
                                </div>
                                <div class="col-lg-10">
                                    <input type="text" class="form-control" id="internetValue" name="internetValue" placeholder="Internet">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-12">
                    <div class="panel panel-primary">
                        <div class="panel-heading">Notes</div>
                        <div class="panel-body">
                            <div class="form-group">
                                <div class="col-lg-12">
                                    <textarea class="form-control" id="contactNotes" name="contactNotes" placeholder="Notes" rows="4" />
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-sm-12" style="text-align: center;">
                        <!--<input type="submit" class="btn btn-success btn-lg" id="btn_save" value="Save">-->
                        <button class="btn btn-fab btn-fab btn-lg btn-raised btn-primary" id="btn_save" style="margin-right: 10px;">
                            <i class="fa fa-check fa-lg"></i>
                        </button>
                        <a class="btn btn-fab btn-fab btn-lg btn-raised btn-danger" href="<?php echo Config::get('URL'); ?>dashboard/index" style="margin-left: 10px;">
                            <i class="fa fa-times fa-lg"></i>
                        </a>


                    </div>
                </div>
            </fieldset>
        </form>
    </nav>
</div>
