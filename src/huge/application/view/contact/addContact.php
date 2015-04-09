<div class="well">
    <form class="form-horizontal" action="<?php echo Config::get('URL'); ?>contact/insertnewcontact" method="post">
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
                        <div class="form-group">
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
                        </div>
                        <div class="form-group">
                            <label for="contactBirthDate" class="col-lg-2 control-label">Birthday</label>
                            <div class="col-lg-10">
                                <input type="text" class="form-control" id="contactBirthDate" name="contactBirthDate" placeholder="(There will be a select and other stuff)">
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
                                <select name="phone1Type">
                                    <option value="home">Home</option>
                                    <option value="work">Work</option>
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
                            <div class="col-lg-12">
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
                            <label for="addressStreet" class="col-lg-2 control-label">Home</label>
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
            <div class="col-sm-4">
                <div class="panel panel-warning">
                    <div class="panel-heading">
                        <h3 class="panel-title">Attention pls!</h3>
                    </div>
                    <div class="panel-body">
                        <p>Many fields are not included and they will set to default values or null when inserting.</p>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <div class="col-sm-4">
                    <input type="submit" class="btn btn-success btn-lg" value="Save">
                    <a href="<?php echo Config::get('URL'); ?>dashboard/index" class="btn btn-danger btn-lg">Cancel</a>
                </div>
            </div>
        </fieldset>
    </form>
</div>