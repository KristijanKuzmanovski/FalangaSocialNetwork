 <template>
<div class="container-fluid">
      <div class="col-md-6 gedf-main">
      <!-- posting end here -->
      <!-- testing -->
      <!-- inserting modal -->
        <!-- modal2 -->

        <div class="card gedf-card">
          <div class="card-header">
             <div class="d-flex justify-content-between align-items-center">
                            <div class="d-flex justify-content-between align-items-center">

                              <div class="mr-2">
                                <img class="rounded circle" width="45" :src="img" alt="">
                              </div>
                              <div class="ml-2">
                                  <div class="h5 m-0">{{username}}</div>
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
                                              <a v-if="user == post_user_id" class="dropdown-item" href="javascript:void(0)"   @click='deletePost(post_id)'>Delete</a>
                                              <a v-if="user == post_user_id" class="dropdown-item" href="#"  @click='prepEditPost(post_id)'>Edit</a>
                                          </div>
                                      </div>
                        </div>
                      </div>
      </div>
      <div class="card-body">
                              <div class="text-muted h7 mb-2"> <i class="fa fa-clock-o"></i>{{post_created_at}}</div>
                              <a class="card-link" href="#">
                                  <h5 class="card-title"></h5>
                              </a>

                              <p class="card-text">
                                  {{post_body}}
                                  </p>
                          </div>
      <div class="card-footer">
                              <a href="javascript:void(0);" @click="likePost(post_id)" class="card-link">
                               Like</a>
                              <span style="margin-left:4px" class="h7">{{likes}} </span>

                              <a href="javascript:void(0);" @click="dislikePost(post_id)"class="card-link">
                               Dislike</a>
                              <span style="margin-left:4px" class="h7"> {{dislikes}} </span>
                              <a style="margin-left:8px" href="javascript:void(0);" @click="viewComments(post_id)" class="card-link"><i class="fa fa-comment"></i> Comment</a>
      <div :id="'commentBox'+post_id" style="display:none">
        <input :id="'commentInput'+post_id" type="text" class="form-control" placeholder="Send a comment">
      <div v-if="editComment != true">
        <button class="btn btn-primary btn-sm " style="margin:10px 0 10px 0" type="button" @click="sendComment(post_id,username)">Send</button>
      </div>
      <div v-else="editComment == true">
      <button  class="btn btn-sm" type="btn btn-toolbar" @click="updateComment(post_id)">Save</button>
      <button  class="btn btn-sm" type="btn btn-toolbar" @click="cancelUpdateComment(post_id)">Cancel</button>
      </div>
      <div v-for='comment in showComments'>
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
</div>
 </template>

 <script>
 export default {
  data(){
    return{
      showComments:[],
      editComment:false,
      edit:false,
    };
  },
  props:{
    username:{
      type: String,
      required: true
    },
    url:{
      type: String,
      required: true
    },
    post_created_at:{
      type: String,
      required: true
    },
    user:{
      type: String,
      required: true
    },
    img:{
      type: String,
      required: true
    },
    post_id:{
      type: String,
      required: true
    },
    post_body:{
      type: String,
      required: true
    },
    likes:{
      type: String,
      required: true
    },
    dislikes:{
      type: String,
      required: true
    },
    comments:{
      type: String,
      required: true
    },
    post_user_id:{
      type: String,
      required: true
    },
    api_token:{
      type: String,
      required: true
    },
  },
  created(){
    this.listen();
  },
  methods:{
    deletePost(post){
      axios.delete('/api/delete_post/'+post,{
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
  },
  prepEditPost(post){


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
    },dislikePost(post){
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
    deleteComment(comment){
      var commentId=this.findCommentID(comment,this.post_id);
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
      this.showComments.splice(commentId,1);
    },
    prepEditComment(comment,post){
      var commentId=this.findCommentID(comment);
        this.updateCommentID=comment;
        this.editComment=true;
        document.getElementById('commentInput'+this.post_id).value=this.showComments[commentId].commentBody;
        document.getElementById('commentInput'+this.post_id).focus();
    },
    findCommentID(comment){
        var arr=this.showComments;
        for(var i=0;i<arr.length;i++){
          if(arr[i].comment_id === comment){
              return i;
          }
        }
        return null;
      },
    prepEditPost(post){
        this.postBody=this.postBody;
        this.edit=true;
        this.updatePostID=this.post_id;
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
    },
    viewComments(post){
        var div=document.getElementById('commentBox'+post);
        if(div.style.display === 'none'){
          div.style.display = 'block';
           this.sendCommentCall(post);
        }
        else{
          div.style.display = 'none';
        }
    },
    sendCommentCall(postId){
      axios.get("/api/comments/"+postId,
      {
      headers: {
      'Content-Type': 'application/json',
       },
        params:{
        api_token:this.api_token,
      }}).then((data)=>{
        console.log(data);
        this.showComments=data.data.data;
    }).catch(err=>{
        console.log(err);
      });
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
     .listen('.NewVote',(data)=>{
       console.log(data);
       console.log("HAHAHAHAHAH");

       this.likes=data.likes;
       this.dislikes=data.dislikes;

   }).listen('.UpdateCommentCount',(data)=>{
       this.comments=data.comments;
   });

   Echo.private('App.User.' + this.user)
    .notification((notification) => {
    console.log(notification);
    });
   },
   listenComments(post){
     window.Echo.private("FalangaComment."+post)
     .listen(".NewComment",(data)=>{
      console.log(data);
      this.showComments.unshift(data);
    })
    .listen('.UpdatedComment',(data)=>{
      console.log(data);
      var commentId=this.findCommentID(data.comment_id);
      this.showComments.splice(commentId,1);
      this.showComments.unshift(data);
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
  }
  }
 }
 </script>

 <style lang="css">

 </style>
