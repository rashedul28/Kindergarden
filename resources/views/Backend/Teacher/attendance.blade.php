@extends('Backend.Teacher.teacherDashboard')
@section('content1')
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css"
        integrity="sha512-xh6O/CkQoPOWDdYTDqeRdPCVd1SpvCA9XXcUnZS2FmJNp1coAFzvtCN9BmamE+4aHK8yyUHUSCcJHgXloTyT2A=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css"
        integrity="sha512-xh6O/CkQoPOWDdYTDqeRdPCVd1SpvCA9XXcUnZS2FmJNp1coAFzvtCN9BmamE+4aHK8yyUHUSCcJHgXloTyT2A=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>

	<title></title>



</head>
<body>
	<div class="row">
	<div class="col-md-3">
		<input type="date" name="cal">
	</div>

                <div class="col-md-3">
                    <select name="class_name" id="class_name" class="form-select" aria-label="Default select example">
                        <option selected>Open this for select class</option>
                       
                    </select>
                </div>
                
                <div class="col-md-3">
                    <select name="sections" id="sections" class="form-select" aria-label="Default select example">
                        <option selected>Open this for select section</option>
                         
                    </select>
                
            </div>

           <div class="col-md-3">
            <button id="add-more" name="" class="btn btn-primary ">Filter Attendance</button>
        </div>
        </div>
        <a href="" class="btn btn-success my-3" data-toggle="modal" data-target="#exampleModal">
           Registration</a>

        @include('Backend.registration_all_user')

 <script>
        $(document).ready(function() {
            $(document).on('keyup', '#search', function() {
                var query = $(this).val();
                fetch_user_data(query);
            });

            function fetch_user_data(query = '') {
                $.ajax({
                    url: "{{ route('get_user') }}",
                    method: 'GET',
                    data: {
                        query: query
                    },

                    success: function(res) {


                        $('.table-data').html(res);
                        /* $('#total_records').text(data.total_data); */
                    }
                })
            }




            $(document).on('click', '.pagination a', function(e) {
                e.preventDefault();
                let page = $(this).attr('href').split('page=')[1];
                User(page);
            })

            function User(page) {
                $.ajax({
                    url: "/pagination/paginate-data?page=" + page,
                    success: function(res) {
                        $('.table-data').html(res);
                    },
                })
            }


            $(document).on('click', '#close', function(e) {
                /* e.preventDefault(); */
                /* $("#exampleModal .close").click() */
                $('#form-submit')[0].reset();
                $('#exampleModal').modal().hide();
                $('body').removeClass('modal-open');
                $('.modal-backdrop').remove();
            });
            $(document).on('click', '#reg', function(e) {
                e.preventDefault();
                let email = $('#em').val();
                let type = $('#type').val();
                let bcn = $('#bcn').val();
                let password = $('#password').val();
                $.ajax({
                    url: "{{route('registration')}}",
                    method: 'GET',
                    data: {
                        email: email,
                        type: type,
                        bcn: bcn,
                        password: password
                    },
                    success: function(res) {
                        if (res == 'success') {
                            $('#exampleModal').modal().hide();
                            $('#form-submit')[0].reset();
                            $('table').load(location.href + ' .table');
                            $('body').removeClass('modal-open');
                            $('.modal-backdrop').remove();

                        }
                    }
                })


            });
            $('body').on('click', '#show-modal', function() {

                var urlData = $(this).data('url');
                $.get(urlData, function(data) {
                    $('#my-modal').modal('show');
                    $('#email').text(data.email);
                    $('#link').attr("href", "delete_user/" + data.id);

                });
            });

            $(document).on('click', '#cancel', function(e) {
                $('#my-modal').modal('hide');

            });

         



        });
        </script>

     
   
</body>

</html>
@endsection