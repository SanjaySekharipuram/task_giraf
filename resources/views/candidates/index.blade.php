@extends('layouts.default')
@section('content')
<div class="container">

        
    <input class="form-control me-2" id="searchInput" type="search" placeholder="Search" aria-label="Search" style="width: max-content">



<div class="container mt-5">
    <h2 class="text-center">Job List</h2>
    <div class="row" id="cards-row">

    </div>
  </div>
    <div class="modal fade" id="ajaxModelexa" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="modelHeading"></h4>
                </div>
                <div class="modal-body">
            <form role="form" id="postForm" class="form-horizontal" enctype="multipart/form-data">
                {{ csrf_field() }}
                       <input type="hidden" name="job_id" id="job_id">

                       <div class="alert alert-danger print-error-msg" style="display:none">
                            <ul></ul>
                        </div>

    
                        <div class="form-group">
                            <label for="name" class="col-sm-2 control-label">Name</label>
                            <div class="col-sm-12">
                                <input type="text" class="form-control" id="name" name="name" placeholder="Enter Name" value="" required>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="email" class="col-sm-2 control-label">Email</label>
                            <div class="col-sm-12">
                                <input type="email" class="form-control" id="email" name="email" placeholder="Enter Email" value="" required>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="phone" class="col-sm-2 control-label">Phone</label>
                            <div class="col-sm-12">
                                <input type="text" class="form-control" id="phone" name="phone" placeholder="Enter Phone" value="" required>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="resume" class="col-sm-2 control-label">Resume</label>
                            <div class="col-sm-12">
                                <input type="file" class="form-control" id="resume" name="resume" placeholder="Enter Resume" value="" required>
                            </div>
                        </div>

                        <div class="col-sm-offset-2 col-sm-10">
                         <button type="submit" class="btn btn-primary" id="savedata" value="create">Save
                         </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    
</div>

<script type="text/javascript">
    $(document).ready(function() {
        loadDataAndDisplay();
    });


    $('#searchInput').on('input', function() {
        var searchTerm = $(this).val().toLowerCase();
        $('#cards-row .col').each(function() {
            var columnText = $(this).text().toLowerCase();
            if (columnText.indexOf(searchTerm) > -1) {
                $(this).show();
            } else {
                $(this).hide();
            }
        });
    });

          
    function loadDataAndDisplay() {
        $.ajax({
            url: "{{ route('get.data') }}",
            type: "GET",
            dataType: 'json',
            success: function(data) {
                var cardsRow = $('#cards-row');
                data.forEach(function(item) {
                    var cardHtml = '<div class="col mt-5">' +
                                '<div class="card" style="width: 18rem;">' +
                                '<div class="card-body">' +
                                '<h4 class="card-title text-info">' + item.company + '</h4>' +
                                '<h6>' + item.job_title + '</h6>' +
                                '<ul>' +
                                    '<li>' + item.email + '</li>' +
                                    '<li>' + item.phone + '</li>' +
                                    '<li>' + item.location + '</li>' +
                                    '<li>' + item.job_type + '</li>' +
                                '<p class="card-text">' + item.job_description + '</p>' +
                                    '<a class="btn btn-primary applyNow" id="' + item.id + '">Apply Now</a>' +
                                '</div></div></div>';
                                
                    cardsRow.append(cardHtml);
                });
            },
            error: function(xhr) {
                console.log('Error:', xhr);
            }
        });
    }
        
    $(function() {
        $('body').on('click', '.applyNow', function() {
            var buttonId = $(this).attr('id');
                $('#savedata').val("create-post");
                $('#job_id').val(buttonId);
                $('#postForm').trigger("reset");
                $('#modelHeading').html("Apply Job");
                $('#ajaxModelexa').modal('show');
        });
  
        $('#savedata').click(function(e) {
            e.preventDefault();
            $(this).html('Saving..');

            let formData = new FormData($('#postForm')[0]);
            console.log(formData);
            $.ajax({
                data: formData,
                url: "{{ route('apply.job') }}",
                type: "POST",
                dataType: 'json',
                processData: false,
                contentType: false,
                cache: false,
                success: function(xhr) {
                    $('#postForm').trigger("reset");
                    $('#savedata').html('Save');
                    $('#ajaxModelexa').modal('hide');
                },
                error: function(xhr) {
                    $('#savedata').html('Save');
                    var response = JSON.parse(xhr.responseText);
                    printErrorMsg(response.error);
                }
            });
        });

        function printErrorMsg (msg) {
            $(".print-error-msg").find("ul").html('');
            $(".print-error-msg").css('display','block');
            $.each( msg, function( key, value ) {
                $(".print-error-msg").find("ul").append('<li>'+value+'</li>');
            });
        }

    });
</script>

@endsection