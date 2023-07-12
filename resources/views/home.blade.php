@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>
                <button type="button" class="btn btn-info btn-lg" data-toggle="modal" data-target="#myModal">Send Request</button>
                    <ul class="nav nav-tabs">
                        <li class="active"><a data-toggle="tab" href="#request-list">Request List</a></li>
                        <li><a data-toggle="tab" href="#friend-list">Friend List</a></li>
                    </ul>

                    <div class="tab-content">
                        <div id="request-list" class="tab-pane fade in active">
                        <h3>Request List</h3>
                            <table class="table">
                                <tr>
                                    <td>name</td>
                                    <td>email</td>
                                    <td>Action</td>
                                </tr>
                                @foreach($friendsRequest as $requestData)
                                    @foreach($requestData->friendsRequest as $data)
                                        <tr>
                                            <td>{{ $data->name }}</td>
                                            <td>{{ $data->email }}</td>
                                            <td><a href="{{ route('approved-request',$requestData->id) }}">Approved</button></td>
                                        </tr>
                                    @endforeach
                                @endforeach
                            </table>
                        </div>
                        <div id="friend-list" class="tab-pane fade">
                        <h3>Friend List</h3>
                            <table class="table">
                                <tr>
                                    <td>name</td>
                                    <td>email</td>
                                    <td>Action</td>
                                </tr>
                                @foreach($userFriends as $friends)
                                        <tr>
                                            <td>{{ $friends->name }}</td>
                                            <td>{{ $friends->email }}</td>
                                            <td><a href="{{ route('delete-request',$friends->id) }}">Cancelled</button></td>
                                        </tr>
                                @endforeach
                            </table>
                        </div>
                    </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Modal Header</h4>
        </div>
        <div class="modal-body">
          <p>select User</p>
          <select name="user_id" id="user_id" class="form-control" id="select2-dropdown">
            <option value="">Select Option</option>
            @if(!empty($users))
                @foreach($users as $user)
                <option value="{{ $user->id }}">{{ $user->name }}</option>
                @endforeach
            @endif
        </select>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default send-request" data-dismiss="modal">Close</button>
        </div>
      </div>
      
    </div>
  </div>
</div>
@endsection

@push('scripts')
<script>
    $(document).ready(function () {
        $('#select2-dropdown').select2();
        
        $('.send-request').on('click', function (e) {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
                }
            });

            var formData = {
                receiver_id: $('#user_id').val(),
            };

            var ajaxurl = 'send-request';

            $.ajax({
               type:'POST',
               url: ajaxurl,
               data: formData,
               success:function(data) {
                  $("#msg").html(data.message);
               }
            });
        });

    });
</script>
@endpush