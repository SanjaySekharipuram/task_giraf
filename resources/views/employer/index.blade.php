@extends('layouts.default')
@section('content')
<div class="container">
<div class="d-flex">

    <a class="btn btn-info mr-2" href="javascript:void(0)" id="createNewJob" style="height: fit-content;"> Add New Job</a>
    
    <input class="form-control me-2" id="searchInput" type="search" placeholder="Search" aria-label="Search" style="width: max-content">
</div>



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
                    
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>

                </div>
                <div class="modal-body">
                    <form id="postForm" name="postForm" class="form-horizontal">

                       <div class="alert alert-danger print-error-msg" style="display:none">
                        <ul></ul>
                    </div>

    
                        <div class="form-group">
                            <label for="company" class="col-sm-2 control-label">Company</label>
                            <div class="col-sm-12">
                                <input type="text" class="form-control" id="company" name="company" placeholder="Enter Company Name" value="" required>
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
                            <label for="location" class="col-sm-2 control-label">Location</label>
                            <div class="col-sm-12">
                                <input type="text" class="form-control" id="location" name="location" placeholder="Enter Location" value="" required>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="job_title" class="col control-label">Job Title</label>
                            <div class="col-sm-12">
                                <input type="text" class="form-control" id="job_title" name="job_title" placeholder="Enter Job Title" value="" required>
                            </div>
                        </div>
         
                        <div class="form-group">
                            <label class="col control-label">Job Description</label>
                            <div class="col-sm-12">
                                <textarea id="job_description" name="job_description" required placeholder="Enter Job Description" class="form-control"></textarea>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="job_type" class="col control-label">Job Type</label>
                            <div class="col-sm-12">
                                <select name="job_type" id="job_type" class="form-control">
                                        <option value="1">Full Time</option>
                                        <option value="2">Part Time</option>
                                        <option value="3">Contract</option>
                                        <option value="4">Freelance</option>
                                </select>
                            </div>
                        </div>
         
                        <div class="form-group candidate" style="display: none">
                            <label class="col control-label">Candidate count</label>
                            <div class="col-sm-12">
                                <input id="candidate" name="candidate" class="form-control">
                            </div>
                        </div>
          
                        <input type="hidden" name="job_id" id="job_id">
                        <div class="col-sm-offset-2 col-sm-10">
                         <button type="submit" class="btn btn-primary" id="savedata" value="create">Save
                         </button>
                         <button type="submit" class="btn btn-primary" id="viewCandidate" value="create" style="display: none">View Candidates Details
                         </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>


    
    <div class="modal fade" id="candidateModal" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    
                    <h2 class="text-center">Candidate List</h2>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                    <div class="row" id="candidates-row">
        
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
                cardsRow.empty();

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
                                    '<a class="btn btn-primary showMore" id="' + item.id + '">Show More</a>' +
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
        $('body').on('click', '.showMore', function() {
            var buttonId = $(this).attr('id');
                $('#savedata').val("create-post");
                $('#postForm').trigger("reset");
                $('#modelHeading').html("Job Details");
                $('#ajaxModelexa').modal('show');
                $('#savedata').css('display','none');
                $('.print-error-msg').css('display','none');
                $(".candidate").css('display','block');
                $('#viewCandidate').css('display','block');

            $.ajax({
            type: "GET",
            url: "{{route('get.job_data')}}",
            data: { id : buttonId},
            dataType: "json",
            success: function(data) {
                $('#company').val(data.company).prop("readonly", true);
                $('#email').val(data.email).prop("readonly", true);
                $('#phone').val(data.phone).prop("readonly", true);
                $('#location').val(data.location).prop("readonly", true);
                $('#job_title').val(data.job_title).prop("readonly", true);
                $('#job_description').val(data.job_description).prop("readonly", true);
                $('#job_type').val(data.job_type).prop("disabled", true);
                $('#candidate').val(data.candidates_count).prop("readonly", true);
                $('#job_id').val(buttonId);
                
            },
            error: function(data) {
                alert('something went wrong');
            }
            });
        });

        $('#viewCandidate').click(function(e) {
            e.preventDefault();
            $('#candidateModal').modal('show');
            var jobId = $("#job_id").val();
                
            $.ajax({
                type: "GET",
                url: "{{route('get.candidate.details')}}",
                data: { id : jobId},
                dataType: "json",
                success: function(data) {
                    var cardsRow = $('#candidates-row');
                    cardsRow.empty();
                    data.forEach(function(item) {
                        var cardHtml = '<div class="col mt-5">' +
                                    '<div class="card">' +
                                    '<div class="card-body">' +
                                    '<h4 class="card-title text-info">' + item.name + '</h4>' +
                                    '<ul>' +
                                        '<li>' + item.email + '</li>' +
                                        '<li>' + item.phone + '</li>' +
                                        '<li>' +"Applied on :"+ item.applied_on + '</li>' +
                                    '<iframe id="' + item.id + '" src="' + asset(item.resume) + '" width="100%" height="500px"></iframe>'

                                    '</div></div></div>';
                                    
                        cardsRow.append(cardHtml);
                    });
                },
                error: function(xhr) {
                    console.log('Error:', xhr);
                }
            });
        });

        function asset(path) {
            return 'storage/' + path;
        }

        $('#createNewJob').click(function() {
            $('#savedata').val("create-post");
            $('#id').val('');
            $('#savedata').css('display','block');
            $(".candidate").css('display','none');
            $("#viewCandidate").css('display','none');
            $('#postForm').trigger("reset");
            $('#modelHeading').html("Create New Job");
            $('#ajaxModelexa').modal('show');
            $('#company').prop("readonly", false);
            $('#email').prop("readonly", false);
            $('#phone').prop("readonly", false);
            $('#location').prop("readonly", false);
            $('#job_title').prop("readonly", false);
            $('#job_description').prop("readonly", false);
            $('#job_type').prop("disabled", false);
            $('#candidate').prop("readonly", false);
        });

        

        $('#savedata').click(function(e) {
            e.preventDefault();
            $(this).html('Saving..');

            var formData = $('#postForm').serialize();
            formData += '&_token=' + '{{ csrf_token() }}';

            $.ajax({
                data: formData,
                url: "{{ route('employer.create.job') }}",
                type: "POST",
                dataType: 'json',
                success: function(xhr) {
                    $('#postForm').trigger("reset");
                    $('#savedata').html('Save');
                    $('#ajaxModelexa').modal('hide');
                    loadDataAndDisplay();
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