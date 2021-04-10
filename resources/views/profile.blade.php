@extends('layouts.app')
@section('content')
<div>
  @if( Auth::user()->id == $user->id )

    <!--Edit profile modal -->
    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Edit your profile</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="form-group">
            <label for="inputImg" class="col-form-label">Upload image (URL):</label>
          <input type="text" id="inputImg">
        </div>
          <div id='croppie' ></div>
          <input type="file" id='fileUpload' accept="image/x-png,image/jpeg">
            <div class="form-group">
              <label for="profileBio" class="col-form-label">Biography:</label>
              <textarea class="form-control" id="profileBio">{{$user->profile_bio}}</textarea>
            </div>

        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">No, thanks</button>
          <button type="button" class="btn btn-primary" onclick="sendData()">Done</button>
        </div>
      </div>
    </div>
  </div>

    <history-posts url='{{route("history_posts")}}' baseurl='{{url('/')}}' api_token="{{Auth::user()->api_token}}" user="{{Auth::user()->id}}" email="{{Auth::user()->email}}" bio="{{Auth::user()->profile_bio}}"  username="{{Auth::user()->name}}" ></history-posts>
@endif
</div>
@endsection

@section('script')
  @if( Auth::user()->id == $user->id )
    <script src="{{URL::asset('js\croppie.min.js')}}"></script>
    <link rel="stylesheet" href="{{URL::asset('css\croppie.css')}}">
  <script type="text/javascript">
          var croppie;
          var image="";
          window.onload=function(){

            $("#myModal").on('hidden.bs.modal',function(){
              croppie.destroy();
            });

            function createCroppie(a){
              let el=document.getElementById('croppie');
                  croppie=new Croppie(el,{
                        viewport:{ width: 200, height: 200, type: 'circle'},
                        boundary:{ width: 250, height: 250},
                        showZoomer: true,
                        enableOrientation: true
                      });
                      if(a){
                        croppie.bind( {url: a});
                      }
                    }

            $('#fileUpload').on('change',function(e){
              let files=e.target.files || e.dataTransfer.files;
              if(!files.length){
                return;
              }else{
              var image=new Image();
              var reader=new FileReader();
              var vm=this;
              reader.onload=(e)=>{
                vm.image=e.target.result;
                croppie.destroy();
                createCroppie(e.target.result);
              };
              reader.readAsDataURL(files[0]);
              }
            });

            $('#inputImg').on('blur',function(){
              croppie.bind( {url: $('#inputImg').val()});
            });

            $('#myModal').on('shown.bs.modal', function () {
                createCroppie();
                croppie.bind( {url: "{{asset("./images/profiles/".Auth::user()->profile_pic)}}"});
            });
            $('#editProfile').on('click',function(){
              $('#myModal').modal({backdrop: 'static', keyboard: false});
            });
          }

          function sendData(){
            croppie.result({
              type:'base64',
              circle:false
            }
          ).then(function(data){
              $.ajax({
                url: "{{route('profile_edit',['id'=>Auth::user()->id])}}",
                async:true,
                method:'PUT',
                headers:{"Authorization":"Bearer "+"{{Auth::user()->api_token}}" },
                data:{
                  img: data,
                  bio: $("#profileBio").val()
                },
                success:function(data){
                  $('#myModal').modal('hide');
                  location.reload();
                }
              });
          });
        }
        function vote(){
          console.log("comments load")
        }

    </script>
  @endif
@endsection
