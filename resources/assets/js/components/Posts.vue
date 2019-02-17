
<template>

  <!-- begin editing -->


<div class="container-fluid">
<!--<h2> Postovi</h2> -->
  <!--<textarea id="post" cols="50" rows="2" placeholder="Send a post" v-model="postBody"></textarea> -->
  <!--<div v-if="edit != true">
      <button @click="sendPost()">Post</button>
  </div>
  <div v-else="edit == true">
    <button type="button" @click='updatePost()'>Save</button>
    <button type="button" @click='cancelUpdatePost()'>Cancel</button>
  </div>-->
  <!-- added by me -->
  <div class="row">
<div class="col-md-3">
  <div class="card">
    <div class="card-body">


      <div style="text-transform:capitalize" class="h5">{{username}}</div>
      <div class="h7 text-muted">{{email}}
      </div>
       <div class="h7 text-muted">{{bio}} </div>




    </div>
    <ul class="list-group list-group-flush">
      <li class="list-group-item">
        <div class="h6 text-muted">Online users</div>
        <div v-for="userOnline in activeUsers">


      <ul style="list-style-type:none">
        <li>
          {{userOnline.name}}</li>
      </ul>
  </div>

      </li>
      <li class="list-group-item">
        <div class="h6 text-muted">
          Other Test Content
        </div>
        <div class="h5">2300</div>
      </li>
    </ul>
  </div>
</div>

<div class="col-md-6 gedf-main">
  <div class="card gedf-card">
    <div class="card-header">
      <ul class="nav nav-tabs card-header-tabs" id="myTab" role="tablist">
          <li class="nav-item">
                                <a class="nav-link active" id="posts-tab" data-toggle="tab" href="#posts" role="tab" aria-controls="posts" aria-selected="true">Make
                                    a submission</a>
                            </li>
                             <li class="nav-item">
                                <a class="nav-link" id="images-tab" data-toggle="tab" role="tab" aria-controls="images" aria-selected="false" href="#images">Images</a>
                            </li>
            </ul>

    </div>
    <div class="card-body">
                        <div class="tab-content" id="myTabContent">
                            <div class="tab-pane fade show active" id="posts" role="tabpanel" aria-labelledby="posts-tab">
                                <div class="form-group">
                                    <label class="sr-only" for="message">post</label>
                                    <textarea class="form-control" id="post" rows="3" v-model="postBody" placeholder="Share a post"></textarea>
                                </div>

                            </div>
                            <div class="tab-pane fade" id="images" role="tabpanel" aria-labelledby="images-tab">
                                <div class="form-group">
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input" id="customFile">
                                        <label class="custom-file-label" for="customFile">Upload image</label>
                                    </div>
                                </div>
                                <div class="py-4"></div>
                            </div>
                        </div>
                        <div class="btn-toolbar justify-content-between">
                            <div v-if="edit!=true" class="btn-group">

                                 <button class="btn btn-primary" @click="sendPost()">share</button>
                            </div>
                            <div v-else="edit == true">
    <button class="btn btn-primary" @click='updatePost()'>Save</button>
    <button class="btn btn-primary" @click='cancelUpdatePost()'>Cancel</button>
  </div>

                            <!--
                                  add this if we implement it

                            <div class="btn-group">


                                <button id="btnGroupDrop1" type="button" class="btn btn-link dropdown-toggle" data-toggle="dropdown" aria-haspopup="true"
                                    aria-expanded="false">
                                    <i class="fa fa-globe"></i>
                                </button>
                                  <div class="dropdown-menu dropdown-menu-right" aria-labelledby="btnGroupDrop1">
                                    <a class="dropdown-item" href="#"><i class="fa fa-globe"></i> Public</a>
                                    <a class="dropdown-item" href="#"><i class="fa fa-users"></i> Friends</a>
                                    <a class="dropdown-item" href="#"><i class="fa fa-user"></i> Just me</a>
                                </div>
                            </div>
                          -->
                        </div>
                    </div>
                </div>




<!-- posting end here -->
<!-- testing -->
<!-- inserting modal -->
 <!-- modal1 -->
  <div class="modal" id="cardLink1">
    <div class="modal-dialog">
      <div class="modal-content">

        <!-- Modal Header -->
        <div class="modal-header">
          <h4 class="modal-title">How to post</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>

        <!-- Modal body -->
        <div class="modal-body">
         To begin posting firstly the user needs to be registered and logged-in accordingly.
         The user will subsequently be prompted to enter his username, email and provide a link to a chosen profile picture.
         Upon registration the user may enter the members area where the homepage will appear.
         The homepage contains an info-box for the user, and the timeline containing all recently submitted posts.
         At the top of the timeline there is an area where the type of  the submission can be selected ( image or text submission ).
         After selecting the according type, the user may enter the contents of the post in the textbox below and click the 'share' button.
        </div>

        <!-- Modal footer -->
        <div class="modal-footer">
          <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
        </div>

      </div>
    </div>
  </div>

  <!-- modal2 -->
  <div class="modal" id="cardLink2">
    <div class="modal-dialog">
      <div class="modal-content">

        <!-- Modal Header -->
        <div class="modal-header">
          <h4 class="modal-title">How to comment</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>

        <!-- Modal body -->
        <div class="modal-body">
          To begin posting firstly the user needs to be registered and logged-in accordingly.
         The user will subsequently be prompted to enter his username, email and provide a link to a chosen profile picture.
         Upon registration the user may enter the members area where the homepage will appear.
         The homepage contains an info-box for the user, and the timeline containing all recently submitted posts.
         On every submission box there is a 'comment' button which upon clicking opens up a small textbox where the user may comment on the submission.
         After submitting the comment, the user may edit or delete the comment by clicking the 'edit' or 'delete' buttons respectively.
        </div>

        <!-- Modal footer -->
        <div class="modal-footer">
          <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
        </div>

      </div>
    </div>
  </div>


<div id="myModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Report This Post</h4>
      </div>
      <div class="modal-body">
        <p>Modal text</p>
           <form class="form-horizontal" action="" method="post">
          <fieldset>
            <legend class="text-center">Report a post</legend>

            <!-- Name -->
            <div class="form-group">
              <label class="col-md-3 control-label" for="name">Name</label>
              <div class="col-md-9">
                <span >{{username}}</span>
              </div>
            </div>



            <!-- Message  -->
            <div class="form-group">
              <label class="col-md-3 control-label" for="message">Message</label>
              <div class="col-md-9">
                <textarea class="form-control" id="message" name="message" placeholder="Please enter your message here..." rows="5"></textarea>
              </div>
            </div>

            <!-- Form actions -->
            <div class="form-group">
              <div class="col-md-12 text-right">
                <button type="submit" class="btn btn-primary btn-lg">Submit</button>
              </div>
            </div>
          </fieldset>
          </form>

        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>
<!--modal end-->


  <div class="card gedf-card" v-for="post in posts" :id="post.post_id">

    <div class="card-header">
       <div class="d-flex justify-content-between align-items-center">
                      <div class="d-flex justify-content-between align-items-center">

                        <div class="mr-2">
                          <img class="rounded circle" width="45" :src="post.profile_pic" alt="">
                        </div>
                        <div class="ml-2">
                            <div class="h5 m-0">{{post.username}}</div>
                            <!--<div class="h7 text-muted">Malevski Iksvelam Gorjan</div>-->
                          </div>
                        </div>

 <!-- div flex -->
<div>
                            <div class="dropdown">
                                    <button class="btn btn-link dropdown-toggle" type="button" id="gedf-drop1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <i class="fa fa-ellipsis-h"></i>
                                    </button>
                                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="gedf-drop1">
                                        <div class="h6 dropdown-header">Configuration</div>
                                        <a v-if="user == post.user_id" class="dropdown-item" href="javascript:void(0)"   @click='deletePost(post.post_id)'>Delete</a>
                                        <a v-if="user == post.user_id" class="dropdown-item" href="#"  @click='prepEditPost(post.post_id)'>Edit</a>
                                        <a data-toggle="modal" data-target="#myModal" class="dropdown-item" href="javascript:void(0)">Report</a>
                                    </div>
                                </div>



                  </div>

                </div>

</div>

<div class="card-body">
                        <div class="text-muted h7 mb-2"> <i class="fa fa-clock-o"></i>{{post.created_at}}</div>
                        <a class="card-link" href="#">
                            <h5 class="card-title"></h5>
                        </a>

                        <p class="card-text">
                            {{post.postBody}}
                            </p>
                    </div>
<div class="card-footer">
                        <a href="javascript:void(0);" @click="likePost(post.post_id)" class="card-link">
                         Like <i class="fa fa-thumbs-up"></i></a>
                         
                        <span style="margin-left:4px" class="h7">{{post.likes}} </span>


                        <a href="javascript:void(0);" @click="dislikePost(post.post_id)"class="card-link">
                         Dislike <i style="vertical-align:middle" class="fa fa-thumbs-down"></i></a>
                         


                        <span style="margin-left:4px" class="h7"> {{post.dislikes}} </span>
                        <a style="margin-left:8px" href="javascript:void(0);" @click="viewComments(post.post_id)" class="card-link"><i class="fa fa-comment"></i> Comment</a><span style="margin-left:4px">{{post.comments}}</span>
<div :id="'commentBox'+post.post_id" style="display:none">
  <input :id="'commentInput'+post.post_id" @input="typing(post.post_id,username)" type="text" class="form-control" placeholder="Send a comment">
<div v-if="editComment != true">
  <button class="btn btn-primary btn-sm " style="margin:10px 0 10px 0" type="button" @click="sendComment(post.post_id,username)">Send</button>
</div>
<div v-else="editComment == true">
<button  class="btn btn-sm" type="btn btn-toolbar" @click="updateComment(post.post_id)">Save</button>
<button  class="btn btn-sm" type="btn btn-toolbar" @click="cancelUpdateComment(post.post_id)">Cancel</button>
</div>
<p :id="'typing'+post.post_id" style="display:none"></p>
<div v-for='comment in post.showComments'>
      <p>
         <img :src="comment.profile_pic" style="width:50px;height:50px"/>
          <h5><a :href="url + '/profile/'+ comment.user_id" >{{comment.username}}</a></h5>
          <div v-if="user == comment.user_id">
            <button class="btn btn-primary btn-sm" type="button" @click='prepEditComment(comment.comment_id,comment.post_id)'>Edit</button>
            <button class="btn btn-primary btn-sm" type="button" @click='deleteComment(comment.comment_id,comment.post_id)'>Delete</button>
          </div>
          <p>{{comment.commentBody}}</p>
          <small>{{comment.created_at}}</small>
      </p>
    </div>
    </div>








                    </div>



</div>
</div>

            <div  class="sidebar-nav-fixed col-md-3">
                <div class="card gedf-card">
                    <div class="card-body">
                        <h5 class="card-title">Guide to posting</h5>

                        <p class="card-text">Click the link below for information about posting</p>
                        <a href="#" data-toggle="modal" data-target="#cardLink1" class="card-link">Here</a>

                    </div>
                </div>
                <div class="card gedf-card">
                        <div class="card-body">
                            <h5 class="card-title">Guide to commenting</h5>
                            <p class="card-text">Click the link below for information about commenting.</p>
                              <a href="#" data-toggle="modal" data-target="#cardLink2" class="card-link">Here</a>


                        </div>
                    </div>
            </div>
</div>

<!--<button v-if='link != null' type="button" @click='nextPage()'>Show more posts</button>-->
</div>



  <!-- end editing -->
</template>

<script type="text/javascript">
import JQuery from 'jquery'
let $ = JQuery
  export default
  {
      data()
      {
        return {
          posts: [],
          post: {
            id:'',
            username:'',
            postBody:'',
            isTyping:false,
          },
          link:'',
          postBody:'',
          edit: false,
          updatePostID:'',
          updateCommentID:'',
          editComment:false,
          typingArray:[],
          activeTypingArray:[],
          activeUsers:[]
        };
      },
      props:{
        username:{
          type: String,
          required: true
        },
        api_token:{
          type: String,
          required: true
        },
        url:{
          type: String,
          required: true
        },
        user:{
          type:String,
          required:true
        },
        email:{
          type:String,
          required:true
        },
        bio:{
          type:String,
          required:true
        }
      },
      mounted(){
        window.addEventListener('beforeunload', this.refresh);
        window.addEventListener('scroll', this.checkScroll);

      },
      created()
      {
        console.log(this.user);
        this.listen();
        this.getPosts();
      },
      updated(){
        if(window.location.hash !== 'undefined' && window.location.hash !== ''){
            this.findHash();
        }
      },
      methods: {

        checkScroll(){
        if(($(window).scrollTop() + $(window).height()) == $(document).height()){
              this.nextPage();
          }
        },
        refresh(){
            if(this.activeTypingArray.length===0){
              return;
            }else{
              for(var i=0;i<this.activeTypingArray.length;i++){
                window.Echo.private("FalangaComment."+this.activeTypingArray[i].channal).whisper('typing',{
                  channal:this.activeTypingArray[i].channal,
                  user:this.activeTypingArray[i].username,
                  typing:false
                });
              }
            }
        },
        getPosts(){
          axios.get(this.url+"/api/posts",{
            params:{
            api_token:this.api_token
          }}).then((data)=>{
            this.link=data.data.links.next;
            console.log(this.link);
            this.posts=data.data.data;
          }).catch(err=>{console.log(err);});
        },
        findHash(){
          var el=$(window.location.hash);
          if(el.length === 0){
            console.log("we here");
            this.nextPage();
          }else{
             $("html, body").stop().animate({ scrollTop:el.offset().top }, 100);
             history.replaceState(null, null, ' ');
          }
        },
        nextPage(){
          if(this.link === null)return;
          axios.get(this.link,{
            params:{
            api_token:this.api_token
          }}).then((data)=>{
            this.link=data.data.links.next;
            console.log(this.link);
            this.posts=this.posts.concat(data.data.data);
          }).catch(err=>{console.log(err);});
        },
        likePost(post){
          axios.post("/api/vote",
          {
            type:'like',
            post_id:post
          },
          {
          headers: {
         'Content-Type': 'application/json',
           },
            params:{
            api_token:this.api_token,
          }}).then((data)=>{
            console.log(data);
          }).catch(err=>{
            console.log(err);
          });
        },
        indexWhere(array, conditionFn) {
            var item = array.find(conditionFn);
            return array.indexOf(item);
        },
        dislikePost(post){
          axios.post("/api/vote",
          {
            type:'dislike',
            post_id:post
          },
          {
          headers: {
         'Content-Type': 'application/json',
           },
            params:{
            api_token:this.api_token,
          }}).then((data)=>{
            console.log(data);
          }).catch(err=>{
            console.log(err);
          });
        },
        cancelUpdateComment(post){
          this.updateCommentID='';
          this.editComment=false;
          document.getElementById('commentInput'+post).value='';
        },
        updateComment(post){
          var commentB=document.getElementById('commentInput'+post).value;
          axios.put("/api/update_comment/"+this.updateCommentID,
          {
            updateComment:commentB
          },
          {
          headers: {
         'Content-Type': 'application/json',
           },
            params:{
            api_token:this.api_token,
          }}).then((data)=>{
            console.log(data);
          }).catch(err=>{
            console.log(err);
          });

          this.updateCommentID='';
          this.editComment=false;
          document.getElementById('commentInput'+post).value='';
        },
        deleteComment(comment,post){
          var postId=this.findID(post);
          var commentId=this.findCommentID(comment,postId);
          axios.delete("/api/delete_comment/"+comment,
          {
          headers: {
         'Content-Type': 'application/json',
           },
            params:{
            api_token:this.api_token,
          }}).then((data)=>{
            console.log(data);
          }).catch(err=>{
            console.log(err);
          });
          this.posts[postId].showComments.splice(commentId,1);
        },
        prepEditComment(comment,post){
          var postId=this.findID(post);
          var commentId=this.findCommentID(comment,postId);
            this.updateCommentID=comment;
            this.editComment=true;
            document.getElementById('commentInput'+post).value=this.posts[postId].showComments[commentId].commentBody;
            document.getElementById('commentInput'+post).focus();
        },
        prepEditPost(post){
            var postId=this.findID(post);
            this.postBody=this.posts[postId].postBody;
            this.edit=true;
            this.updatePostID=this.posts[postId].post_id;
            document.getElementById('post').focus();
        },
        cancelUpdatePost(){
          this.postBody='';
          this.edit=false;
          this.updatePostID='';
        },
        updatePost(){
          var postB=document.getElementById('post').value;
          axios.put("/api/update_post/"+this.updatePostID,
          {
            updatePost:postB
          },
          {
          headers: {
         'Content-Type': 'application/json',
           },
            params:{
            api_token:this.api_token,
          }}).then((data)=>{
            console.log(data);
          }).catch(err=>{
            console.log(err);
          });

          this.postBody='';
          this.edit=false;
          this.updatePostID='';
        },
        deletePost(post){
          var postId=this.findID(post);
          axios.delete('/api/delete_post/'+post,{
            headers: {
            'Content-Type': 'application/json',
             },
              params:{
              api_token:this.api_token,
          }}
        ).then(data=>{
          console.log(data);
          this.posts.splice(postId,1);
        }).catch(err=>{
          console.log(err);
        });
      },
        sendComment(post,username){
          var comment=document.getElementById('commentInput'+post).value;
           document.getElementById('commentInput'+post).value='';
           axios.post('/api/save_comment',{
             post_id:post,
             postComment: comment
           },{
             headers: {
             'Content-Type': 'application/json',
              },
               params:{
               api_token:this.api_token,
           }}
         ).then(data=>{
           console.log(data);
         }).catch(err=>{
           console.log(err);
         });
            this.typing(post,username);
        },
        viewComments(post){
            var div=document.getElementById('commentBox'+post);
            if(div.style.display === 'none'){
              div.style.display = 'block';
               this.sendCommentCall(post);
               this.listenComments(post);
            }
            else{
              div.style.display = 'none';
              this.leaveCommentChannel(post);
            }
        },
        sendPost(){
          axios.post("/api/save_post",
          {
            sendPost:this.postBody
          },
          {
          headers: {
         'Content-Type': 'application/json',
           },
            params:{
            api_token:this.api_token,
          }}).then((data)=>{
            console.log(data);
          }).catch(err=>{
            console.log(err);
          });
          this.postBody='';
        },
        listen(){
          window.Echo.join("FalangaFeed")
          .here((users)=>{
            this.activeUsers=users;
            })
          .joining((user)=>{
            this.activeUsers.unshift(user);
            })
          .leaving((data)=>{
            this.activeUsers.splice(this.indexWhere(this.activeUsers, item => item.id === data.id),1);
            })
          .listen(".NewPost",(data)=>{
           this.posts.unshift(data);
         })
         .listen(".UpdatedPost",(data)=>{
           var postId=this.findID(data.post_id);
           if(postId!=null){
           this.posts.splice(postId,1);
           this.posts.unshift(data);
         }
         }).listen('.NewVote',(data)=>{
           var postId=this.findID(data.post_id);
           if(postId!=null){
           this.posts[postId].likes=data.likes;
           this.posts[postId].dislikes=data.dislikes;
         }
       }).listen('.UpdateCommentCount',(data)=>{
           var postId=this.findID(data.post_id);
           if(postId != null){
           this.posts[postId].comments=data.comments;
           }
       });

       Echo.private('App.User.' + this.user)
        .notification((notification) => {
        console.log(notification);
        });
       },
       sendCommentCall(postId){
         console.log(postId);
         var post=this.findID(postId);
         console.log(post);
         axios.get("/api/comments/"+postId,
         {
         headers: {
         'Content-Type': 'application/json',
          },
           params:{
           api_token:this.api_token,
         }}).then((data)=>{
           console.log(data);
           this.$set(this.posts[post],'showComments',data.data.data);
       }).catch(err=>{
           console.log(err);
         });
       },
       isActiveTyping(post,user){
         for(var i=0;i<this.activeTypingArray.length;i++){
           if(post===this.activeTypingArray[i].channal && user === this.activeTypingArray[i].username)
           return true;
         }
         this.activeTypingArray.push({
           channal:post,
           username:user
         });
         console.log(this.activeTypingArray.length);
         return false;
       },
       findActiveTyping(post,user){
         for(var i=0;i<this.activeTypingArray.length;i++){
           if(post===this.activeTypingArray[i].channal && user === this.activeTypingArray[i].username)
           return i;
         }
       },
       typing(post,username){
         if(!this.isActiveTyping(post,username)){
         window.Echo.private("FalangaComment."+post).whisper('typing',{
           channal:post,
           user:username,
           typing:true
         });
       }else{
         var comment=document.getElementById('commentInput'+post).value;
         if(comment === ''){
           window.Echo.private("FalangaComment."+post).whisper('typing',{
             channal:post,
             user:username,
             typing:false
           });
           this.activeTypingArray.splice(this.findActiveTyping(post,username),1);
          console.log("Delete "+this.activeTypingArray.length);
         }
       }
       },
       listenComments(post){
         window.Echo.private("FalangaComment."+post)
         .listen(".NewComment",(data)=>{
          console.log(data);
          var postId=this.findID(post);
          this.posts[postId].showComments.unshift(data);
        })
        .listen('.UpdatedComment',(data)=>{
          console.log(data);
          var postId=this.findID(post);
          var commentId=this.findCommentID(data.comment_id,postId);
          this.posts[postId].showComments.splice(commentId,1);
          this.posts[postId].showComments.unshift(data);

        }).listenForWhisper('typing',(user)=>{
          if(user.typing){
            $("#typing"+user.channal).show();
            this.typingArray.push({
              channal:user.channal,
              username:user.user
            });
            this.typingLogic('add',user.channal);
          }else{
            if(this.typingLogic.length===0)return;
          this.typingArray.splice(this.findIDinTyping({
              channal:user.channal,
              username:user.user
            }),1);
            this.typingLogic('remove',user.channal);
          }
        });
          console.log('Opening channel '+post);
      },
      findIDinTyping(obj){
        for(var i=0;i<this.typingArray.length;i++){
          if(this.typingArray[i].channal === obj.channal && this.typingArray[i].username === obj.username)
          return i;
        }
      },
      typingLogic(option,channal){
        if(option==='add'){
          var str='';
          var flag=true;
          for(var i=0;i<this.typingArray.length;i++){
            if(this.typingArray[i].channal===channal){
            if(flag){
            flag=false;
            str+=this.typingArray[i].username + " is typing...";
          }else{
              str=this.typingArray[i].username+", "+str;
          }
        }
          }
        $("#typing"+channal).text(str);
      }else{
        if(this.typingLogic.length===0){
          $("#typing"+channal).text('');
          $("#typing"+channal).hide();
          return;
        }
        var str='';
        var flag=true;
        for(var i=0;i<this.typingArray.length;i++){
          if(this.typingArray[i].channal===channal){
            if(flag){
            flag=false;
          str+=this.typingArray[i].username + " is typing...";
        }else{
            str=this.typingArray[i].username+", "+str;
        }
      }
        }
      $("#typing"+channal).text(str);
      }
      },
      leaveCommentChannel(post){
        window.Echo.leave("FalangaComment."+post);
        console.log('Closing channel '+post);
      },
      findID(post){
        var arr=this.posts;
        for(var i=0;i<arr.length;i++){
          if(arr[i].post_id === post){
              return i;
          }
        }
        return null;
      },
      findCommentID(comment,post){
        var arr=this.posts[post].showComments;
        for(var i=0;i<arr.length;i++){
          if(arr[i].comment_id === comment){
              return i;
          }
        }
        return null;
      }
      }
  }
</script>

<style>

</style>
