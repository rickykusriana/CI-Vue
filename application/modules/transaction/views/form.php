<div style="padding:40px 15px">

    <div class="panel panel-default">
        <div class="panel-heading">
            <h4>{{ title }}</h4>
        </div>

        <div class="panel-body" style="padding-top:25px">

            <!-- <form> -->

                <div class="col-md-3">
                    <div class="form-group">
                        <label class="control-label">Product Name</label>
                        <input
                            v-model="product_name"
                            required
                            type="text"
                            name="product_name"
                            class="form-control"
                            placeholder="Input product name"/>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label class="control-label">Product Qty</label>
                        <input
                            v-model="product_qty"
                            required
                            autoComplete="off"
                            type="number"
                            name="product_qty"
                            class="form-control"
                            placeholder="Input quantity"/>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label class="control-label">Utilities</label>
                        <input
                            v-model="utilities"
                            required
                            type="text"
                            name="utilities"
                            class="form-control"
                            placeholder="Input utilities"/>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label class="control-label">Date of Return</label>
                        <input 
                            v-model="date_of_return"
                            required
                            type="text" 
                            name="date_of_return" 
                            class="form-control datepicker" 
                            placeholder="Input date of return"
                            data-date-format="yyyy-mm-dd" />
                    </div>
                </div>

                <div class="col-md-12">
                    <br/>
                    <div class="btn-toolbar pull-right">
                        <button class="btn btn-default" @click="btn_save">
                            <i style="color:green" class="fa fa-plus"></i> Add Product
                        </button>
                    </div>
                </div>

            <!-- </form> -->

            <div class="col-md-12" style="padding-top:10px; padding-bottom:15px">
            <hr/>

            <table class="table table-condensed table-bordered table-hover">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Product Name</th>
                        <th>Product Qty</th>
                        <th>Utilities</th>
                        <th>Date of Return</th>
                        <th style="text-align:center;"><i class="fa fa-cogs"></i></th>
                    </tr>
                </thead>
                <tbody v-for="(json, n) in product">

                    <tr>
                        <td>{{ json.no }}</td>
                        <td>{{ json.product_name }}</td>
                        <td>{{ json.product_qty }}</td>
                        <td>{{ json.utilities }}</td>
                        <td>{{ json.date_of_return }}</td>
                        <td align="center">
                            <button class="btn btn-xs btn-info" @click="btn_edit(n)" title="Edit">
                                <i class="fa fa-pencil"></i>
                            </button>
                            <button class="btn btn-xs btn-danger" @click="btn_remove(n)" title="Delete">
                                <i class="fa fa-remove"></i>
                            </button>
                        </td>
                    </tr>

                </tbody>
            </table>

            </div>
        </div>
    </div>

    <div class="panel panel-default">
        <div class="panel-heading">
            <h4>Detail Borrowing</h4>
        </div>

        <form>

            <div class="panel-body" style="padding-top:25px">
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="control-label">Borrower Name</label>
                        <input
                            required
                            type="text"
                            name="borrower_name"
                            id="borrower_name"
                            class="form-control"
                            autoComplete="off"
                            placeholder="Input here"/>
                    </div>
                    <div class="form-group">
                        <label class="control-label">Phone</label>
                        <input
                            required
                            type="text"
                            name="phone"
                            id="phone"
                            class="form-control"
                            autoComplete="off"
                            placeholder="Input here"/>
                    </div>
                    <div class="form-group">
                        <label class="control-label">Email</label>
                        <input
                            required
                            type="text"
                            name="email"
                            id="email"
                            class="form-control"
                            autoComplete="off"
                            placeholder="Input here"/>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label class="control-label">Date of Borrowing</label>
                        <input
                            required
                            type="text"
                            name="date_of_borrowing"
                            id="date_of_borrowing"
                            class="form-control"
                            autoComplete="off"
                            placeholder="Input here"/>
                    </div>
                    <div class="form-group">
                        <label class="control-label">Note</label>
                        <textarea
                            name="note_of_borrowing"
                            id="note_of_borrowing"
                            class="form-control"
                            autoComplete="off"
                            placeholder="Input here">
                        </textarea>
                    </div>
                </div>

                <div class="col-md-12">
                    <br/>
                    <div class="btn-toolbar pull-right">
                        <button class="btn btn-default">
                            <i style="color:blue" class="fa fa-check"></i><span class="buttonText"> Save</span>
                        </button>
                        <button type="reset" class="btn btn-default"><i style="color:red" class="fa fa-times"></i> Reset</button>
                    </div>
                </div>

            </div>
        </form>
    </div>

</div>