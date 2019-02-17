@extends('layouts.app')

@section('content')
  @if(Auth::check())
  @if( Auth::user()->asked === 0 )
    <posts email ="{{Auth::user()->email}}" bio ="{{Auth::user()->profile_bio}}" api_token="{{Auth::user()->api_token}}" user="{{Auth::user()->id}}" posts="{{ route('posts') }}" url="{{url('/')}}"></posts>
    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Enrich your profile</h5>
          <button name="close"type="button" class="close" data-dismiss="modal" aria-label="Close">
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
              <textarea class="form-control" id="profileBio"></textarea>
            </div>

        </div>
        <div class="modal-footer">
          <button name="close" type="button" class="btn btn-secondary" data-dismiss="modal">No, thanks</button>
          <button type="button" class="btn btn-primary" onclick="sendData()">Done</button>
        </div>
      </div>
    </div>
  </div>
  @else

   <posts email ="{{Auth::user()->email}}" bio ="{{Auth::user()->profile_bio}}" api_token="{{Auth::user()->api_token}}" user="{{Auth::user()->id}}" url="{{url('/')}}" username="{{Auth::user()->name}}"></posts>
  @endif
  @else
      
  <script>window.location = "/login";</script>

  @endif
@endsection

@section('script')
@if(Auth::check())
<script type="text/javascript">
  function sendNotification(){
    var data = new FormData();
  data.append('title', document.getElementById('title').value);
  data.append('body', document.getElementById('body').value);
  var xhr = new XMLHttpRequest();
  xhr.open('POST', "{{url('/api/send-notification/'.auth()->user()->id)}}", true);
  xhr.onload = function () {
      // do something to response
      console.log(this.responseText);
  };
  xhr.send(data);
  }

  var _registration = null;

  function registerServiceWorker() {
    return navigator.serviceWorker.register('js/service-worker.js')
    .then(function(registration) {
      console.log('Service worker successfully registered.');
      _registration = registration;
      return registration;
    })
    .catch(function(err) {
      console.error('Unable to register service worker.', err);
    });
  }

  function askPermission() {
    return new Promise(function(resolve, reject) {
      const permissionResult = Notification.requestPermission(function(result) {
        resolve(result);
      });
      if (permissionResult) {
        permissionResult.then(resolve, reject);
      }
    })
    .then(function(permissionResult) {
      if (permissionResult !== 'granted') {
        throw new Error('We weren\'t granted permission.');
      }
      else{
        subscribeUserToPush();
      }
    });
  }

  function urlBase64ToUint8Array(base64String) {
    const padding = '='.repeat((4 - base64String.length % 4) % 4);
    const base64 = (base64String + padding)
      .replace(/\-/g, '+')
      .replace(/_/g, '/');
    const rawData = window.atob(base64);
    const outputArray = new Uint8Array(rawData.length);
    for (let i = 0; i < rawData.length; ++i) {
      outputArray[i] = rawData.charCodeAt(i);
    }
    return outputArray;
  }
  function getSWRegistration(){
    var promise = new Promise(function(resolve, reject) {
    // do a thing, possibly async, then…
    if (_registration != null) {
      resolve(_registration);
    }
    else {
      reject(Error("It broke"));
    }
    });
    return promise;
  }

  function subscribeUserToPush() {
    getSWRegistration()
    .then(function(registration) {
      console.log(registration);
      const subscribeOptions = {
        userVisibleOnly: true,
        applicationServerKey: urlBase64ToUint8Array(
          "{{env('VAPID_PUBLIC_KEY')}}"
        )
      };
      return registration.pushManager.subscribe(subscribeOptions);
    })
    .then(function(pushSubscription) {
      console.log('Received PushSubscription: ', JSON.stringify(pushSubscription));
      sendSubscriptionToBackEnd(pushSubscription);
      return pushSubscription;
    });
  }

  function sendSubscriptionToBackEnd(subscription) {
    return fetch('https://falanga.test/api/save-subscription/{{Auth::user()->id}}', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json'
      },
      body: JSON.stringify(subscription)
    })
    .then(function(response) {
      if (!response.ok) {
        throw new Error('Bad status code from server.');
      }
      return response.json();
    })
    .then(function(responseData) {
      if (!(responseData.data && responseData.data.success)) {
        throw new Error('Bad response from server.');
      }
    });
  }

  function enableNotifications(){
    //register service worker
    //check permission for notification/ask
    askPermission();
  }

  registerServiceWorker();

</script>
@endif


  @if(Auth::check() && Auth::user()->asked === 0 )
  <script src="{{URL::asset('js\croppie.min.js')}}"></script>
  <link rel="stylesheet" href="{{URL::asset('css\croppie.css')}}">
  <script>
        var croppie;
        var image="";
			  window.onload=function(){

          $("#myModal").on('hidden.bs.modal',function(){
            croppie.destroy();
          });

          $('button[name=close]').on('click',function(){

            $.post("{{route('asked',['id'=>Auth::user()->id])}}",{
              api_token:"{{Auth::user()->api_token}}"
            },function(e){
              console.log("closed");
            });

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
          $('#myModal').modal({backdrop: 'static', keyboard: false});
        }
        function sendData(){
          croppie.result({
            type:'base64',
            circle:false
          }
        ).then(function(data){
            $.post( "{{route('enrich_profile',['id'=>Auth::user()->id])}}",{
              api_token:"{{Auth::user()->api_token}}",
              img: data,
              bio: $("#profileBio").val()
            }, function(data) {
                  $('#myModal').modal('hide');
                  croppie.destroy();
                    });
              });

        };


</script>
@endif
@endsection
