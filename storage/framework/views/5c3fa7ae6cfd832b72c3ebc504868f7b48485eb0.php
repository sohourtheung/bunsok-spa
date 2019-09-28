<?php $__env->startSection('content'); ?>
<section class="forms">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header d-flex align-items-center">
                        <h4><?php echo e(trans('file.Update Product')); ?></h4>
                    </div>
                    <div class="card-body">
                        <p class="italic"><small><?php echo e(trans('file.The field labels marked with * are required input fields')); ?>.</small></p>
                        <?php echo Form::open(['route' => ['products.update', $lims_product_data->id], 'method' => 'put', 'files' => true, 'id' => 'product-form']); ?>

                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label><strong><?php echo e(trans('file.Product Image')); ?></strong> </label>
                                    <input type="file" name="image" class="form-control">
                                    <?php if($errors->has('image')): ?>
                                        <span>
                                           <strong><?php echo e($errors->first('image')); ?></strong>
                                        </span>
                                    <?php endif; ?>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label><strong><?php echo e(trans('file.Product Name')); ?> *</strong> </label>
                                    <input type="text" name="name" value="<?php echo e($lims_product_data->name); ?>" required class="form-control">
                                    <?php if($errors->has('name')): ?>
                                    <span>
                                       <strong><?php echo e($errors->first('name')); ?></strong>
                                    </span>
                                    <?php endif; ?>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label><strong><?php echo e(trans('file.Product Code')); ?> </strong> </label>
                                    <div class="input-group">
                                        <input type="text" name="code" value="<?php echo e($lims_product_data->code); ?>" class="form-control">
                                        <div class="input-group-append">
                                            <button id="genbutton" type="button" class="btn btn-default"><?php echo e(trans('file.Generate')); ?></button>
                                        </div>
                                        <?php if($errors->has('code')): ?>
                                        <span>
                                           <strong><?php echo e($errors->first('code')); ?></strong>
                                        </span>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label><strong><?php echo e(trans('file.Product Type')); ?> *</strong> </label>
                                    <div class="input-group">
                                        <select name="type" required class="form-control selectpicker">
                                            <option value="standard" selected>Standard</option>
                                            <option value="combo" selected>Combo</option>
                                            <option value="digital" selected>Digital</option>
                                        </select>
                                        <input type="hidden" name="type_hidden" value="<?php echo e($lims_product_data->type); ?>">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label><strong><?php echo e(trans('file.Barcode Symbology')); ?> *</strong> </label>
                                    <div class="input-group">
                                        <input type="hidden" name="barcode_symbology_hidden" value="<?php echo e($lims_product_data->barcode_symbology); ?>">
                                        <select name="barcode_symbology" required class="form-control selectpicker">
                                            <option value="C128">Code 128</option>
                                            <option value="C39">Code 39</option>
                                            <option value="UPCA">UPC-A</option>
                                            <option value="UPCE">UPC-E</option>
                                            <option value="EAN8">EAN-8</option>
                                            <option value="EAN13">EAN-13</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div id="digital" class="col-md-6">
                                <div class="form-group">
                                    <label><strong><?php echo e(trans('file.Attach File')); ?></strong> </label>
                                    <div class="input-group">
                                        <input type="file" name="file" class="form-control">
                                    </div>
                                </div>
                            </div>
                            <div id="combo" class="col-md-8 mb-1">
                                <label><strong><?php echo e(trans('file.add_product')); ?></strong></label>
                                <div class="search-box input-group mb-3">
                                    <button class="btn btn-secondary"><i class="fa fa-barcode"></i></button>
                                    <input type="text" name="product_code_name" id="lims_productcodeSearch" placeholder="Please type product code and select..." class="form-control" />
                                </div>
                                <label><strong><?php echo e(trans('file.Combo Products')); ?></strong></label>
                                <div class="table-responsive">
                                    <table id="myTable" class="table table-hover order-list">
                                        <thead>
                                            <tr>
                                                <th><?php echo e(trans('file.product')); ?></th>
                                                <th><?php echo e(trans('file.Quantity')); ?></th>
                                                <th><?php echo e(trans('file.Unit Price')); ?></th>
                                                <th><i class="fa fa-trash"></i></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php if($lims_product_data->type == 'combo'): ?>
                                            <?php
                                            $product_list = explode(",", $lims_product_data->product_list);
                                            $qty_list = explode(",", $lims_product_data->qty_list);
                                            $price_list = explode(",", $lims_product_data->price_list);
                                            ?>
                                            <?php $__currentLoopData = $product_list; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$id): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <tr>
                                                <?php $product = \App\Product::find($id); ?>
                                                <td><?php echo e($product->name); ?> [<?php echo e($product->code); ?>]</td>
                                                <td><input type="number" class="form-control qty" name="product_qty[]" value="<?php echo e($qty_list[$key]); ?>" step="any"></td>
                                                <td><input type="number" class="form-control unit_price" name="unit_price[]" value="<?php echo e($price_list[$key]); ?>" step="any"/></td>
                                                <td><button type="button" class="ibtnDel btn btn-danger btn-sm">X</button></td>
                                                <input type="hidden" class="product-id" name="product_id[]" value="<?php echo e($id); ?>"/>
                                            </tr>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            <?php endif; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label><strong><?php echo e(trans('file.Brand')); ?></strong> </label>
                                    <div class="input-group">
                                        <input type="hidden" name="brand" value="<?php echo e($lims_product_data->brand_id); ?>">
                                      <select name="brand_id" class="selectpicker form-control" data-live-search="true" data-live-search-style="begins" title="Select Brand...">
                                        <?php $__currentLoopData = $lims_brand_list; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $brand): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($brand->id); ?>"><?php echo e($brand->title); ?></option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                      </select>
                                  </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <input type="hidden" name="category" value="<?php echo e($lims_product_data->category_id); ?>">
                                    <label><strong><?php echo e(trans('file.category')); ?> *</strong> </label>
                                    <div class="input-group">
                                      <select name="category_id" required class="selectpicker form-control" data-live-search="true" data-live-search-style="begins" title="Select Category...">
                                        <?php $__currentLoopData = $lims_category_list; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($category->id); ?>"><?php echo e($category->name); ?></option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                      </select>
                                  </div>
                                </div>
                            </div>
                            <div id="unit" class="col-md-12">
                                <div class="row ">
                                    <div class="col-md-6">
                                            <label><strong><?php echo e(trans('file.Product Unit')); ?> *</strong> </label>
                                            <div class="input-group">
                                              <select required class="form-control selectpicker" data-live-search="true" data-live-search-style="begins" title="Select unit..." name="unit_id">
                                                <?php $__currentLoopData = $lims_unit_list; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $unit): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <?php if($unit->base_unit==null): ?>
                                                        <option value="<?php echo e($unit->id); ?>"><?php echo e($unit->unit_name); ?></option>
                                                    <?php endif; ?>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                              </select>
                                              <input type="hidden" name="unit" value="<?php echo e($lims_product_data->unit_id); ?>">
                                          </div>
                                    </div>
                                    <div class="col-md-6">
                                            <label><strong><?php echo e(trans('file.Sale Unit')); ?></strong> </label>
                                            <div class="input-group">
                                              <select class="form-control selectpicker" name="sale_unit_id" id="sale-unit"> 
                                              </select>
                                              <input type="hidden" name="sale_unit" value="<?php echo e($lims_product_data->sale_unit_id); ?>">
                                          </div>
                                    </div>
                                    <div class="col-md-6 mt-2">
                                            <div class="form-group">
                                                <label><strong><?php echo e(trans('file.Purchase Unit')); ?></strong> </label>
                                                <div class="input-group">
                                                  <select class="form-control selectpicker" name="purchase_unit_id"> 
                                                  </select>
                                                  <input type="hidden" name="purchase_unit" value="<?php echo e($lims_product_data->purchase_unit_id); ?>">
                                              </div>
                                            </div>
                                    </div>                                
                                </div>                                
                            </div>
                            <div id="cost" class="col-md-6">
                                <div class="form-group">
                                    <label><strong><?php echo e(trans('file.Product Cost')); ?> *</strong> </label>
                                    <input type="number" name="cost" value="<?php echo e($lims_product_data->cost); ?>" required class="form-control" step="any">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label><strong><?php echo e(trans('file.Product Price')); ?> *</strong> </label>
                                    <input type="number" name="price" value="<?php echo e($lims_product_data->price); ?>" required class="form-control" step="any">
                                </div>
                                <div class="form-group">
                                    <input type="hidden" name="qty" value="<?php echo e($lims_product_data->qty); ?>" class="form-control">
                                </div>
                            </div>
                            <div id="alert-qty" class="col-md-6">
                                <div class="form-group">
                                    <label><strong><?php echo e(trans('file.Alert Quantity')); ?></strong> </label>
                                    <input type="number" name="alert_quantity" value="<?php echo e($lims_product_data->alert_quantity); ?>" class="form-control" step="any">
                                </div>
                            </div>
                            <div class="col-md-6 mt-3">
                                <input type="hidden" name="promotion_hidden" value="<?php echo e($lims_product_data->promotion); ?>">
                                <label><strong><?php echo e(trans('file.Promotion')); ?></strong></label>
                                <input name="promotion" type="checkbox" id="promotion" value="1">
                            </div>
                            <div class="col-md-6">
                                <div class="form-group mt-3">
                                    <label><strong><?php echo e(trans('file.Featured')); ?></strong></label>
                                    <?php if($lims_product_data->featured): ?>
                                        <input type="checkbox" name="featured" value="1" checked>
                                    <?php else: ?>
                                        <input type="checkbox" name="featured" value="1">
                                    <?php endif; ?>
                                </div>
                            </div>
                            <div class="col-md-6" id="promotion_price">    
                                <label><strong><?php echo e(trans('file.Promotional Price')); ?></strong></label>
                                <input type="number" name="promotion_price" value="<?php echo e($lims_product_data->promotion_price); ?>" class="form-control" step="any" />
                            </div>
                            <div id="start_date" class="col-md-6">
                                <div class="form-group">
                                    <label><strong><?php echo e(trans('file.Promotion Starts')); ?></strong></label>
                                    <input type="text" name="starting_date" value="<?php echo e($lims_product_data->starting_date); ?>" id="starting_date" class="form-control" />
                                </div>
                            </div>
                            <div id="last_date" class="col-md-6">
                                <div class="form-group">
                                    <label><strong><?php echo e(trans('file.Promotion Ends')); ?></strong></label>
                                    <input type="text" name="last_date" value="<?php echo e($lims_product_data->last_date); ?>" id="ending_date" class="form-control" />
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <input type="hidden" name="tax" value="<?php echo e($lims_product_data->tax_id); ?>">
                                    <label><strong><?php echo e(trans('file.product')); ?> <?php echo e(trans('file.Tax')); ?></strong> </label>
                                    <select name="tax_id" class="form-control selectpicker">
                                        <option value="">No Tax</option>
                                        <?php $__currentLoopData = $lims_tax_list; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tax): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($tax->id); ?>"><?php echo e($tax->name); ?></option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <input type="hidden" name="tax_method_id" value="<?php echo e($lims_product_data->tax_method); ?>">
                                    <label><strong><?php echo e(trans('file.Tax Method')); ?></strong> </label>
                                    <select name="tax_method" class="form-control selectpicker">
                                        <option value="1"><?php echo e(trans('file.Exclusive')); ?></option>
                                        <option value="2"><?php echo e(trans('file.Inclusive')); ?></option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-12"> 
                                <div class="form-group">
                                    <label><strong><?php echo e(trans('file.Product Details')); ?></strong></label>
                                    <textarea name="product_details" class="form-control" rows="5"><?php echo e(str_replace('@', '"', $lims_product_data->product_details)); ?></textarea>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label><strong><?php echo e(trans('file.Product Invoice Details')); ?></strong></label>
                                    <textarea name="product_invoice_details" class="form-control" rows="5"><?php echo e($lims_product_data->product_invoice_details); ?></textarea>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <input type="submit" value="<?php echo e(trans('file.submit')); ?>" class="btn btn-primary">
                                </div>
                            </div>
                        </div>
                        <?php echo Form::close(); ?>

                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<script type="text/javascript">

    $("ul#product").siblings('a').attr('aria-expanded','true');
    $("ul#product").addClass("show");

    $("#digital").hide();
    $("#combo").hide();
    $("select[name='type']").val($("input[name='type_hidden']").val());

    if($("input[name='type_hidden']").val() == "digital"){
        $("input[name='cost']").prop('required',false);
        $("select[name='unit_id']").prop('required',false);
        hide();
        $("#digital").show();
    }
    else if($("input[name='type_hidden']").val() == "combo"){
        $("input[name='cost']").prop('required', false);
        $("input[name='price']").prop('disabled', true);
        $("select[name='unit_id']").prop('required', false);
        hide();
        $("#combo").show();
    }

    var promotion = $("input[name='promotion_hidden']").val();
    if(promotion){
        $("input[name='promotion']").prop('checked', true);
        $("#promotion_price").show();
        $("#start_date").show();
        $("#last_date").show();
    }
    else {
        $("#promotion_price").hide();
        $("#start_date").hide();
        $("#last_date").hide();
    }

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $('#genbutton').on("click", function(){
      $.get('../gencode', function(data){
        $("input[name='code']").val(data);
      });
    });

    $('.selectpicker').selectpicker({
      style: 'btn-link',
    });

    tinymce.init({
      selector: 'textarea',
      height: 200,
      plugins: [
        'advlist autolink lists link image charmap print preview anchor textcolor',
        'searchreplace visualblocks code fullscreen',
        'insertdatetime media table contextmenu paste code wordcount'
      ],
      toolbar: 'insert | undo redo |  formatselect | bold italic backcolor  | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | removeformat',
      branding:false
    });

    var barcode_symbology = $("input[name='barcode_symbology_hidden']").val();
    $('select[name=barcode_symbology]').val(barcode_symbology);

    var brand = $("input[name='brand']").val();
    $('select[name=brand_id]').val(brand);

    var cat = $("input[name='category']").val();
    $('select[name=category_id]').val(cat);

    if($("input[name='unit']").val()) {
        $('select[name=unit_id]').val($("input[name='unit']").val());
        populate_unit($("input[name='unit']").val());
    }

    var tax = $("input[name='tax']").val();
    if(tax)
        $('select[name=tax_id]').val(tax);

    var tax_method = $("input[name='tax_method_id']").val();
    $('select[name=tax_method]').val(tax_method);
    $('.selectpicker').selectpicker('refresh');

    $('select[name="type"]').on('change', function() {
        if($(this).val() == 'combo'){
            $("input[name='cost']").prop('required',false);
            $("select[name='unit_id']").prop('required',false);
            hide();
            $("#digital").hide();
            $("#combo").show();
            $("input[name='price']").prop('disabled',true);
        }
        else if($(this).val() == 'digital'){
            $("input[name='cost']").prop('required',false);
            $("select[name='unit_id']").prop('required',false);
            $("input[name='file']").prop('required',true);
            hide();
            $("#combo").hide();
            $("#digital").show();
            $("input[name='price']").prop('disabled',false);
        }
        else if($(this).val() == 'standard'){
            $("input[name='cost']").prop('required',true);
            $("select[name='unit_id']").prop('required',true);
            $("input[name='file']").prop('required',false);
            $("#cost").show();
            $("#unit").show();
            $("#alert-qty").show();
            $("#digital").hide();
            $("#combo").hide();
            $("input[name='price']").prop('disabled',false);
        }
    });

    $('select[name="unit_id"]').on('change', function() {
        unitID = $(this).val();
        if(unitID) {
            populate_unit_second(unitID);
        }else{    
            $('select[name="sale_unit_id"]').empty();
            $('select[name="purchase_unit_id"]').empty();
        }                        
    });

    var lims_product_code = [ <?php $__currentLoopData = $lims_product_list; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <?php
            $productArray[] = $product->code . ' [ ' . $product->name . ' ]';
        ?>
         <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            <?php
            echo  '"'.implode('","', $productArray).'"';
            ?> ];

    var lims_productcodeSearch = $('#lims_productcodeSearch');

    lims_productcodeSearch.autocomplete({
        source: function(request, response) {
            var matcher = new RegExp(".?" + $.ui.autocomplete.escapeRegex(request.term), "i");
            response($.grep(lims_product_code, function(item) {
                return matcher.test(item);
            }));
        },
        select: function(event, ui) {
            var data = ui.item.value;
            $.ajax({
                type: 'GET',
                url: '../search',
                data: {
                    data: data
                },
                success: function(data) {
                    var flag = 1;
                    $(".product-id").each(function() {
                        if ($(this).val() == data[4]) {
                            alert('Duplicate input is not allowed!')
                            flag = 0;
                        }
                    });
                    $("input[name='product_code_name']").val('');
                    if(flag){
                        var newRow = $("<tr>");
                        var cols = '';
                        cols += '<td>' + data[0] +' [' + data[1] + ']</td>';
                        cols += '<td><input type="number" class="form-control qty" name="product_qty[]" value="1" step="any"/></td>';
                        cols += '<td><input type="number" class="form-control unit_price" name="unit_price[]" value="' + data[3] + '" step="any"/></td>';
                        cols += '<td><button type="button" class="ibtnDel btn btn-sm btn-danger">X</button></td>';
                        cols += '<input type="hidden" class="product-id" name="product_id[]" value="' + data[4] + '"/>';

                        newRow.append(cols);
                        $("table.order-list tbody").append(newRow);
                        calculate_price();
                    }
                }
            });
        }
    });

    //Change quantity or unit price
    $("#myTable").on('input', '.qty , .unit_price', function() {
        calculate_price();
    });

    //Delete product
    $("table.order-list tbody").on("click", ".ibtnDel", function(event) {
        $(this).closest("tr").remove();
        calculate_price();
    });

    function calculate_price() {
        var price = 0;
        $(".qty").each(function() {
            rowindex = $(this).closest('tr').index();
            quantity =  $(this).val();
            unit_price = $('table.order-list tbody tr:nth-child(' + (rowindex + 1) + ') .unit_price').val();
            price += quantity * unit_price;
        });
        $('input[name="price"]').val(price);
    }

    function hide() {
        $("#cost").hide();
        $("#unit").hide();
        $("#alert-qty").hide();
    }

    function populate_unit(unitID){
        $.ajax({
            url: '../saleunit/'+unitID,
            type: "GET",
            dataType: "json",

            success:function(data) {
                  $('select[name="sale_unit_id"]').empty();
                  $('select[name="purchase_unit_id"]').empty();
                  $.each(data, function(key, value) {
                      $('select[name="sale_unit_id"]').append('<option value="'+ key +'">'+ value +'</option>');
                      $('select[name="purchase_unit_id"]').append('<option value="'+ key +'">'+ value +'</option>');
                  });
                  $('.selectpicker').selectpicker('refresh');
                  var sale_unit = $("input[name='sale_unit']").val();
                  var purchase_unit = $("input[name='purchase_unit']").val();
                $('#sale-unit').val(sale_unit);
                $('select[name=purchase_unit_id]').val(purchase_unit);
                $('.selectpicker').selectpicker('refresh');
            },
        });
    }

    function populate_unit_second(unitID){
        $.ajax({
            url: '../saleunit/'+unitID,
            type: "GET",
            dataType: "json",
            success:function(data) {
                  $('select[name="sale_unit_id"]').empty();
                  $('select[name="purchase_unit_id"]').empty();
                  $.each(data, function(key, value) {
                      $('select[name="sale_unit_id"]').append('<option value="'+ key +'">'+ value +'</option>');
                      $('select[name="purchase_unit_id"]').append('<option value="'+ key +'">'+ value +'</option>');
                  });
                  $('.selectpicker').selectpicker('refresh');
            },
        });
    }

    $( "#promotion" ).on( "change", function() {
        if ($(this).is(':checked')) {
            $("#promotion_price").show();
            $("#start_date").show();
            $("#last_date").show();
        } 
        else {
            $("#promotion_price").hide();
            $("#start_date").hide();
            $("#last_date").hide();
        }
    });

    var starting_date = $('#starting_date');
    starting_date.datepicker({
     format: "dd-mm-yyyy",
     startDate: "<?php echo date('d-m-Y'); ?>",
     autoclose: true,
     todayHighlight: true
     });

    var ending_date = $('#ending_date');
    ending_date.datepicker({
     format: "dd-mm-yyyy",
     startDate: "<?php echo date('d-m-Y'); ?>",
     autoclose: true,
     todayHighlight: true
     });

    $('#product-form').on('submit',function(e){
        var product_code = $("input[name='code']").val();
        var barcode_symbology = $('select[name="barcode_symbology"]').val();
        var exp = /^\d+$/;

        if(!(product_code.match(exp)) && (barcode_symbology == 'UPCA' || barcode_symbology == 'UPCE' || barcode_symbology == 'EAN8' || barcode_symbology == 'EAN13') ) {
            alert('Product code must be numeric.');
            e.preventDefault();
        }
        else if(product_code.match(exp)) {
            if(barcode_symbology == 'UPCA' && product_code.length > 11){
                alert('Product code length must be less than 12');
                e.preventDefault();
            }
            else if(barcode_symbology == 'EAN8' && product_code.length > 7){
                alert('Product code length must be less than 8');
                e.preventDefault();
            }
            else if(barcode_symbology == 'EAN13' && product_code.length > 12){
                alert('Product code length must be less than 13');
                e.preventDefault();
            }
        }

        if($("select[name='type']").val() == 'combo') {
            var rownumber = $('table.order-list tbody tr:last').index();
            if (rownumber < 0) {
                alert("Please insert product to table!")
                e.preventDefault();
            }
        }
        $("input[name='price']").prop('disabled',false);
    });

</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layout.main', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>