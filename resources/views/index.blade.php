<!DOCTYPE html>
<html lang="en">
<head>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta charset="UTF-8">
    <title>Simple Larvel 7 CRUD</title>
    <script src="{{asset('/static/js/jquery-2.1.4.min.js')}}"></script>
    <link href="{{asset('/static/bootstrap-3.0.3-dist/css/bootstrap.min.css')}}" rel="stylesheet">
    <script src="{{asset('/static/bootstrap-3.0.3-dist/js/bootstrap.min.js')}}"></script>

    <link href="{{asset('/static/toastr-master/build/toastr.min.css')}}" rel="stylesheet">
    <script src="{{asset('/static/toastr-master/build/toastr.min.js')}}"></script>
</head>

<body>
<div class="container">
    <!-- header -->
    <div class="row">
        <div class="col-md-12">
            <h1>Simple Larvel 7 CRUD</h1>
        </div>
    </div>

    <!-- button -->
    <div class="row">
        <div class="col-md-4 col-md-offset-8">
            <button class="btn btn-primary" id="add_btn">add</button>
            <button class="btn btn-danger" id="batch_delete_btn">batch delete</button>
        </div>
    </div>

    <!-- table  -->
    <div class="row">
        <div class="col-md-12">
            <table class="table table-hover" id="emps_table">
                <thead>
                <tr>
                    <th><input type="checkbox" id="check_all" /></th>
                    <th>#</th>
                    <th>employee name</th>
                    <th>gender</th>
                    <th>email</th>
                    <th>department name</th>
                    <th>operation</th>
                </tr>
                </thead>
                <tbody></tbody>
            </table>
            <ul id="pagination" class="pagination-sm"></ul>
        </div>
    </div>

    <!-- paginate  -->
    <div class="row">
        <div class="col-md-6" id="page_info_area"></div>
        <div class="col-md-6" id="page_nav_area"></div>
    </div>

    <!-- add Modal -->
    <div class="modal fade" id="add_modal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h4 class="modal-title" id="myModalLabel">employee add</h4>
                </div>
                <div class="modal-body">
                    <form class="form-horizontal">
                        <input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">
                        <div class="form-group">
                            <label for="empName_add_input" class="col-sm-4 control-label">employee name</label>
                            <div class="col-sm-8">
                                <input type="text" name="name" class="form-control"  placeholder="employee name">

                            </div>
                        </div>
                        <div class="form-group">
                            <label for="email_add_input" class="col-sm-4 control-label">email</label>
                            <div class="col-sm-8">
                                <input type="text" name="email" class="form-control" placeholder="email@yahoo.com">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="email_add_input" class="col-sm-4 control-label">gender</label>
                            <div class="col-sm-8">
                                <label class="radio-inline">
                                    <input type="radio" name="gender" value="1" checked>男
                                </label>
                                <label class="radio-inline">
                                    <input type="radio"name="gender" value="2">女
                                </label>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="email_add_input" class="col-sm-4 control-label">department name</label>
                            <div class="col-sm-4">
                                <select class="form-control" name="dept_id" ></select>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="save_btn">Save</button>
                </div>
            </div>
        </div>
    </div>

    <!-- edit Modal -->
    <div class="modal fade" id="edit_modal"  role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h4 class="modal-title" id="myModalLabel">employee edit</h4>
                </div>
                <div class="modal-body">
                    <form class="form-horizontal">
                        <input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">
                        <input type="hidden" name="id">
                        <div class="form-group">
                            <label for="empName_add_input" class="col-sm-4 control-label">employee name</label>
                            <div class="col-sm-8">
                                <input type="text" name="name" class="form-control"  placeholder="employee name">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="email_add_input" class="col-sm-4 control-label">email</label>
                            <div class="col-sm-8">
                                <input type="text" name="email" class="form-control" placeholder="email@yahoo.com">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="email_add_input" class="col-sm-4 control-label">gender</label>
                            <div class="col-sm-8">
                                <label class="radio-inline">
                                    <input type="radio" name="gender" value="1" checked="checked">男
                                </label>
                                <label class="radio-inline">
                                    <input type="radio" name="gender" value="2">女
                                </label>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="email_add_input" class="col-sm-4 control-label">department name</label>
                            <div class="col-sm-4">
                                <select class="form-control" name="dept_id" ></select>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="update_btn">Save</button>
                </div>
            </div>
        </div>
    </div>

</div>


<script>

    var total_record,current_page;

    var emps_url='{{route("emp.data")}}';
    var dept_url='{{route("dept.data")}}';
    var emp_save_url='{{route("emp.save")}}';
    var emp_url='{{asset("/emp")}}';
    var emp_update_url='{{route("emp.update")}}';

    $(function(){
        to_page(1);
    })

    function to_page(pn){
        $.ajax({
            url:emps_url,
            data:'page='+pn,
            type:'get',
            success:function (result) {
                //console.log(result)
                bulid_emps_table(result.data.data)
                build_page_info(result.data)
                build_page_nav(result.data)
            }
        })
    }

    function bulid_emps_table(result){
        $('#emps_table tbody').empty();
        $.each(result ,function (index,item) {
            var checkbox_td=$("<td><input type='checkbox' class='check_item'/></td>");
            var emp_id_td = $("<td></td>").append(item.id);
            var emp_name_td = $("<td></td>").append(item.emp_name);
            var gender_td = $("<td></td>").append(item.gender == 1 ? "男" : "女");
            var email_td = $("<td></td>").append(item.email);
            var dept_name_td = $("<td></td>").append(item.dept_name);

            var edit_btn = $("<button></button>").addClass("btn btn-primary btn-sm edit_btn").append($("<span></span>").addClass("glyphicon glyphicon-pencil")).append("edit");
            edit_btn.attr("edit-id",item.id);

            var del_btn = $("<button></button>").addClass("btn btn-danger btn-sm delete_btn").append($("<span></span>").addClass("glyphicon glyphicon-trash")).append("del");
            del_btn.attr("delete-id",item.id);

            var btn_td = $("<td></td>").append(edit_btn).append(" ").append(del_btn);

            $("<tr></tr>").append(checkbox_td).append(emp_id_td).append(emp_name_td).append(gender_td).append(email_td).append(dept_name_td).append(btn_td).appendTo("#emps_table tbody");
        })
    }

    function build_page_info(result) {
        $("#page_info_area").empty();
        $("#page_info_area").append(
            "目前在" + result.current_page + "頁，總共"
            + result.last_page + "頁，總"
            + result.total + "筆記錄");
        total_record=result.total;
        current_page=result.current_page;
    }

    function build_page_nav(result) {
        $("#page_nav_area").empty();
        var ul = $("<ul></ul>").addClass("pagination");

        var first_page_li = $("<li></li>").append($("<a></a>").append("首頁").attr("href", "#"));
        var pre_page_li = $("<li></li>").append($("<a></a>").append("&laquo;"));

        if (result.prev_page_url == null) {
            first_page_li.addClass("disabled");
            pre_page_li.addClass("disabled");
        } else {
            first_page_li.click(function() {
                to_page(1);
            });
            pre_page_li.click(function() {
                to_page(result.current_page - 1);
            });
        }

        var next_page_li = $("<li></li>").append($("<a></a>").append("&raquo;"));
        var last_page_li = $("<li></li>").append($("<a></a>").append("末頁").attr("href", "#"));
        if (result.next_page_url == null) {
            next_page_li.addClass("disabled");
            last_page_li.addClass("disabled");
        } else {
            next_page_li.click(function() {
                to_page(result.current_page + 1);
            });
            last_page_li.click(function() {
                to_page(result.last_page);
            });
        }

        ul.append(first_page_li).append(pre_page_li);

        for(var i=1 ; i <= result.last_page; i++){
            var num_li = $("<li></li>").append($("<a></a>").append(i));
            if (result.current_page == i) {
                num_li.addClass("active");
            }
            num_li.click(function() {
                to_page($(this)[0].innerText);
            });
            ul.append(num_li);
        }
        ul.append(next_page_li).append(last_page_li);
        var nav_p = $("<nav></nav>").append(ul);
        nav_p.appendTo("#page_nav_area");
    }

    $('#add_btn').click(function(){
        rest_form('#add_modal form');
        get_depts('#add_modal form select');
        $("#add_modal").modal({
            backdrop : "static"
        });
    })

    $('#save_btn').click(function () {
        $.ajax({
            url:emp_save_url,
            type:'post',
            data:$('#add_modal form').serialize(),
            success:function (result) {
                console.log(result)
                if(result.code==200){
                    $("#add_modal").modal("hide")
                    toastr.success(result.msg)
                    to_page(1)
                }
            },
            error:function (result) {
                // console.log(result)
                get_validate_msg('#add_modal', result.responseJSON.data)
            }
        })
    })


    $(document).on('click','.edit_btn',function(){
        //console.log($(this).attr('edit-id'));
        get_depts('#edit_modal select');
        get_emp($(this).attr('edit-id'));
        $("#edit_modal").modal({
            backdrop : "static"
        });
    })

    $('#update_btn').click(function () {
        $.ajax({
            url:emp_update_url,
            type:'post',
            data:$('#edit_modal form').serialize(),
            success:function(result){
                if(result.code==200){
                    $("#edit_modal").modal("hide")
                    toastr.success(result.msg)
                    to_page(1)
                }else{
                }
            },
            error:function (result) {
                // console.log(result)
                get_validate_msg('#edit_modal', result.responseJSON.data)
            }
        })
    })

    $(document).on('click','.delete_btn',function () {
        //console.log($(this).attr('delete-id'));
        var id = $(this).attr('delete-id');
        var token = $("meta[name='csrf-token']").attr("content");

        if(confirm('確認刪除嗎?')){
            $.ajax({
                url:emp_url+'/'+id,
                type:'delete',
                data: {
                    'id': id,
                    '_token': token,
                },
                success:function (result) {
                    if(result.data){
                        toastr.success(result.msg)
                        to_page(1)
                    }else{

                    }
                }
            })
        }
    })

    $('#batch_delete_btn').click(function(){

        var aa=$('.check_item:checked').length;

       if($('.check_item:checked').length==0){
           toastr.warning("請選擇")
       }else{
            var del_idstr='';

            $.each($('.check_item:checked'),function () {
                del_idstr+=$(this).parents('tr').find('td:eq(1)').text()+','
            })

            del_idstr=del_idstr.substring(0,del_idstr.length-1);

            if(confirm('確認刪除嗎?')){
                var token = $("meta[name='csrf-token']").attr("content");
                $.ajax({
                    url:emp_url+'/'+del_idstr,
                    type:'delete',
                    data: {
                        'id': del_idstr,
                        '_token': token,
                    },
                    success:function (result) {
                        if(result.data){
                           toastr.success(result.msg)
                           to_page(1)
                        }else{

                        }
                    }
                })
            }
       }
    });

    $('#check_all').click(function(){
        $('.check_item').prop('checked',$(this).prop('checked'))
    })

    $(document).on('click','.check_item',function(){
        var flag=$('.check_item:checked').length==$('.check_item').length;
        $('#check_all').prop('checked',flag);
    })

    function get_emp(emp_id){
        $.ajax({
            url:emp_url+'/'+emp_id,
            type:'get',
            success:function (result) {
                console.log(result)
                //Object { id: 15, name: "sdf", email: "sdf", gender: 1, dept_id: 1 }
                if(result.code==200){
                    $('#edit_modal input[name="id"]').val(result.data[0].id);
                    $('#edit_modal input[name="name"]').val(result.data[0].name);
                    $('#edit_modal input[name="email"]').val(result.data[0].email);
                    $('#edit_modal input[name="gender"]').val([result.data[0].gender]);
                    $('#edit_modal select[name="dept_id"]').val(result.data[0].dept_id);
                }
            }
        })
    }

    function get_depts(element){
        $(element).empty();
        $.ajax({
            url:dept_url,
            type:'get',
            success:function (result) {
                //console.log(result.data)
                $.each(result.data,function (index , item) {
                    var option_ele=$("<option></option>").append(item.name).attr("value",item.id);
                    option_ele.appendTo(element);
                })
            }
        })
    }

    function get_validate_msg(element,msg){
        $(element +' .text-danger').remove();
        $.each(msg, function(key,value){
            if(key=='name'){
                var name_error_msg=$('<span></span>').addClass('text-danger').append(value[0]);
                $(element + ' input[name="name"]').after(name_error_msg);
            }else if(key=='email'){
                var email_error_msg=$('<span></span>').addClass('text-danger').append(value[0]);
                $(element+' input[name="email"]').after(email_error_msg);
            }
        })
    }

    function rest_form(element){
        $(element)[0].reset();
    }
</script>

</body>
</html>
