<template>
   <div class="container-fluid">
      <div class="row profile">
         <div class="col-md-3">
            <div class="profile-sidebar">
               <!-- SIDEBAR USERPIC -->
               <div class="profile-userpic">
                  <img src="https://picsum.photos/200/300
                     " class="img-responsive" alt="">
               </div>
               <!-- END SIDEBAR USERPIC -->
               <!-- SIDEBAR USER TITLE -->
               <div class="profile-usertitle">
                  <div class="profile-usertitle-name">
                     {{username}}
                  </div>
                  <div class="profile-usertitle-job">
                     {{bio}}
                  </div>
               </div>
               <!-- END SIDEBAR USER TITLE -->
               <!-- SIDEBAR BUTTONS -->
               <div class="profile-userbuttons">
                  <button type="button" class="btn btn-primary btn-sm">Edit Profile </button>
                  <button type="button" class="btn btn-primary btn-sm">Change Password</button>
               </div>
               <!-- END SIDEBAR BUTTONS -->
               <!-- SIDEBAR MENU -->
               <!-- <div class="profile-usermenu">
                  <ul class="nav2" style="list-style-type:none">
                    <li class="active">
                      <a href="#">
                       Overview </a>
                    </li>
                    <li>
                      <a href="#">
                      Account Settings </a>
                    </li>
                    <li>
                      <a href="#" target="_blank">
                      Tasks </a>
                    </li>
                    <li>
                      <a href="#">
                      Help </a>
                    </li>
                  </ul>
                  </div> -->
               <!-- END MENU -->
            </div>
         </div>
         <div class="col-md-9">
            <div class="row">
               <div class="col-md-9" style="min-height:460px; max-height:500px; overflow-y:scroll;">
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
                        Like</a>
                        <span style="margin-left:4px" class="h7">{{post.likes}} </span>
                        <a href="javascript:void(0);" @click="dislikePost(post.post_id)"class="card-link">
                        Dislike</a>
                        <span style="margin-left:4px" class="h7"> {{post.dislikes}} </span>
                        <a style="margin-left:8px" href="javascript:void(0);" @click="viewComments(post.post_id)" class="card-link"><i class="fa fa-comment"></i> Comment</a>
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
                        <h5 class="card-title">User Stats</h5>
                        <p class="card-text">Click here for a summary of your account</p>
                        <a href="#" data-toggle="modal" data-target="#dashboardModal" class="card-link">Here</a>
                     </div>
                  </div>
               </div>
            </div>
         </div>
         <!-- dashboard modal-->
         <div class="row">
            <div id="dashboardModal" class="modal fade" role="dialog">
               <div class="modal-dialog modal-lg">
                  fover
                  <div class="modal-content">
                     <div class="modal-header">
                        <h4 class="modal-title">This is a summary of {{username}}'s activities</h4>
                     </div>
                     <div class="modal-body">
                        <div class="container">
                           <h2>
                              Overview for
                              <a target="_blank" href="#">{{username}}</a>
                           </h2>
                           <p class="subtext">
                              Created his account 
                              <strong>To be implemented</strong>
                           </p>
                           <hr>
                           <div class="core-summary d-flex flex-wrap justify-content-center">
                              <div data-value="27" data-type="comments" id="numposts" class="stat-circle stat-circle--comments"></div>
                              
                              </div>
                           <hr>
                           <div class="row">
                              <div class="col-md-6">
                                 <div style="text-align:center">
                                  <i style="font-size:7rem" class="fas fa-heart"></i>  <h3><a target="_blank" href="javascript:void(0)">Your best post has </a></h3>
                                    <span id="bestPost" class="orangered-color"></span>·
                                    
                                 </div>
                              </div>
                              <div class="col-md-6">
                                 <div style="text-align:center">
                                  
                                  <i  style="font-size:7rem" class="far fa-heart"></i>
                                    <h3><a target="_blank" href="javascript:void(0)">Your worst post has </a></h3>
                                    <span id="worstPost" class="orangered-color"></span>·
                                    
                                 </div>
                              </div>

                           </div>
                        </div>
                     </div>
                     <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                     </div>
                  </div>
               </div>
            </div>
         </div>
         <!-- end of dashboard modal -->
      </div>
   </div>
</template>

<script type="text/javascript">
   export default {
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
       baseurl:{
         type:String,
         required:true
       },
       bio:{
           type:String,
         required:true
       
       },
       email:{
           type:String,
         required:true
       
       }
     },
     mounted(){
       window.addEventListener('beforeunload', this.refresh);
       window.addEventListener('scroll', this.checkScroll);
     },
     created(){
       console.log(this.user);
       this.listen();
       this.getPosts();
       this.numOfVotes();
     },
     methods: {
       checkScroll(){
       if(($(window).scrollTop() + $(window).height()) == $(document).height()){
             this.nextPage();
         }
       },  nextPage(){
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
       getPosts(){
         console.log(this.url);
         axios.get(this.url,{
           params:{
           api_token:this.api_token
         }}).then((data)=>{
           this.link=data.data.links.next;
           console.log(data);
           this.posts=data.data.data;
         }).catch(err=>{console.log(err);});
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
       numOfVotes(){
         axios.get(this.baseurl+"/api/num_of_likes",{
           params:{
           api_token:this.api_token
         }}).then((data)=>{
          console.log(data.data);
            document.getElementById("bestPost").appendChild(document.createTextNode( " " +  data.data + " likes"));

         }).catch(err=>{console.log(err);});
         axios.get(this.baseurl+"/api/num_of_dislikes",{
           params:{
           api_token:this.api_token
         }}).then((data)=>{
              document.getElementById("worstPost").appendChild(document.createTextNode( " " +  data.data + " dislikes"));
         }).catch(err=>{console.log(err);});
       },
       listen(){
         window.Echo.join("FalangaProfile")
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
          console.log(data);
          console.log("HAHAHAHAHAH");
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
     }
   }
   }
</script>
<style lang="css">
   /***
   User Profile Sidebar by @keenthemes
   A component of Metronic Theme - #1 Selling Bootstrap 3 Admin Theme in Themeforest: http://j.mp/metronictheme
   Licensed under MIT
   ***/
   body {
   background: #F1F3FA;
   }
   /* Profile container */
   .profile {
   margin: 20px 0;
   }
   /* Profile sidebar */
   .profile-sidebar {
   padding: 20px 0 10px 0;
   background: #fff;
   }
   .profile-userpic img {
   float: none;
   margin: 0 auto;
   width: 50%;
   height: 50%;
   }
   .profile-userpic {
   text-align:center;
   }
   .profile-usertitle {
   text-align: center;
   margin-top: 20px;
   }
   .profile-usertitle-name {
   color: #5a7391;
   font-size: 16px;
   font-weight: 600;
   margin-bottom: 7px;
   }
   .profile-usertitle-job {
   text-transform: uppercase;
   color: #5b9bd1;
   font-size: 12px;
   font-weight: 600;
   margin-bottom: 15px;
   }
   .profile-userbuttons {
   text-align: center;
   margin-top: 10px;
   }
   .profile-userbuttons .btn {
   text-transform: uppercase;
   font-size: 11px;
   font-weight: 600;
   padding: 6px 15px;
   margin-right: 5px;
   }
   .profile-userbuttons .btn:last-child {
   margin-right: 0px;
   }
   .profile-usermenu {
   margin-top: 30px;
   }
   .profile-usermenu ul li {
   border-bottom: 1px solid #f0f4f7;
   }
   .profile-usermenu ul li:last-child {
   border-bottom: none;
   }
   .profile-usermenu ul li a {
   color: #93a3b5;
   font-size: 14px;
   font-weight: 400;
   }
   .profile-usermenu ul li a i {
   margin-right: 8px;
   font-size: 14px;
   }
   .profile-usermenu ul li a:hover {
   background-color: #fafcfd;
   color: #5b9bd1;
   }
   .profile-usermenu ul li.active {
   border-bottom: none;
   }
   .profile-usermenu ul li.active a {
   color: #5b9bd1;
   background-color: #f6f9fb;
   border-left: 2px solid #5b9bd1;
   margin-left: -2px;
   }
   .profile-content {
   padding: 20px;
   background: #fff;
   min-height: 460px;
   }
   html, body {
   font-family: 'Roboto', 'Helvetica', sans-serif;
   }
   .demo-avatar {
   width: 48px;
   height: 48px;
   border-radius: 24px;
   }
   .demo-layout .mdl-layout__header .mdl-layout__drawer-button {
   color: rgba(0, 0, 0, 0.54);
   }
   .mdl-layout__drawer .avatar {
   margin-bottom: 16px;
   }
   .demo-drawer {
   border: none;
   }
   .demo-drawer .mdl-menu__container {
   z-index: -1;
   }
   .demo-drawer .demo-navigation {
   z-index: -2;
   }
   .demo-drawer-header {
   box-sizing: border-box;
   display: -webkit-flex;
   display: -ms-flexbox;
   display: flex;
   -webkit-flex-direction: column;
   -ms-flex-direction: column;
   flex-direction: column;
   -webkit-justify-content: flex-end;
   -ms-flex-pack: end;
   justify-content: flex-end;
   padding: 16px;
   }
   .demo-avatar-dropdown {
   display: -webkit-flex;
   display: -ms-flexbox;
   display: flex;
   position: relative;
   -webkit-flex-direction: row;
   -ms-flex-direction: row;
   flex-direction: row;
   -webkit-align-items: center;
   -ms-flex-align: center;
   align-items: center;
   width: 100%;
   }
   .demo-navigation {
   -webkit-flex-grow: 1;
   -ms-flex-positive: 1;
   flex-grow: 1;
   }
   .demo-layout .demo-navigation .mdl-navigation__link {
   display: -webkit-flex !important;
   display: -ms-flexbox !important;
   display: flex !important;
   -webkit-flex-direction: row;
   -ms-flex-direction: row;
   flex-direction: row;
   -webkit-align-items: center;
   -ms-flex-align: center;
   align-items: center;
   color: rgba(255, 255, 255, 0.56);
   font-weight: 500;
   }
   .demo-layout .demo-navigation .mdl-navigation__link:hover {
   background-color: #00BCD4;
   color: #37474F;
   }
   .demo-navigation .mdl-navigation__link .material-icons {
   font-size: 24px;
   color: rgba(255, 255, 255, 0.56);
   margin-right: 32px;
   }
   .demo-content {
   max-width: 1080px;
   }
   .demo-charts {
   -webkit-align-items: center;
   -ms-flex-align: center;
   align-items: center;
   }
   .demo-chart:nth-child(1) {
   color: #ACEC00;
   }
   .demo-chart:nth-child(2) {
   color: #00BBD6;
   }
   .demo-chart:nth-child(3) {
   color: #BA65C9;
   }
   .demo-chart:nth-child(4) {
   color: #EF3C79;
   }
   .demo-graphs {
   padding: 16px 32px;
   display: -webkit-flex;
   display: -ms-flexbox;
   display: flex;
   -webkit-flex-direction: column;
   -ms-flex-direction: column;
   flex-direction: column;
   -webkit-align-items: stretch;
   -ms-flex-align: stretch;
   align-items: stretch;
   }
   _:-ms-input-placeholder, :root .demo-graphs {
   min-height: 664px;
   }
   _:-ms-input-placeholder, :root .demo-graph {
   max-height: 300px;
   }
   .demo-graph:nth-child(1) {
   color: #00b9d8;
   }
   .demo-graph:nth-child(2) {
   color: #d9006e;
   }
   .demo-cards {
   -webkit-align-items: flex-start;
   -ms-flex-align: start;
   align-items: flex-start;
   -webkit-align-content: flex-start;
   -ms-flex-line-pack: start;
   align-content: flex-start;
   }
   .demo-cards .demo-separator {
   height: 32px;
   }
   .demo-cards .mdl-card__title.mdl-card__title {
   color: white;
   font-size: 24px;
   font-weight: 400;
   }
   .demo-cards ul {
   padding: 0;
   }
   .demo-cards h3 {
   font-size: 1em;
   }
   .demo-updates .mdl-card__title {
   min-height: 200px;
   background-position: 90% 100%;
   background-repeat: no-repeat;
   }
   .demo-cards .mdl-card__actions a {
   color: #00BCD4;
   text-decoration: none;
   }
   .demo-options h3 {
   margin: 0;
   }
   .demo-options .mdl-checkbox__box-outline {
   border-color: rgba(255, 255, 255, 0.89);
   }
   .demo-options ul {
   margin: 0;
   list-style-type: none;
   }
   .demo-options li {
   margin: 4px 0;
   }
   .demo-options .material-icons {
   color: rgba(255, 255, 255, 0.89);
   }
   .demo-options .mdl-card__actions {
   height: 64px;
   display: -webkit-flex;
   display: -ms-flexbox;
   display: flex;
   box-sizing: border-box;
   -webkit-align-items: center;
   -ms-flex-align: center;
   align-items: center;
   }
</style>