/**
 * simply_art.js v1
 */
function _alert(message, callback){
    bootbox.alert(message);
}
function saveCenter(center_id){
    var message = '';
    var url         = admin_url + 'centers/insert_center';
    var element     = "#row-"+ center_id;
    var id          = center_id;
    var name        = $(element+" .input-name input").val();
    var address     = $(element+" .input-address input").val();
    var phone       = $(element+" .input-phone input").val();
    var active      = $(element+" .input-active select").val();

    if($.trim(name) == ''){
        message = "Vui lòng nhập tên trung tâm";
    }
    if($.trim(address) == ''){
        if(message == ''){
            message = "Vui lòng nhập địa chỉ trung tâm";
        }else{
            message = message + " và địa chỉ.";
        }
    }
    if(message != ''){
        _alert(message);
    }else {
        $.ajax({
            url: url,
            type: 'POST',
            dataType: 'json',
            data: {
                id: id,
                name: name,
                name: name,
                address: address,
                phone: phone,
                active: active
            }
        }).done(function (result) {
            if(result.success == 1){
                /*if(center_id == 0){
                    location.reload(true);
                }else{
                    $("#edit-center-" + center_id).removeClass('hide');
                    $("#save-center-" + center_id).addClass('hide');
                    var element     = "#row-"+ center_id;
                    $(element + " .text").removeClass('hide');
                    $(element + " .input").addClass('hide');
                    _alert(result.message);
                }*/
                location.reload(true);

            }else{
                _alert(result.message);
            }
            //$('#noidung').html(ketqua);
        });
    }

    if(center_id == 0){
        //location.reload(true);
    }
}
function deleteCenter(center_id){
    var url = admin_url + 'centers/delete_center';
    if(center_id > 0){
        bootbox.confirm("Do you want do delete?", function(result){
            if(result){
                $.ajax({
                    url: url,
                    type: 'POST',
                    dataType: 'json',
                    data: {
                        id: center_id
                    }
                }).done(function (result) {
                    if(result.success == 1){
                        $("#row-"+ center_id).remove();
                        _alert(result.message);
                    }else{
                        _alert('Error');
                    }

                });
            }
        });
    }
}

function editCenter(center_id){
    var element     = "#row-"+ center_id;
    $(element + " .text").addClass('hide');
    $(element + " .input").removeClass('hide');
    $("#edit-center-" + center_id).addClass('hide');
    $("#save-center-" + center_id).removeClass('hide');
}

function deleteCourse(id){
    alert(admin_url);
    var url = admin_url + 'centers/delete_course';
    if(id > 0){
        bootbox.confirm("Do you want do delete?", function(result){
            if(result){
                $.ajax({
                    url: url,
                    type: 'POST',
                    dataType: 'json',
                    data: {
                        id: id
                    }
                }).done(function (result) {
                    if(result.success == 1){
                        $("#row-"+ id).remove();
                        _alert(result.message);
                    }else{
                        _alert('Error');
                    }

                });
            }
        });
    }
}

function get_option_schedules(){
    $("#new_regis_schedule_id option").remove();
    var center_id = $("#new_regis_center_id").val();
    var course_id = $("#new_regis_course_id").val();
    if(center_id > 0 && course_id) {
        $.ajax({
            url: '/admin/centers/get_option_schedules',
            type: 'POST',
            dataType: 'json',
            data: {
                center_id: center_id,
                course_id: course_id
            }
        }).done(function (result) {
            $("#new_regis_schedule_id").append(result.option);
        });
    }
}

function get_ward_from_district(district_id){
    $(".value-ward").remove();
    if(district_id > 0){
        $.ajax({
            url: '/admin/centers/get_option_ward_from_district',
            type: 'POST',
            dataType: 'json',
            data: {
                district_id: district_id
            }
        }).done(function (result) {
            $("#ward_id").append(result.option);
        });
    }
}


$( document ).ready(function() {
    $("#new_regis_center_id, #new_regis_course_id").change(function(){
        get_option_schedules();
    });
    $("#district_id").change(function(){
        get_ward_from_district($(this).val());
    });
});